<?php

namespace frontend\assets;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/artiggi/eshopper/css/animate.css',
        'vendor/artiggi/eshopper/css/bootstrap.min.css',
        'vendor/artiggi/eshopper/css/font-awesome.min.css',
        'vendor/artiggi/eshopper/css/main.css',
        'vendor/artiggi/eshopper/css/prettyPhoto.css',
        'vendor/artiggi/eshopper/css/price-range.css',
        'vendor/artiggi/eshopper/css/responsive.css',
        //'css/site.css',
    ];
    public $js = [
        'vendor/artiggi/eshopper/js/bootstrap.min.js',
        'vendor/artiggi/eshopper/js/contact.js',
        'vendor/artiggi/eshopper/js/gmaps.js',
        'vendor/artiggi/eshopper/js/html5shiv.js',
        'vendor/artiggi/eshopper/js/jquery.js',
        'vendor/artiggi/eshopper/js/jquery.prettyPhoto.js',
        'vendor/artiggi/eshopper/js/jquery.scrollUp.min.js',
        'vendor/artiggi/eshopper/js/main.js',
        'vendor/artiggi/eshopper/js/price-range.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
