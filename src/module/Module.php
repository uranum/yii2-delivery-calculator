<?php

namespace uranum\delivery\module;

/**
 * delivery module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'uranum\delivery\module\controllers';
    public $params;

    const CITY_SENDER = 'Новосибирск';
    const DELIVERY_CODE = [
        'NALOJ'      => 'post_naloj',
        'PICKUP'     => 'pickup',
        'COURIER'    => 'courier',
        'POST'       => 'post',
        'CDEK_STORE' => 'cdek_store',
        'CDEK_DOOR'  => 'cdek_door',
        'ENERGY'     => 'energy',
        'ON_CHOICE'  => 'on_choice',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->registerTranslations();
        $config = require(__DIR__ . '/config.php');
        $config['params'] = array_merge($config['params'], $this->params);
	    \Yii::configure($this, $config);
    }
	
	public function registerTranslations()
	{
		\Yii::$app->i18n->translations['module'] = [
			'class'          => 'yii\i18n\PhpMessageSource',
			'sourceLanguage' => 'en-US',
			'basePath'       => '@vendor/uranum/yii2-delivery-calculator/src/module/messages',
        ];
    }
	
	public static function t($category, $message, $params = [], $language = null)
	{
		return \Yii::t($category, $message, $params, $language);
	}
	
}
