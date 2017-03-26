<?php
/**
 * Created by PhpStorm.
 * User:    Евегний Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\tests\unit;


use Codeception\Test\Unit;
use uranum\delivery\DeliveryCargoData;
use uranum\delivery\services\PickupDelivery;


class PickupDeliveryTest extends Unit
{
	public function testCreateService()
	{
		$data = new DeliveryCargoData(659300, 'Бийск', 2000, 1000, 275);
		$pickup = new PickupDelivery($data, 'pickup');
		$this->assertInstanceOf('uranum\delivery\services\PickupDelivery', $pickup);
	}
}