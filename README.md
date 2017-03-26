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
