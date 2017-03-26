<?php
/**
 * Created by PhpStorm.
 * User:    Евегний Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\services;



class CourierDelivery extends YiiModuleDelivery
{
	
	/**
	 * Собственно это место для произведения всех расчетов
	 * на основе данных об отправлении ($cargoParams) и параметрах
	 * службы доставки ($serviceParams)
	 * Здесь нужно присвоить значения для полей:
	 *  $this->name
	 *  $this->terms
	 *  $this->resultCost
	 *  $this->info
	 */
	public function calculate()
	{
		$this->name       = $this->serviceParams->name;
		$this->terms      = $this->serviceParams->terms ? : '';
		$this->resultCost = $this->serviceParams->fixedCost ? : 0;
		$this->info       = $this->serviceParams->info ? : '';
	}
}