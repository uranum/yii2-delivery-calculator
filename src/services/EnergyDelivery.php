<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\services;


use uranum\delivery\services\calculators\EnergyCalc;
use uranum\delivery\services\calculators\PlaceParams;
use yii\helpers\VarDumper;

class EnergyDelivery extends YiiModuleDelivery
{
	private $transfers = [];
	
	public function getResult()
	{
		if ($this->validate()) {
			return $this->transfers;
		} else {
			return false;
		}
	}
	
	/**
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
		$result     = $calculator->calculate();
		$this->handleResult($result);
		//VarDumper::dump($result, 10, true);
		//die();
	}
	
	private function handleResult($result)
	{
		$this->info = $this->serviceParams->info . ' ';
		$this->name = $this->serviceParams->name;
		
		if (array_key_exists('transfer', $result)) {
			foreach ($result['transfer'] as $type) {
				$this->transfers[] = [
					'name'  => $this->serviceParams->name . '-' . $type['type'],
					'terms' => $type['interval'],
					'cost'  => $type['price'],
					'info'  => $this->serviceParams->info . ' ',
				];
			}
		} else {
			if (is_array($result['error'])) {
				$this->transfers[]['info'] = $result['error']['message'];
				
			}
		}
	}
}