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
	 *
	 * @return mixed
	 */
	public function calculate()
	{
		$place = new PlaceParams(
			$this->moduleParams['width'],
			$this->moduleParams['height'],
			$this->moduleParams['length'],
			$this->weight
		);
		
		$calculator = new EnergyCalc($this->zip, $this->moduleParams, $place->toArray());
	}
}