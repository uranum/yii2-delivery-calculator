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

class DeliveryInfoCourier extends Widget
{
    const PRICE_0 = 0;
    const AREA_CEN = 'cen';
    const AREA_ZHD = 'zhd';
    const AREA_DZE = 'dze';
    const AREA_ZAE = 'zae';
    const AREA_KAL = 'kal';
    const AREA_PAS = 'pas';
    const AREA_KIR = 'kir';
    const AREA_LEN = 'len';
    const AREA_OKT = 'okt';
    const AREA_GUS = 'gus';
    const AREA_KAM = 'kam';
    const AREA_PER = 'per';
    const AREA_SOV = 'sov';
    const AREA_MOC = 'moc';
    const AREA_OBG = 'obg';
    const AREA_VAS = 'vas';

    public $delivery_id;
    public $delivery_cost = 'требуется расчет';
    public $name;
    public $term;
    public $cart_cost;
    public $price_min;
    public $price_max;

    /**
     * Вывод блока одного способа доставки
     *  @var Yii::$app->session $session
     */
    public function init()
    {
        parent::init();
        /** DeliveryAsset нужно подключать в виде, где отображается этот виджет */

        echo Html::beginTag('div', ['class' => 'col-sm-6']);
        echo Html::beginTag('div', ['class' => 'panel panel-info deliv-block', 'onclick' => 'selectDelivery(this);', 'data' => ['delivery' => $this->delivery_id, 'delivery-currentCost' => $this->delivery_cost]]);
        echo Html::tag('div', $this->name, ['class' => 'text-success panel-heading']);
        echo Html::beginTag('div', ['class' => 'panel-body']);
        echo Html::tag('p', "Стоимость: <b class=\"red-text\" id=\"deliv-price\">$this->delivery_cost</b>", ['class' => 'big-red-p']);
        echo isset($this->term) ? Html::tag('p', "Сроки: $this->term", ['class' => 'big-grey-p']) : '';
        echo Html::tag('p', $this->listOfAreas());
        echo Html::endTag('div');
        echo Html::endTag('div');
        echo Html::endTag('div');
    }

    private function listOfAreas()
    {
        $options = Html::dropDownList('areas', NULL, [
            self::AREA_CEN => 'Центральный',
            self::AREA_ZHD => 'Железнодорожный',
            self::AREA_DZE => 'Дзержинский',
            self::AREA_ZAE => 'Заельцовский',
            self::AREA_KAL => 'Калининский',
            self::AREA_PAS => 'Калининский (Пашино)',
            self::AREA_KIR => 'Кировский',
            self::AREA_LEN => 'Ленинский',
            self::AREA_OKT => 'Октябрьский',
            self::AREA_GUS => 'Октябрьский район (За Гусинобродскую барахолку)',
            self::AREA_KAM => 'Октябрьский район (Камышенское плато)',
            self::AREA_PER => 'Первомайский',
            self::AREA_SOV => 'Советский',
            self::AREA_MOC => 'Мочище',
            self::AREA_OBG => 'ОбъГЭС',
            self::AREA_VAS => 'Васхнил (Краснообск)',
        ],
            [
                'id' => 'areas',
                'prompt' => 'Выберите район доставки',
                'onchange' => "calculateCourier($this->cart_cost, $this->price_min, $this->price_max, $this->delivery_id, {$this->arrayOfAreas()})",
            ]);
        return $options;
    }

    private function arrayOfAreas()
    {
        return "{
            nullAfter2000:['".
            self::AREA_ZHD."','".
            self::AREA_KIR."','".
            self::AREA_LEN."','".
            self::AREA_DZE."','".
            self::AREA_CEN."','".
            self::AREA_ZAE."','".
            self::AREA_OKT."','".
            self::AREA_GUS."','".
            self::AREA_KAM."','".
            self::AREA_KAL."'],
            nullBefore2000:['".
            self::AREA_ZHD."','".
            self::AREA_KIR."','".
            self::AREA_LEN."','".
            self::AREA_DZE."','".
            self::AREA_CEN."','".
            self::AREA_ZAE."','".
            self::AREA_OKT."','".
            self::AREA_KAL."'],
            minAfter2000:['".
            self::AREA_PAS."','".
            self::AREA_VAS."','".
            self::AREA_SOV."','".
            self::AREA_PER."','".
            self::AREA_MOC."'],
            minBefore2000:['".
            self::AREA_GUS."','".
            self::AREA_KAM."'],
            maxBefore2000:['".
            self::AREA_PAS."','".
            self::AREA_VAS."','".
            self::AREA_SOV."','".
            self::AREA_PER."','".
            self::AREA_MOC."']
        }";
    }
}