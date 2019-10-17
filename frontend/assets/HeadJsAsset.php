<?php

namespace addons\RfOnlineDoc\frontend\assets;

use yii\web\AssetBundle;

/**
 * Class HeadJsAsset
 * @package backend\assets
 * @author jianyan74 <751393839@qq.com>
 */
class HeadJsAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@addons/RfOnlineDoc/frontend/resources/';

    public $js = [
         'js/jquery.min.js',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}