<?php

use common\components\delivery\module\models\DeliveryServices;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel uranum\delivery\module\models\DeliverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Delivery Services';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-services-index">

    <h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
		<?= Html::a('Create Delivery Services', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel'  => $searchModel,
		'columns'      => [
			['class' => 'yii\grid\SerialColumn'],
			
			'id',
			'name',
			[
				'attribute' => 'fixedCost',
				'value'     => function ($model) {
					/* @var $model DeliveryServices */
					return $model->fixedCost ?: 'Берется из расчета';
				},
			],
			[
				'attribute' => 'terms',
				'value'     => function ($model) {
					/* @var $model DeliveryServices */
					return $model->terms ?: 'Берется из расчета';
				},
			],
			[
				'attribute' => 'isActive',
				'value'     => function ($model) {
					/* @var $model DeliveryServices */
					return $model->getIsActiveText();
				},
			],
			[
				'attribute' => 'serviceShownFor',
				'value'     => function ($model) {
					/* @var $model DeliveryServices */
					return $model->getServiceShownValue();
				},
			],
			'created_at:date',
			'updated_at:date',
			
			[
				'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&emsp;{delete}'
			],
		],
	]); ?>
</div>
