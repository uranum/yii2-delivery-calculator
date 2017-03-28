<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\services\calculators;


use \Exception;

class PostCalc
{
	public $locationTo;
	public $locationFrom;
	public $zip;
	public $weight;
	public $cartCost;
	
	protected $siteName;    // Название сайта
	public    $email;       // Контактный email. Самый принципиальный параметр
	public    $contactName; // Контактное лицо. Имя_фамилия, только латиница через подчеркивание
	public    $insurance;   // База страховки - полная f или частичная p
	public    $round;       // Округление вверх. 0.01 - округление до копеек, 1 - до рублей
	public    $pr;          // Наценка в рублях за обработку заказа
	public    $pk;          // Наценка в рублях за упаковку одного отправления
	public    $encode;      // Кодировка - utf-8 или windows-1251
	public    $sendDate;    // Дата - в формате, который понимает strtotime(), например, '+7days','10.10.2014'
	public    $servers;     // Список серверов для беплатной версии
	public    $country;     // Страна (список стран: http://postcalc.ru/countries.php)
	public    $respFormat;  // Формат ответа (html, php, arr, wddx, json, plain)
	public    $httpOptions; // Опции запроса
	
	/**
	 * PostCalc constructor.
	 *
	 * @param $locationTo
	 * @param $locationFrom
	 * @param $weight
	 * @param $cartCost
	 * @param $params array
	 *
	 * @throws \Exception
	 */
	public function __construct($locationTo, $locationFrom, $weight, $cartCost, $params)
	{
		$this->locationTo   = $locationTo;
		$this->locationFrom = $locationFrom;
		$this->weight       = $weight;
		$this->cartCost     = $cartCost;
		
		$this->siteName    = $params['siteName'];
		$this->email       = $params['email'];
		$this->contactName = $params['contactName'];
		$this->insurance   = $params['insurance'];
		$this->round       = $params['round'];
		$this->pr          = $params['pr'];
		$this->pk          = $params['pk'];
		$this->encode      = $params['encode'];
		$this->sendDate    = $params['sendDate'];
		$this->servers     = $params['servers'];
		$this->country     = $params['country'];
		$this->respFormat  = $params['respFormat'];
		$this->httpOptions = $params['httpOptions'];
	}
	
	/**
	 * @return mixed|string
	 */
	public function getResult()
	{
		return $this->issetErrorInResponse($this->tryDecode($this->unzipResponse($this->request())));
	}
	
	/**
	 * Формируем поля запроса
	 * @return array
	 */
	private function queryBuildArray()
	{
		return http_build_query([
			'st' => $this->siteName,
			'cs' => $this->encode,
			'ml' => $this->email,
			'pn' => $this->contactName,
			'r'  => $this->round,
			'f'  => $this->locationFrom,
			't'  => $this->locationTo,
			'w'  => $this->weight,
			'v'  => $this->cartCost,
			'c'  => $this->country,
			'o'  => $this->respFormat,
			'd'  => $this->sendDate,
			'sw' => 'PostcalcLight_1.04(custom)',
		]);
	}
	
	/**
	 * Формируем опции запроса.
	 * Это _необязательно_, однако упрощает контроль и отладку
	 * @return array
	 */
	private function contentOptionsArray()
	{
		return stream_context_create($this->httpOptions);
	}
	
	/**
	 * Основная функция запроса к серверу
	 * @return mixed|string метод возвращает либо массив данных расчета, либо строку с ошибкой.
	 */
	public function request()
	{
		$content = '';
		try {
			foreach ($this->servers as $server) {
				$content = file_get_contents("http://$server/?" . $this->queryBuildArray(), false, $this->contentOptionsArray());
				if ($content === false) {
					$content = 'Не удалось соединиться ни с одним из серверов postcalc.ru';
					continue;
				} else {
					break;
				}
			}
		} catch (Exception $exception) {
			$content = 'Не удалось соединиться ни с одним из серверов postcalc.ru. Ошибка: ' . $exception->getMessage();
		}
		
		return $content;
	}
	
	private function unzipResponse($response)
	{
		if (substr($response, 0, 3) == "\x1f\x8b\x08") {
			return gzinflate(substr($response, 10, - 8));
		}
		
		return $response;
	}
	
	/**
	 * Проверка на наличие ошибки в процессе обработки ответа сервера Postcalc
	 *
	 * @param $response
	 *
	 * @return mixed|string
	 */
	private function tryDecode($response)
	{
		//VarDumper::dump($this->siteName);
		//die();
		if (null === $result = json_decode($response)) {
			return "Получены странные данные. Ответ сервера:\n$response";
		} else {
			return $result;
		}
	}
	
	/**
	 * Проверка на наличие ошибки в ответе сервера Postcalc
	 *
	 * @param $response
	 *
	 * @return string
	 */
	private function issetErrorInResponse($response)
	{
		if ($response instanceof \stdClass && $response->Status != 'OK') {
			return "Сервер вернул ошибку: $response->Message!";
		}
		
		return $response;
	}
	
}