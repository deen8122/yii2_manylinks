<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\Application;

/**
 * Class LocaleBehavior
 * @package common\behaviors
 */
class ActivateDeactivateBehavior extends Behavior {

	public $in_attribute = 'name';
	public $out_attribute = 'slug';
	public $translit = true;

	public function events(): array {
		return [
			ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
			ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
		];
	}

	public function onBeforeSave(Event $event): void {
		/** @var ActiveRecord $model */
		$model = $event->sender;
		$model->setAttribute($jsonField, Json::encode($model->{$this->property}));
	}

}
