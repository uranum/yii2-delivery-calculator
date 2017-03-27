<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\services\calculators;


class CdekCalc
{
	/**
	 * @var string версия модуля
	 */
	private $version = '1.0';
	/**
	 * @var string login
	 */
	private $authLogin;
	/**
	 * @var string password
	 */
	private $authPassword;
	/**
	 * @var string Получается следующим образом: md5($dateExecute."&".$authPassword)
	 */
	private $secure;
	/**
	 * @var string планируемая дата оправки заказа в формате “ГГГГ-ММ-ДД”
	 */
	public $dateExecute;
	/**
	 * @var integer код города-отправителя в соответствии с кодами городов, предоставляемых компанией СДЭК
	 */
	private $senderCityId;
	/**
	 * @var integer 6 знаков, почтовый индекс города-отправителя
	 */
	private $senderCityPostCode;
	/**
	 * @var integer код города-получателя в соответствии с кодами городов, предоставляемых компанией СДЭК
	 */
	private $receiverCityId;
	/**
	 * @var integer 6 знаков, почтовый индекс города-получателя
	 */
	private $receiverCityPostCode;
	/**
	 * @var integer код выбранного тарифа
	 */
	private $tariffId;
	/**
	 * @var array
	 */
	private $tariffList;
	/**
	 * @var integer выбранный режим доставки. Выбирается из предоставляемого СДЭК списка
	 */
	private $modeId;
	/**
	 * @var array массив с элементами, каждый из которых состоит из ассоциативного массива с ключами:
	 *    •    weight - float, вес места, кг;
	 *    •    length - integer, длина места, см;
	 *    •    width - integer, ширина места, см;
	 *    •    height - integer, высота места, см.
	 *    или с такими ключами:
	 *    •    weight - float, вес места, кг;
	 *    •    volume - float, объём места, метры кубические. Данное значение будет переведено в объемный вес по формуле.
	 */
	private $goods = [];
	/**
	 * @var PlaceParams вес и объем отправляемого места
	 */
	private $place;
	
	private $servers
		= [
			'https://api.cdek.ru/calculator/calculate_price_by_json.php',
			'http://api.edostavka.ru/calculator/calculate_price_by_json.php',
			'http://lk.cdek.ru:8080/calculator/calculate_price_by_json.php',
		];
	private $result;
	private $error;
	
	/**
	 * CdekCalc constructor.
	 *
	 * @param int         $receiverCityId
	 * @param int         $receiverCityPostCode
	 * @param int         $tariffId
	 * @param PlaceParams $place
	 * @param array       $params
	 *
	 * @internal param int $senderCityId
	 * @internal param int $senderCityPostCode
	 * @internal param string $dateExecute
	 */
	public function __construct($receiverCityId, $receiverCityPostCode, $tariffId, $place, $params)
	{
		$this->dateExecute          = (new \DateTime())->add(new \DateInterval('P1D'))->format('Y-m-d');
		$this->senderCityId         = $params['senderCityId'];
		$this->senderCityPostCode   = $params['senderCityPostCode'];
		$this->receiverCityId       = $receiverCityId;
		$this->receiverCityPostCode = $receiverCityPostCode;
		$this->tariffId             = $tariffId;
		$this->place                = $place;
	}
	
	private function setSecure()
	{
		return md5($this->dateExecute . '&' . $this->authPassword);
	}
	
	protected function fillPlaceParams()
	{
		$this->goods['weight'] = $this->place->getWeightInKg();
		$this->goods['volume'] = $this->place->getVolumeInMetres();
	}
}