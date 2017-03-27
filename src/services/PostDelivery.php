<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\services;


use uranum\delivery\services\calculators\PostCalc;

class PostDelivery extends YiiModuleDelivery
{
	public function calculate()
	{
		$calculator = new PostCalc(
			$this->getLocationTo(),
			$this->locationFrom,
			$this->weight,
			$this->cartCost,
			$this->moduleParams
		);
		$result = $calculator->getResult();
		
		$this->name = $this->serviceParams->name;
		$this->handleResult($result);
	}
	
	protected function handleResult($result)
	{
		if ($result instanceof \stdClass) {
			$this->resultCost = $result->Отправления->ЦеннаяПосылка->Доставка;
			$this->terms      = $result->Отправления->ЦеннаяПосылка->СрокДоставки . ' дн.';
		} else {
			$this->info = $result;
		}
	}
	
	protected function getLocationTo()
	{
		return isset($this->zip) ? $this->zip : $this->locationTo;
	}
}