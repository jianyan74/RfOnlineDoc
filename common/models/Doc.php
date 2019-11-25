<?php

namespace addons\RfOnlineDoc\common\models;

use common\behaviors\MerchantBehavior;
use common\enums\StatusEnum;
use common\helpers\StringHelper;

/**
 * This is the model class for table "{{%addon_online_doc}}".
 *
 * @property int $id
 * @property string $uuid uuid
 * @property string $merchant_id 商户id
 * @property string $title 标题
 * @property string $cover 封面
 * @property array $nav 导航菜单
 * @property string $seo_key seo关键字
 * @property string $seo_content seo内容
 * @property int $cate_id 分类id
 * @property string $description 描述
 * @property int $position 推荐位
 * @property string $content 文章内容
 * @property string $author 作者
 * @property string $price 价格
 * @property int $view 浏览量
 * @property int $is_authorized 授权访问 0无需 1可试读 2全授权可读
 * @property int $chapter_number 章节数量
 * @property int $pid 系列
 * @property int $sort 优先级
 * @property string $version 版本号
 * @property int $comment_num 评论数量
 * @property int $nice_num 点赞数量
 * @property int $status 状态
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Doc extends \common\models\base\BaseModel
{
    use MerchantBehavior;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%addon_online_doc}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['merchant_id', 'cate_id', 'position', 'view', 'is_authorized', 'chapter_number', 'pid', 'sort', 'comment_num', 'nice_num', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'author', 'version', 'cate_id'], 'required'],
            [['nav'], 'safe'],
            [['content'], 'string'],
            [['price'], 'number'],
            [['pid'], 'verifyPid'],
            [['uuid', 'cover'], 'string', 'max' => 100],
            [['title', 'seo_key', 'version'], 'string', 'max' => 50],
            [['seo_content'], 'string', 'max' => 1000],
            [['description'], 'string', 'max' => 140],
            [['author'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uuid' => 'uuid',
            'merchant_id' => '商户id',
            'title' => '标题',
            'cover' => '封面',
            'nav' => '导航菜单',
            'seo_key' => 'seo关键字',
            'seo_content' => 'seo内容',
            'cate_id' => '分类',
            'description' => '描述',
            'position' => '推荐位',
            'content' => '文章内容',
            'author' => '作者',
            'price' => '价格',
            'view' => '浏览量',
            'is_authorized' => '授权访问',
            'chapter_number' => '章节数量',
            'pid' => '系列',
            'sort' => '优先级',
            'version' => '版本号',
            'comment_num' => '评论数量',
            'nice_num' => '点赞数量',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @param $attribute
     */
    public function verifyPid($attribute)
    {
        if ($this->pid > 0) {
            $child = self::find()
                ->where(['>=', 'status', StatusEnum::DISABLED])
                ->andWhere(['pid' => $this->id])
                ->one();
            if ($child) {
                $this->addError($attribute, '已有子系列不能修改所属系列，请删除所有子系列在试');
            }
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'pid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasMany(Content::class, ['doc_id' => 'id'])
            ->select('id, uuid, doc_id, title, sort, pid')
            ->where(['status' => StatusEnum::ENABLED])
            ->orderBy('sort asc, created_at asc');
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Exception
     */
    public function beforeSave($insert)
    {
        if (!$this->uuid) {
            $this->uuid = StringHelper::uuid('uniqid');
        }
        return parent::beforeSave($insert);
    }
}
