<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <emel.yanov@mail.ru>
 */

namespace uranum\delivery;


class DeliveryCargoData implements DeliveryCargoDataInterface
{
	private $zip;
	private $city;
	private $cartCost;
	private $weight;
	private $innerCode;
	
	/**
	 * DeliveryCargoData constructor.
	 * Этот объект не занимается валидацией данных, они уже должны быть корректны.
	 *
	 * @param $zip
	 * @param $city
	 * @param $weight
	 * @param $cartCost
	 * @param $innerCode
	 */
	public function __construct($zip, $city, $cartCost, $weight, $innerCode)
	{
		$this->zip       = $zip;
		$this->city      = $city;
		$this->cartCost  = $cartCost;
		$this->weight    = $weight;
		$this->innerCode = $innerCode;
	}
	
	public function getZip()
	{
		return $this->zip;
	}
	
	public function getCity()
	{
		return $this->city;
	}
	
	public function getWeight()
	{
		return $this->weight;
	}
	
	public function getCartCost()
	{
		return $this->cartCost;
	}
	
	public function getInnerCode()
	{
		return $this->innerCode;
	}
}