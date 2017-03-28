<?php

return [
	'components' => [
		/**
		 * Названия компонентов - сервисов доставки должны совпадать со
		 * значением поля `code` модели DeliveryServices
		 */
		
		'post'       => [
			'class' => 'uranum\delivery\services\PostDelivery',
		],
		'post_naloj' => [
			'class' => 'uranum\delivery\services\PostNalojDelivery',
		],
		'cdek-store' => [
			'class' => 'uranum\delivery\services\CdekStore'
		],
		'cdek-door' => [
			'class' => 'uranum\delivery\services\CdekDoor'
		],
		'courier'    => [
			'class' => 'uranum\delivery\services\CourierDelivery',
		],
		'pickup'     => [
			'class' => 'uranum\delivery\services\PickupDelivery',
		],
	],
	'params'     => [
		'locationFrom'       => 'Новосибирск',        // Город отправки (название или индекс)
		/** Параметры для postcalc */
		'siteName'           => 'inknsk.ru',          // Название сайта (ОБЯЗАТЕЛЬНЫЙ)
		'email'              => 'emel.yanov@mail.ru', // Контактный email. Самый принципиальный параметр для postcalc (ОБЯЗАТЕЛЬНЫЙ)
		'contactName'        => 'Eugeny_Emelyanov',   // Контактное лицо. Имя_фамилия, только латиница через подчеркивание (НЕобязательный)
		'insurance'          => 'f',                  // База страховки - полная f или частичная p (НЕобязательный)
		'round'              => 1,                    // Округление вверх. 0.01 - округление до копеек, 1 - до рублей (НЕобязательный)
		'pr'                 => 0,                    // Наценка в рублях за обработку заказа (НЕобязательный)
		'pk'                 => 0,                    // Наценка в рублях за упаковку одного отправления (НЕобязательный)
		'encode'             => 'utf-8',              // Кодировка - utf-8 или windows-1251 (НЕобязательный)
		'sendDate'           => 'now',                // Дата - в формате, который понимает strtotime(), например, '+7days','10.10.2020' (НЕобязательный)
		'respFormat'         => 'json',               // Формат ответа (html, php, arr, wddx, json, plain) (НЕобязательный)
		'country'            => 'Ru',                 // Страна (список стран: http://postcalc.ru/countries.php) (НЕобязательный)
		'servers'            => [
			//'api.postcalc.ru',
			'test.postcalc.ru',
		],                                            // Список серверов для беплатной версии (ОБЯЗАТЕЛЬНЫЙ)
		'httpOptions'        => [
			'http' => [
				'header'     => 'Accept-Encoding: gzip',
				'timeout'    => 5,                    // Время ожидания ответа сервера в секундах
				'user_agent' => 'PostcalcLight_1.04 ' . phpversion(),
			],
		],                                            // Опции запроса (НЕобязательный)
		/** Конец - Параметры для postcalc */
		/** Параметры для cdek */
		'senderCityId'       => 270,                  // Код Новосибирска в системе СДЭК
		'senderCityPostCode' => 630000,               // Индекс Новосибирска
		'width'              => 20,                   // Щирина места отправления
		'height'             => 25,                   // Высота места отправления
		'length'             => 35,                   // Длина места отправления
		/** Параметры ТЕСТОВОЙ учетной записи */
		'authLogin'          => 'e56022425b2e58b476b051418604ddb2',                   // Логин в системе СДЭК
		'authPassword'       => 'c8e4fb656a630a97f374b50a097cf75c',                   // Пароль в системе СДЭК
		'modeId'             => '',                   // Выбранный режим доставки. Выбирается из предоставляемого СДЭК списка
		/** Конец - Параметры для cdek */
	],
];