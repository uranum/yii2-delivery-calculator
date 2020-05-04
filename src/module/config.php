<?php


$code = uranum\delivery\module\Module::DELIVERY_CODE;
return [
    'components' => [
        /**
         * Названия компонентов - сервисов доставки должны совпадать со
         * значением поля `code` модели DeliveryServices
         *
         * например

            $code['POST']       => [
            'class' => 'uranum\delivery\services\PostDelivery',
            ],
            $code['NALOJ']      => [
            'class' => 'uranum\delivery\services\PostNalojDelivery',
            ],
            $code['CDEK_STORE'] => [
            'class' => 'uranum\delivery\services\CdekStore',
            ],
            $code['CDEK_DOOR']  => [
            'class' => 'uranum\delivery\services\CdekDoor',
            ],
            $code['COURIER']    => [
            'class' => 'uranum\delivery\services\CourierDelivery',
            ],
            $code['PICKUP']     => [
            'class' => 'uranum\delivery\services\PickupDelivery',
            ],
            $code['ENERGY']     => [
            'class' => 'uranum\delivery\services\EnergyDelivery',
            ],
            $code['ON_CHOICE']     => [
            'class' => 'uranum\delivery\services\OnChoiceDelivery',
            ],
         *
         */
    ],
    'params'     => [
        'locationFrom'       => uranum\delivery\module\Module::CITY_SENDER,        // Город отправки (название или индекс)
        'width'              => 20,                   // Щирина места отправления (см)
        'height'             => 25,                   // Высота места отправления (см)
        'length'             => 35,                   // Длина места отправления (см)
        /** Параметры для postcalc */
        'siteName'           => 'site.ru',            // Название сайта (ОБЯЗАТЕЛЬНЫЙ)
        'key'                => 'domen-XXXXX',        // ключ для доступа к API (ОБЯЗАТЕЛЬНЫЙ c 25 декабря 2019 года)
        'email'              => 'email@mail.ru',      // Контактный email. Самый принципиальный параметр для postcalc (ОБЯЗАТЕЛЬНЫЙ)
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
            //'api' => 'api.postcalc.ru',
            'test' => 'test.postcalc.ru',
        ],                                            // Список серверов для беcплатной версии (ОБЯЗАТЕЛЬНЫЙ)
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
        /** Параметры ТЕСТОВОЙ учетной записи */
        'authLogin'          => '',                   // Логин в системе СДЭК
        'authPassword'       => '',                   // Пароль в системе СДЭК
        'modeId'             => '',                   // Выбранный режим доставки. Выбирается из предоставляемого СДЭК списка
        /** Конец - Параметры для cdek */
        /** Параметры для Энергия */
        'idCityFrom'         => 383,                  // Код Новосибирска в системе Энергия
        'cover'              => 0,
        'idCurrency'         => 0,
        /** Конец - Параметры для Энергия */
    ],
];