<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace tests\unit;


use Codeception\Test\Unit;
use uranum\delivery\DeliveryCalculator;
use uranum\delivery\DeliveryCargoData;
use uranum\delivery\tests\fixtures\DeliveryFixture;
use UranumUnitTester;
use yii\helpers\VarDumper;

class DeliveryCalculatorTest extends Unit
{
	/**
	 * @var UranumUnitTester
	 */
	protected $tester;
	private   $services;
	
	public function _before()
	{
		$this->tester->haveFixtures([
			'delivery' => [
				'class' => DeliveryFixture::className(),
				'dataFile'  => codecept_data_dir() . 'delivery.php',
			],
		]);
		
		$this->services = [
			'post'       => [
				'class' => 'uranum\delivery\services\PostDelivery',
			],
			'post_naloj' => [
				'class' => 'uranum\delivery\services\PostNalojDelivery',
			],
			'cdek-store' => [
				'class' => 'uranum\delivery\services\CdekStore',
			],
			'courier'    => [
				'class' => 'uranum\delivery\services\CourierDelivery',
			],
			'pickup'     => [
				'class' => 'uranum\delivery\services\PickupDelivery',
			],
		];
	}
	
	public function testLoadAndCalculate()
	{
		$data       = new DeliveryCargoData(659300, 'Бийск', 2000, 1000, 275);
		$calculator = new DeliveryCalculator($data, $this->services);
		$result     = $calculator->calculate();
		$this->assertEquals($result['pickup'], [
			'name'  => 'Самовывоз',
			'terms' => false,
			'cost'  => 0,
			'info'  => 'Самостоятельно забираете в офисе.',
		]);
	}
	
	public function testCreateCalc()
	{
		$data       = new DeliveryCargoData(659300, 'Бийск', 2000, 1000, 275);
		$calculator = new DeliveryCalculator($data, \Yii::$app->getModule('delivery')->getComponents());
		$this->assertInstanceOf('uranum\delivery\DeliveryCalculator', $calculator);
	}
}