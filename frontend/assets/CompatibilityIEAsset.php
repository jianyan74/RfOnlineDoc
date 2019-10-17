<?php

namespace addons\RfOnlineDoc\frontend\assets;

use yii\web\AssetBundle;

/**
 * Class CompatibilityIEAsset
 * @package backend\assets
 * @author jianyan74 <751393839@qq.com>
 */
class CompatibilityIEAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@addons/RfOnlineDoc/frontend/resources/';

    public $js = [
        'js/html5shiv.min.js',
        'js/respond.min.js',
    ];

    public $jsOptions = [
        'condition' => 'lt IE 9',
        'position' => \yii\web\View::POS_HEAD
    ];
}