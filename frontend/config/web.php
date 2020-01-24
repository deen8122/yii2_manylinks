<?php

$config = [
	'homeUrl' => Yii::getAlias('@frontendUrl'),
	'controllerNamespace' => 'frontend\controllers',
	'defaultRoute' => 'site/index',
	'bootstrap' => ['maintenance'],
	'modules' => [
		'user' => [
			'class' => frontend\modules\user\Module::class,
			'shouldBeActivated' => true,
			'enableLoginByPass' => false,
		],
		'extentions' => [
			'class' => frontend\modules\extentions\Module::class,
			//'publishDirectory' => true
		],
	],
	'components' => [
		'authClientCollection' => [
			'class' => yii\authclient\Collection::class,
			'clients' => [
				'vkontakte' => [
					'class' =>  yii\authclient\clients\VKontakte::class,
					'clientId' => '7279816',
					'clientSecret' => 'mYr7V3RAQRlI75Yxy28f',
					'scope' => 'email,public_profile',
					'attributeNames' => [
						'name',
						'email',
						'first_name',
						'last_name',
					]
				],						
			]
		],
		'errorHandler' => [
			'errorAction' => 'site/error'
		],
		'maintenance' => [
			'class' => common\components\maintenance\Maintenance::class,
			'enabled' => function ($app) {
				if (env('APP_MAINTENANCE') === '1') {
					return true;
				}
				return false; //$app->keyStorage->get('frontend.maintenance') === 'enabled';
			}
		],
		'request' => [
			'baseUrl' => '',
			'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY')
		],
		'user' => [
			'class' => yii\web\User::class,
			'identityClass' => common\models\User::class,
			'loginUrl' => ['/user/sign-in/login'],
			'enableAutoLogin' => true,
			'as afterLogin' => common\behaviors\LoginTimestampBehavior::class
		]
	]
];

if (YII_ENV_DEV) {
	$config['modules']['gii'] = [
		'class' => yii\gii\Module::class,
		'generators' => [
			'crud' => [
				'class' => yii\gii\generators\crud\Generator::class,
				'messageCategory' => 'frontend'
			]
		]
	];
}

return $config;


