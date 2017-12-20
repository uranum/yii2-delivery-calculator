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
Задать сервисы доставки
```php
'modules'             => [
		'delivery' => [
			'class' => 'uranum\delivery\module\Module',
			'params' => [...],
            'components'             => [
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
            ],
        ],
]
```

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
			    ],                                      // Список серверов для беcплатной версии (ОБЯЗАТЕЛЬНЫЙ)
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

### Создание новой службы доставки
* создать миграцию, добавляющую новую доставку (см. пример в папке migration - InitialDeliveryServices)
* создать класс NewDeliveryService, отнаследовавшись от YiiModuleDelivery, который вернет массив расчитанных данных (см. примеры в папке services)
* если требуется специальный расчет (например, через API), то создать класс NewDeliveryCalc, который должен вернуть результат расчета
* добавить в файл конфигурации, в раздел components, созданную доставку:
```php
'components' => [
        // ...
        'field_code_of_new_delivery' => [
            'class' => 'my\extended\class\NewDeliveryService',
        ],
    ],
```
### Создание своего контроллера
Если нужно установить свои права доступа к контроллеру доставок сделайте следующее:
* создайте в админке свой контроллер, отнаследовавшись от \uranum\delivery\module\controllers\DeliveryController
* в этом контроллере создайте свои фильтры и поведения (access, verbs)
* создайте свои виды (index, create, update) или 
* рендерьте виды из расширения добавив метод init() с таким кодом:
```php
public function init()
{
    $this->module->setViewPath('@uranum/delivery/module/views');
    \Yii::$app->i18n->translations['module'] = [
        'class'          => 'yii\i18n\PhpMessageSource',
        'sourceLanguage' => 'en-US',
        'basePath'       => '@vendor/uranum/yii2-delivery-calculator/src/module/messages'
    ];
}
```