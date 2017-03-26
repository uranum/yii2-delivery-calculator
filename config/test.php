<?php
return [
	'id'            => 'test-app',
	'basePath'      => dirname(__DIR__),
	'vendorPath'    => dirname(__DIR__) . '/vendor',
	'runtimePath'   => dirname(__DIR__) . '/runtime',
	'modules'       => [
		'delivery' => [
			'class' => 'uranum\delivery\module\Module',
		],
	],
	'controllerMap' => [
		'migrate' => [
			'class'         => 'yii\console\controllers\MigrateController',
			'migrationPath' => dirname(__DIR__) . '/migration',
		],
	],
	'components'    => [
		'db' => require dirname(__DIR__) . '/config/db-local.php',
	],
];