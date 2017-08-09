<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\module\widgets;


use yii\web\AssetBundle;

class DeliveryAsset extends AssetBundle
{
    public $sourcePath = '@uranum/delivery/module/widgets/assets/';

    public $js = [
        'js/courier.js'
    ];

    public $depends = [
        'yii\web\YiiAsset'
    ];
}