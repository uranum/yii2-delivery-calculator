<?php
/**
 * Created by PhpStorm.
 * User:    Евегний Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\tests\unit;


use Codeception\Test\Unit;
use uranum\delivery\module\models\DeliveryServices;
use uranum\delivery\tests\fixtures\DeliveryFixture;

class ServiceAdminTest extends Unit
{
	/**
	 * @var \UranumUnitTester
	 */
	public $tester;
	
	public function _before()
	{
		$this->tester->haveFixtures([
			'delivery' => [
				'class'    => DeliveryFixture::className(),
				'dataFile' => codecept_data_dir() . 'delivery.php',
			],
		]);
	}
	
	public function testUpdateServiceWithCorrectData()
	{
		$delivery = DeliveryServices::findOne(['code' => 'cdek']);
		$delivery->load([
			'DeliveryServices' =>
				[
					'name'            => 'Энергия',
					'code'            => 'energy',
					'isActive'        => 1,
					'fixedCost'       => 250,
					'info'            => 'недорого',
					'terms'           => '2-3',
					'serviceShownFor' => '1',
				],
		]);
		expect($delivery->save())->true();
		
		$delivery2 = DeliveryServices::findOne(['code' => 'cdek']);
		expect($delivery2)->null();
		
		$delivery3 = DeliveryServices::findOne(['code' => 'energy']);
		expect($delivery3->name)->equals('Энергия');
	}
	
	public function testUpdateServiceWithWrongData()
	{
		$delivery = DeliveryServices::findOne(['code' => 'cdek']);
		$delivery->load([
			'DeliveryServices' =>
				[
					'name'            => '',
					'code'            => 5,
					'isActive'        => 'asd',
					'fixedCost'       => '',
					'info'            => '',
					'terms'           => '',
					'serviceShownFor' => '1',
				],
		]);
		$delivery->validate();
		expect($delivery->errors)->hasKey('name');
		expect($delivery->errors)->hasKey('code');
		expect($delivery->errors)->hasKey('isActive');
		expect($delivery->errors)->hasntKey('fixedCost');
		expect($delivery->errors)->hasntKey('info');
		expect($delivery->errors)->hasntKey('terms');
		expect($delivery->save())->false();
	}
	
	public function testCreateServiceWithWrongData()
	{
		$delivery = new DeliveryServices();
		$delivery->load([
			'DeliveryServices' =>
				[
					'name'            => '',
					'code'            => 5,
					'isActive'        => 'asd',
					'fixedCost'       => '',
					'info'            => '',
					'terms'           => '',
					'serviceShownFor' => '1',
				],
		]);
		$delivery->validate();
		expect($delivery->errors)->hasKey('name');
		expect($delivery->errors)->hasKey('code');
		expect($delivery->errors)->hasKey('isActive');
		expect($delivery->errors)->hasntKey('fixedCost');
		expect($delivery->errors)->hasntKey('info');
		expect($delivery->errors)->hasntKey('terms');
		expect($delivery->save())->false();
	}
	
	public function testCreateServiceWithCorrectData()
	{
		$delivery = new DeliveryServices();
		$delivery->load([
			'DeliveryServices' =>
				[
					'name'            => 'Доставка',
					'code'            => 'shipping',
					'isActive'        => 1,
					'fixedCost'       => 300,
					'info'            => null,
					'terms'           => null,
					'serviceShownFor' => 2,
				],
		]);
		expect($delivery->save())->true();
		$delivery = DeliveryServices::findOne(['code' => 'shipping']);
		expect($delivery)->isInstanceOf(DeliveryServices::className());
	}
}