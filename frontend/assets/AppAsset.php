<?php

namespace addons\RfOnlineDoc\frontend\assets;

use yii\web\AssetBundle;

/**
 * 静态资源管理
 *
 * Class AppAsset
 * @package addons\RfOnlineDoc\frontend\assets
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@addons/RfOnlineDoc/frontend/resources/';

    public $css = [
        'css/bootstrap.min.css',
        'css/font-awesome/css/font-awesome.min.css',
        'css/Ionicons/css/ionicons.min.css',
        'css/AdminLTE.min.css',
        'css/_all-skins.min.css'
    ];

    public $js = [
        'js/bootstrap.min.js',
        'js/jquery.slimscroll.min.js',
        'js/fastclick.js',
        'js/adminlte.min.js',
        // 'js/demo.js',
        'js/readingtime.min.js',
    ];

    public $depends = [
        CompatibilityIEAsset::class,
        HeadJsAsset::class,
    ];
}