<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model uranum\delivery\module\models\DeliveryServices */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-services-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'fixedCost')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'info')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'terms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isActive')->checkbox() ?>

    <?= $form->field($model, 'serviceShownFor')->radioList($model->serviceShownForRadioList(), ['separator' => '<br>']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
