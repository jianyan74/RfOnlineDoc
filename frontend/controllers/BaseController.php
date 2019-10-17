<?php

namespace addons\RfOnlineDoc\frontend\controllers;

use Yii;
use yii\web\UnauthorizedHttpException;
use common\helpers\AddonHelper;
use common\helpers\ArrayHelper;
use common\helpers\StringHelper;
use common\controllers\AddonsController;

/**
 * 默认控制器
 *
 * Class DefaultController
 * @package addons\RfOnlineDoc\frontend\controllers
 */
class BaseController extends AddonsController
{
    /**
    * @var string
    */
    public $layout = "@addons/RfOnlineDoc/frontend/views/layouts/main";

    /**
     * @throws UnauthorizedHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $config = AddonHelper::getConfig();
        if (isset($config['ip']) && !empty($config['ip'])) {
            $ip = Yii::$app->getRequest()->getUserIP();
            $allowedIPs = StringHelper::parseAttr($config['ip']);

            if (ArrayHelper::ipInArray($ip, $allowedIPs) == false) {
                throw new UnauthorizedHttpException('没有权限访问');
            }
        }
    }
}