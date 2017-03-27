<?php

use uranum\delivery\module\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model uranum\delivery\module\models\DeliveryServices */

$this->title = Module::t('module', 'Update Delivery Services') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Delivery Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Update');
?>
<div class="delivery-services-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
