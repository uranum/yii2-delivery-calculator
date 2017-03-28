<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\services;


use uranum\delivery\services\calculators\CdekCalc;
use uranum\delivery\services\calculators\PlaceParams;

abstract class CdekDelivery extends YiiModuleDelivery implements CdekDeliveryInterface
{
	const TARIF_STORE_STORE = 136;
	const TARIF_STORE_DOOR  = 137;
	
	public function calculate()
	{
		$place      = new PlaceParams(
			$this->moduleParams['width'],
			$this->moduleParams['height'],
			$this->moduleParams['length'],
			$this->weight
		);
		$calculator = new CdekCalc(
			$this->innerCode,
			$this->zip,
			$this->chooseTarif(),
			$place,
			$this->moduleParams
		);
		
		$result = $calculator->calculate();
		$this->handleResult($result);
	}
	
	/**
	 * @param $result
	 */
	private function handleResult($result)
	{
		$this->info = $this->serviceParams->info . ' ';
		$this->name = $this->serviceParams->name;
		
		if (array_key_exists('result', $result)) {
			$this->resultCost = $result['result']['price'];
			$this->setTerms($result['result']);
		} else {
			if (is_array($result['error'])) {
				foreach ($result['error'] as $error) {
					$this->info .= $error['text'] . ' ';
				}
			}
		}
	}
	
	/**
	 * @param $result
	 */
	private function setTerms($result)
	{
		$this->terms = $result['deliveryPeriodMin'] . '-' . $result['deliveryPeriodMax'] . ' дн.';
	}
}