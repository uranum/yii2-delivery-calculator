<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\services\calculators;


class PlaceParams
{
	/**
	 * @var integer ширина места в см
	 */
	private $width;
	/**
	 * @var integer высота места в см
	 */
	private $height;
	/**
	 * @var integer длина места в см
	 */
	private $length;
	/**
	 * @var integer вес места в граммах
	 */
	private $weight;
	
	/**
	 * PlaceParams constructor.
	 *
	 * @param integer $width
	 * @param integer $height
	 * @param integer $length
	 * @param integer $weight
	 */
	public function __construct($width, $height, $length, $weight)
	{
		$this->width  = $width;
		$this->height = $height;
		$this->length = $length;
		$this->weight = $weight;
	}
	
	/**
	 * @return float
	 */
	public function getWeightInKg(): float
	{
		return floatval($this->weight / 1000);
	}
	
	/**
	 * @return float
	 */
	public function getVolumeInMetres(): float
	{
		return floatval(($this->width * $this->height * $this->length) / 1000000);
	}
}