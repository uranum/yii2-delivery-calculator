<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\tests\unit;


use Codeception\Test\Unit;
use uranum\delivery\services\calculators\PostCalc;

class PostCalcTest extends Unit
{
	private $params;
	
	public function _before()
	{
		$this->params = [
			'siteName'    => 'inknsk.ru',
			'email'       => 'emel.yanov@mail.ru',
			'contactName' => 'Eugeny_Emelyanov',
			'insurance'   => 'f',
			'round'       => 1,
			'pr'          => 0,
			'pk'          => 0,
			'encode'      => 'utf-8',
			'sendDate'    => 'now',
			'respFormat'  => 'json',
			'country'     => 'Ru',
			'servers'     => [
				//'api.postcalc.ru',
				'test.postcalc.ru',
			],
			'httpOptions' => [
				'http' => [
					'header'     => 'Accept-Encoding: gzip',
					'timeout'    => 5,
					'user_agent' => 'PostcalcLight_1.04 ',
				],
			],
		];
	}
	
	public function testCreateCalcPost()
	{
		$calc = new PostCalc(101000, 'Новосибирск', 2650, 15000, $this->params);
		$this->assertInstanceOf('uranum\delivery\services\calculators\PostCalc', $calc);
	}
}