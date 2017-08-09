# Yii2-delivery-calculator
Yii2 extension help to get the result of the calculating from the aggregated delivery services

## Under the development...

### Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist uranum/yii2-delivery-calculator
```

or add

```
"uranum/yii2-delivery-calculator": "*"
```

to the require section of your `composer.json` file.

#### Configure module

##### Миграции (для создания модуля доставок в админке)
Примените миграцию  `yii migrate --migrationPath=@uranum/delivery/migration`


ОБЯЗАТЕЛЬНО!
Задать параметры для [postcalc](http://postcalc.ru/api.html)
```php
'modules'             => [
		'delivery' => [
			'class' => 'uranum\delivery\module\Module',
		    'params' => [
			    'locationFrom' => 'Новосибирск',        // Город отправки
			    /** Параметры для postcalc (Почта России) */
			    'siteName'     => 'site.ru',            // Название сайта (ОБЯЗАТЕЛЬНЫЙ)
			    'email'        => 'your@mail.ru',       // Контактный email. Самый принципиальный параметр для postcalc (ОБЯЗАТЕЛЬНЫЙ)
			    'contactName'  => 'Eugeny_Emelyanov',   // Контактное лицо. Имя_фамилия, только латиница через подчеркивание (НЕобязательный)
			    'insurance'    => 'f',                  // База страховки - полная f или частичная p (НЕобязательный)
			    'round'        => 1,                    // Округление вверх. 0.01 - округление до копеек, 1 - до рублей (НЕобязательный)
			    'pr'           => 0,                    // Наценка в рублях за обработку заказа (НЕобязательный)
			    'pk'           => 0,                    // Наценка в рублях за упаковку одного отправления (НЕобязательный)
			    'encode'       => 'utf-8',              // Кодировка - utf-8 или windows-1251 (НЕобязательный)
			    'sendDate'     => 'now',                // Дата - в формате, который понимает strtotime(), например, '+7days','10.10.2020' (НЕобязательный)
			    'respFormat'   => 'json',               // Формат ответа (html, php, arr, wddx, json, plain) (НЕобязательный)
			    'country'      => 'Ru',                 // Страна (список стран: http://postcalc.ru/countries.php) (НЕобязательный)
			    'servers'      => [
				    //'api.postcalc.ru',                // После тестовых запросов включить "боевой" сервер (ОБЯЗАТЕЛЬНО)
				    'test.postcalc.ru',
			    ],                                      // Список серверов для беплатной версии (ОБЯЗАТЕЛЬНЫЙ)
			    'httpOptions'  => [
				    'http' => [
					    'header'     => 'Accept-Encoding: gzip',
					    'timeout'    => 5,              // Время ожидания ответа сервера в секундах
					    'user_agent' => 'PostcalcLight_1.04 ' . phpversion(),
				    ],
			    ],                                      // Опции запроса (НЕобязательный)
		    ]
		],
	],
```

#### Example of use
```php
$services    = Yii::$app->getModule('delivery')->getComponents();
$data        = new DeliveryCargoData(659300, 'Бийск', 2000, 1000, 275); // zip, locationTo, cartCost, weight, innerCode (own carrier code)
$resultArray = new DeliveryCalculator($data, $services);
VarDumper::dump($resultArray->calculate());
```

Result is
```php
[
    0 => [
        'name' => 'Почта России'
        'terms' => '9-13 дн.'
        'cost' => '314.60'
        'info' => null
    ]
    1 => [
        'name' => 'Почта России наложенным'
        'terms' => '9-13 дн.'
        'cost' => 487.18
        'info' => null
    ]
    2 => false
    3 => [
        'name' => 'Самовывоз'
        'terms' => false
        'cost' => 0
        'info' => 'Самостоятельно забираете в офисе.'
    ]
]
```
В папке src/services имеются образцы, которые наследуются от YiiModuleDelivery. Можно создать собственный класс, также его отнаследовать от YiiModuleDelivery и реализовать метод calculate() со своей логикой расчета (или получение данных расчета по api).
