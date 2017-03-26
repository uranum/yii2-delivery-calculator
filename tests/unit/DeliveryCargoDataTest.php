<?php
/**
 * Created by PhpStorm.
 * User:    Евегний Емельянов <e9139905539@gmail.com>
 */

namespace tests\unit;


use uranum\delivery\DeliveryCargoData;
use PHPUnit\Framework\TestCase;

class DeliveryCargoDataTest extends TestCase
{
	public function testGettersWorks()
	{
		$data = new DeliveryCargoData(659300, 'Бийск', 2000, 1000, 275);
		
		$this->assertEquals(659300, $data->getZip());
		$this->assertEquals('Бийск', $data->getCity());
		$this->assertEquals(2000, $data->getCartCost());
		$this->assertEquals(1000, $data->getWeight());
		$this->assertEquals(275, $data->getInnerCode());
	}
}