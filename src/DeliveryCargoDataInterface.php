<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery;


interface DeliveryCargoDataInterface
{
	public function getZip();
	public function getCity();
	public function getWeight();
	public function getCartCost();
	public function getInnerCode();
}