<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\services;


use uranum\delivery\DeliveryCargoDataInterface;
use uranum\delivery\module\models\DeliveryServices;

abstract class YiiModuleDelivery implements DeliveryInterface
{
    public $moduleParams;

    protected $serviceParams;
    protected $id;
    protected $isActive;
    protected $isShown;
    protected $locationFrom;
    protected $locationTo;
    protected $zip;
    protected $cartCost;
    protected $weight;
    protected $innerCode;
    protected $name;
    protected $terms;
    protected $resultCost;
    protected $info;

    /**
     * PickupDelivery constructor.
     *
     * @param DeliveryCargoDataInterface $cargoParams
     * @param                            $componentName
     */
    public function __construct(DeliveryCargoDataInterface $cargoParams, $componentName)
    {
        $this->moduleParams = \Yii::$app->getModule('delivery')->params;
        $this->cartCost = $cargoParams->getCartCost();
        $this->innerCode = $cargoParams->getInnerCode();
        $this->weight = $cargoParams->getWeight();
        $this->zip = $cargoParams->getZip();
        $this->locationTo = $cargoParams->getCity();
        $this->locationFrom = $this->moduleParams['locationFrom'];
        /** @var DeliveryServices $serviceParams */
        $this->serviceParams = DeliveryServices::findOne(['code' => $componentName]);
        $this->isActive = $this->serviceParams->isActive;
        $this->isShown = $this->serviceParams->serviceShownFor;
    }

    /**
     * Если доставка доступна для показа - выдается массив результата расчета
     * (здесь "расчет" предопределен в конструкторе, т.к. рассчитывать нечего)
     * Если доставку не показывать - false
     *
     * @return array|bool
     */
    public function getResult()
    {
        if ($this->validate()) {
            return [
                'id'    => $this->id,
                'name'  => $this->name,
                'terms' => $this->terms,
                'cost'  => $this->resultCost,
                'info'  => $this->info,
            ];
        } else {
            return FALSE;
        }
    }

    /**
     * Проверка возможности показать доставку
     *
     * @return bool
     */
    protected function validate(): bool
    {
        return $this->isActive && $this->canShown() ? TRUE : FALSE;
    }

    /**
     * Можно ли показывать эту доставку в зависимости он настроек сервиса
     *  самовывоз - для всех              --- показ для всех
     *  курьер - только в том же городе   --- совпадение городов && показ локально
     *  почта - только для других городов --- НЕсовпадение города && НЕ показ локально
     *
     * @return bool
     */
    protected function canShown()
    {
        if ($this->isShownForAll()) {
            return TRUE;
        } elseif ($this->isSameLocation() && $this->isShownLocally()) {
            return TRUE;
        } elseif (!$this->isSameLocation() && !$this->isShownLocally()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Совпадение городов отправки и назначения
     *
     * @return bool
     */
    protected function isSameLocation(): bool
    {
        return $this->locationFrom == $this->locationTo;
    }

    /**
     * Показ этой доставки только для города отправки
     *
     * @return bool
     */
    protected function isShownLocally(): bool
    {
        return $this->isShown == DeliveryServices::SHOWN_LOCALLY;
    }

    /**
     * Показ для всех (и для города отправки и для других регионов)
     *
     * @return bool
     */
    protected function isShownForAll(): bool
    {
        return $this->isShown == DeliveryServices::SHOWN_FOR_ALL;
    }
}