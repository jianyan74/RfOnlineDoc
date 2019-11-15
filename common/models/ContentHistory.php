<?php

namespace addons\RfOnlineDoc\common\models;

use common\models\backend\Member;
use Yii;

/**
 * This is the model class for table "{{%addon_online_doc_content_history}}".
 *
 * @property int $id 主键
 * @property int $content_id 内容id
 * @property int $doc_id 所属文档id
 * @property string $merchant_id 商户id
 * @property string $title 标题
 * @property string $content 内容管理
 * @property int $status 状态
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class ContentHistory extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%addon_online_doc_content_history}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'doc_id', 'merchant_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'content_id' => '内容id',
            'doc_id' => '所属文档id',
            'merchant_id' => '商户id',
            'title' => '标题',
            'content' => '内容管理',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMember()
    {
        return $this->hasOne(Member::class, ['id' => 'member_id'])->select('id, username');
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->member_id = Yii::$app->user->id;
        }

        return parent::beforeSave($insert);
    }
}
