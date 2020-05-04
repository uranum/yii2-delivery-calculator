<?php

use uranum\delivery\module\Module;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model uranum\delivery\module\models\DeliveryServices */

$this->title = Module::t('module', 'Create Delivery Services');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Delivery Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-services-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
