<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\services;


use uranum\delivery\services\calculators\CdekCalc;

class CdekDelivery extends YiiModuleDelivery
{
	const TARIF_STORE_STORE = 136;
	const TARIF_STORE_DOOR = 137;
	
	/**
	 *
	 * @return mixed
	 */
	public function calculate()
	{
		$calculator = new CdekCalc(
			$this->innerCode,
			$this->zip,
			self::TARIF_STORE_STORE,
			$this->moduleParams
		);
	}
}