<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\services\calculators;


use Codeception\Exception\ExternalUrlException;
use yii\base\InvalidParamException;

class EnergyCalc
{
	/**
	 * @var integer  код города отправления в системе ТК Энергия
	 */
	private $idCityFrom;
	/**
	 * @var array массив мест, каждое из которых должно состоять из массива ключ=>значение:
	 *      "weight" => 1.8,
	 *      "width" => 0.25,
	 *      "height" => 0.20,
	 *      "length" => 0.35
	 */
	private $items = [];
	/**
	 * @var integer
	 */
	private $idCurrency;
	/**
	 * @var integer
	 */
	private $cover;
	/**
	 * @var integer почтовый индекс города-получателя
	 */
	private $zip;
	/**
	 * @var string url для запроса цен
	 */
	protected $url = "https://api2.nrg-tk.ru/v2/price";
	
	/**
	 * EnergyCalc constructor.
	 *
	 * @param integer $zip
	 * @param  array  $params
	 * @param array   $items
	 */
	public function __construct($zip, $params, $items)
	{
		$this->idCityFrom = $params['idCityFrom'];
		$this->idCurrency = $params['idCurrency'];
		$this->cover      = $params['cover'];
		$this->items[]    = $items;
		$this->zip        = $zip;
	}
	
	/**
	 * @return int код города назначения в системе ТК Энергия
	 * @throws \Codeception\Exception\ExternalUrlException
	 */
	private function getIdCityTo()
	{
		$context = [
			"ssl" => [
				"verify_peer"      => false,
				"verify_peer_name" => false,
			],
		];
		
		try {
			$city = file_get_contents("https://api2.nrg-tk.ru/v2/search/city?zipCode=" . $this->zip, false, stream_context_create($context));
			if ($city === false) {
				throw new ExternalUrlException("Ошибка! Сервер ТК Энергия недоступен. Расчет невозможен.");
			} else {
				$id = json_decode($city, true);
				return $id['city']['id'];
			}
		} catch (\Exception $e) {
			throw new ExternalUrlException("Ошибка! Сервер ТК Энергия недоступен. Расчет невозможен. " . $e->getMessage());
		}
	}
	
	private function toJSON()
	{
		try {
			return json_encode([
				"idCityFrom" => $this->idCityFrom,
				"idCityTo"   => $this->getIdCityTo(),
				"cover"      => $this->cover,
				"idCurrency" => $this->idCurrency,
				"items"      => $this->items,
			]);
		} catch (ExternalUrlException $e) {
			throw new InvalidParamException("Не удалось установить город-получатель. Расчет невозможен. Причина: " . $e->getMessage());
		}
	}
	
	private function curlExecute()
	{
		$headers = [
			"Accept: application/json",
			"Content-Type: application/json",
			"User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:35.0) Gecko/20100101 Firefox/35.0",
		];
		try {
			$this->isCURLAvailable();
			$ch = curl_init($this->url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLINFO_HEADER_OUT, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this->toJSON());
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$response = curl_exec($ch);
			curl_close($ch);
			if ($response === false) {
				$result['error'][] = ['message' => "Ошибка сервера: " . curl_error($ch)];
			} else {
				$result = json_decode($response, true);
			}
		} catch(\Exception $e) {
			$result['error'][] = ['message' => $e->getMessage()];
		}
		return $result;
	}
	
	private function isCURLAvailable()
	{
		if (extension_loaded('curl')) {
			return true;
		}
		throw new \RuntimeException("Расчет невозможен: не подключена библиотека CURL.");
	}
	
	public function calculate()
	{
		return $this->curlExecute();
	}
}