<?php

namespace addons\RfOnlineDoc\common\models;

use yii\base\Model;

/**
 * Class SettingForm
 * @package addons\RfOnlineDoc\common\models
 */
class SettingForm extends Model
{
    public $title = '在线文档';
    public $ip;
    public $open_plaza = 1;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['open_plaza', 'integer'],
            [['ip'], 'string', 'max' => 1000],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'ip' => 'ip 白名单',
            'title' => '标题',
            'open_plaza' => '首页访问',
        ];
    }
}