<?php

namespace addons\RfOnlineDoc\merchant\controllers;

use common\helpers\AddonHelper;
use Yii;
use common\controllers\AddonsController;

/**
 * 默认控制器
 *
 * Class DefaultController
 * @package addons\RfOnlineDoc\merchant\controllers
 */
class BaseController extends AddonsController
{
    /**
    * @var string
    */
    // public $layout = "@addons/RfOnlineDoc/merchant/views/layouts/main";

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        // 注册资源
        AddonHelper::filePath();
    }
}