<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\services;


use uranum\delivery\services\calculators\EnergyCalc;
use uranum\delivery\services\calculators\PlaceParams;

class EnergyDelivery extends YiiModuleDelivery
{
    /**
     * @return mixed
     */
    public function calculate()
    {
        $place = new PlaceParams($this->moduleParams['width'], $this->moduleParams['height'], $this->moduleParams['length'], $this->weight);

        $calculator = new EnergyCalc($this->zip, $this->moduleParams, $place->toArray());
        $result = $calculator->calculate();
        $this->handleResult($result);
    }

    /**
     * По техзаданию для ТК Энергия нужно убрать из результата авиа, а из оставшихся авто и ЖД оставить тот вариант, который дороже
     * @param $result
     */
    private function handleResult($result)
    {
        $this->info = $this->serviceParams->info . ' ';
        $this->id = $this->serviceParams->id;
        $this->name = $this->serviceParams->name;

        if (array_key_exists('transfer', $result)) {
            $resultWithoutAvia = $this->excludeAviaType($result);
            $maxPrice = max(array_column($resultWithoutAvia, 'price'));
            $transfer = $this->excludeMinPriceType($resultWithoutAvia, $maxPrice);
            $this->terms = $transfer['interval'];
            $this->resultCost = $transfer['price'];
        }
    }

    /**
     * @param $result
     *
     * @return array
     */
    private function excludeAviaType($result): array
    {
        return  array_filter($result['transfer'], function ($array) {
            return ($array['type'] !== "АВИА" && $array['type'] !== "");
        });
    }

    /**
     * @param $resultWithoutAvia
     * @param $maxPrice
     *
     * @return array
     */
    private function excludeMinPriceType($resultWithoutAvia, $maxPrice): array
    {
        $resultMaxCost = array_filter($resultWithoutAvia, function ($array) use ($maxPrice) {
            return ($array['price'] === $maxPrice);
        });
        return array_pop($resultMaxCost);
    }
}