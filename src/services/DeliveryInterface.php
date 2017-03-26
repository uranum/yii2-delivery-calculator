<?php
/**
 * Created by PhpStorm.
 * User:    Евегний Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\services;


interface DeliveryInterface
{
	public function getResult();
	
	/**
	 * Собственно, это место для произведения всех расчетов
	 * на основе данных об отправлении ($cargoParams) и параметрах
	 * службы доставки ($serviceParams)
	 * Здесь нужно присвоить значения для полей:
	 *  $this->name
	 *  $this->terms
	 *  $this->resultCost
	 *  $this->info
	 * @return mixed
	 */
	public function calculate();
}