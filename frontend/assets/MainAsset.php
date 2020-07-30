<?php


namespace frontend\assets;


use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    public $basePath = '@frontend';

    public $css = [
        'css/normalize.css',
        'css/style.css',
        'css/autocomplete.css'
    ];

    public $img = [
        'img/'
    ];

    public $js = [
        'js/main.js',
        'js/messenger.js',
        'js/vue.js',
        'js/index.js',
    ];

}