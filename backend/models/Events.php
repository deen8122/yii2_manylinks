<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Create user form
 */
class Events extends Event {

	public function init() {

		$this->on("test", [$this, 'test']);
		log2file('Events init');
		Yii::$app->on('test', function ($event) {
			exit(get_class($event->sender));  // выводит "common\components\Comp"
		});
		parent::init(); // DON'T Forget to call the parent method.
	}

	public function sender() {

		log2file('test');
	}

}
