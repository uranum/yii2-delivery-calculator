<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
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
	 *  $this->id
	 *  $this->name
	 *  $this->terms
	 *  $this->cost
	 *  $this->info
	 * @return mixed
	 */
	public function calculate();
}