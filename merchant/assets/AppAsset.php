<?php

namespace addons\RfOnlineDoc\merchant\assets;

use yii\web\AssetBundle;

/**
 * 静态资源管理
 *
 * Class AppAsset
 * @package addons\RfOnlineDoc\merchant\assets
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@addons/RfOnlineDoc/merchant/resources/';

    public $css = [
        'css/online.doc.css'
    ];

    public $js = [
    ];

    public $depends = [
    ];
}