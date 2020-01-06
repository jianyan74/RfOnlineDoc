<?php

namespace addons\RfOnlineDoc\common\models;

use Yii;
use common\traits\Tree;
use common\behaviors\MerchantBehavior;
use common\enums\StatusEnum;
use common\helpers\ArrayHelper;
use common\helpers\TreeHelper;

/**
 * This is the model class for table "{{%addon_online_doc_content}}".
 *
 * @property int $id 主键
 * @property string $uuid uuid
 * @property int $member_id 创建者id
 * @property int $doc_id 所属文档id
 * @property string $merchant_id 商户id
 * @property string $title 标题
 * @property string $content 内容管理
 * @property int $sort 排序
 * @property int $level 级别
 * @property int $pid 上级id
 * @property string $tree 树
 * @property int $view 浏览量
 * @property int $comment_num 评论数量
 * @property int $nice_num 点赞数量
 * @property int $status 状态
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Content extends \common\models\base\BaseModel
{
    const TYPE_MARKDOWN = 1;
    const TYPE_UEDITOR = 2;

    use Tree, MerchantBehavior;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%addon_online_doc_content}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'type',
                    'doc_id',
                    'merchant_id',
                    'sort',
                    'level',
                    'pid',
                    'view',
                    'comment_num',
                    'nice_num',
                    'status',
                    'created_at',
                    'updated_at',
                ],
                'integer',
            ],
            [['title'], 'required'],
            [['content'], 'string'],
            [['uuid'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 50],
            [['tree'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'uuid' => 'uuid',
            'type' => '章节类型',
            'doc_id' => '所属文档id',
            'merchant_id' => '商户id',
            'title' => '标题',
            'content' => '内容管理',
            'sort' => '排序',
            'level' => '级别',
            'pid' => '上级id',
            'tree' => '树',
            'view' => '浏览量',
            'comment_num' => '评论数量',
            'nice_num' => '点赞数量',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取树状数据
     *
     * @return mixed
     */
    public static function getTree()
    {
        $cates = self::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->andWhere(['merchant_id' => Yii::$app->services->merchant->getId()])
            ->asArray()
            ->all();

        return ArrayHelper::itemsMerge($cates);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'pid']);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {

            $this->member_id = Yii::$app->user->id;

            if ($this->pid == 0) {
                $this->tree = TreeHelper::defaultTreeKey();
            } else {
                list($level, $tree) = $this->getParentData();
                $this->level = $level;
                $this->tree = $tree;
            }
        } else {
            // 修改父类
            if ($this->oldAttributes['pid'] != $this->pid) {
                list($level, $tree) = $this->getParentData();
                // 查找所有子级
                $list = self::find()
                    ->where(['like', 'tree', $this->tree . TreeHelper::prefixTreeKey($this->id) . '%', false])
                    ->select(['id', 'level', 'tree', 'pid'])
                    ->asArray()
                    ->all();

                $distanceLevel = $level - $this->level;
                // 递归修改
                $data = ArrayHelper::itemsMerge($list, $this->id);
                $this->recursionUpdate($data, $distanceLevel, $tree);

                $this->level = $level;
                $this->tree = $tree;
            }
        }

        // 记录历史
        if (
            !$this->isNewRecord &&
            ($this->oldAttributes['title'] !== $this->title || $this->oldAttributes['content'] !== $this->content)
        ) {
            $model = new ContentHistory();
            $model->content_id = $this->id;
            $model->doc_id = $this->doc_id;
            $model->merchant_id = $this->merchant_id;
            $model->content = $this->content;
            $model->title = $this->title;
            $model->serial_number = Yii::$app->rfOnlineDocService->contentHistory->getSerialNumberIncrByContentId($this->id) + 1;
            $model->save();
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $model = new ContentHistory();
            $model->content_id = $this->id;
            $model->doc_id = $this->doc_id;
            $model->merchant_id = $this->merchant_id;
            $model->content = $this->content;
            $model->title = $this->title;
            $model->save();
        }

        // 更新章节数量
        Yii::$app->rfOnlineDocService->doc->updateChapterNumberById($this->doc_id);

        parent::afterSave($insert, $changedAttributes);
    }
}
