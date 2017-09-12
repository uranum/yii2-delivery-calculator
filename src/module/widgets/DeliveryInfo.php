<?php
/**
 * Created by PhpStorm.
 * User:    Евегний Емельянов
 * Date:    18.11.2015
 * Time:    13:32
 * Project: ink
 *
 * Widget выводит представление одного варианта доставки с результатами расчета в админке
 */

namespace uranum\delivery\module\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class DeliveryInfo extends Widget
{
    public $delivery_id;
    public $delivery_cost;
    public $name;
    public $term;
    public $city;
    public $info;

    public function run()
    {
        $this->renderBlock();
    }

    protected function renderBlock()
    {
        echo Html::beginTag('div', ['class' => 'col-sm-6 col-md-3']);
        echo Html::beginTag('div', [
            'class'   => 'panel panel-info deliv-block',
            'onclick' => 'selectDelivery(this);',
            'data'    => [
                'delivery'             => $this->delivery_id,
                'delivery-currentCost' => $this->delivery_cost
            ],
        ]);
        echo Html::tag('div', $this->name, ['class' => 'text-success panel-heading']);
        echo Html::beginTag('div', ['class' => 'panel-body']);
        echo Html::tag('p', "Стоимость: $this->delivery_cost руб.", ['class' => 'big-red-p']);
        echo isset($this->term) ? Html::tag('p', "Сроки: $this->term", ['class' => 'big-grey-p']) : '';
        echo Html::endTag('div');
        echo Html::endTag('div');
        echo Html::endTag('div');
    }
}