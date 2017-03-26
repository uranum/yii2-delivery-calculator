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

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
	
	    \Yii::configure($this, require(__DIR__ . '/config.php'));
    }
}
