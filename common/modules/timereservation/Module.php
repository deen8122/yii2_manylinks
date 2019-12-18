<?php

namespace common\modules\timereservation;
use yii\filters\AccessControl;

/**
 * article module definition class
 */
class Module extends \yii\base\Module {

	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'common\modules\timereservation\controllers';
	public $events = [
	];

	/**
	 * @inheritdoc
	 */
	public function init() {
		parent::init();

		// custom initialization code goes here
	}

	public function behaviorsx() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['administrator'],
					]
				],
			],
		];
	}

}
