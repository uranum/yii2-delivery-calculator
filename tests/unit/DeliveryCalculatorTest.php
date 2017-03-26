<?php
/**
 * Created by PhpStorm.
 * User:    Евегний Емельянов <e9139905539@gmail.com>
 */

namespace tests\unit;


use Codeception\Test\Unit;
use uranum\delivery\DeliveryCalculator;
use uranum\delivery\DeliveryCargoData;

class DeliveryCalculatorTest extends Unit
{
	
	public function testLoadAndCalculate()
	{
		$data       = new DeliveryCargoData(659300, 'Бийск', 2000, 1000, 275);
		$calculator = new DeliveryCalculator($data, \Yii::$app->getModule('delivery')->getComponents());
		$result = $calculator->calculate();
		$this->assertEquals($result[3], [
			'name'  => 'Самовывоз',
			'terms' => false,
			'cost'  => 0,
			'info'  => 'Самостоятельно забираете в офисе.',
		]);
		
	}
}