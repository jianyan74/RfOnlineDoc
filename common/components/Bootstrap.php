<?php

namespace addons\RfOnlineDoc\common\components;

use Yii;
use common\interfaces\AddonWidget;

/**
 * Bootstrap
 *
 * Class Bootstrap
 * @package addons\RfOnlineDoc\common\config
 */
class Bootstrap implements AddonWidget
{
    /**
     * @param $addon
     * @return mixed|void
     * @throws \yii\base\InvalidConfigException
     */
    public function run($addon)
    {
        // 动态注入服务
        Yii::$app->set('docServices', [
            'class' => 'addons\RfOnlineDoc\services\Application',
        ]);
    }
}