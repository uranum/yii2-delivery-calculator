<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\services;



class PickupDelivery extends YiiModuleDelivery
{
	
	public function calculate()
	{
		$this->id       = $this->serviceParams->id;
		$this->name       = $this->serviceParams->name;
		$this->info       = $this->serviceParams->info ? : '';
		$this->resultCost = $this->serviceParams->fixedCost ? : 0;
		$this->terms      = false;
	}
	
}