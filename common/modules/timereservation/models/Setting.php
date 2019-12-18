<?php

namespace common\modules\timereservation\models;

use Yii;
use common\models\KeyStorageItem;
use yii\base\Model;

class Setting extends Model {

	public $params = [
		"multy" => "",
		"multy2" => "",
		"lunch_break" => "",
		"work_time_start" => "",
		"work_time_end" => "",
		"email" => "",
	];

	public function attributeLabels() {
		return [
			'params.work_time' => "Время работы",
			'params[multy2]' => "Время работы",
		];
	}

	public function __construct($config = array()) {
		foreach ($this->params as $key => $val) {
			$model = KeyStorageItem::getModuleParam('timereservation', $key);
			if($model->value == null)				continue;
			if ($key == 'multy2') {
				$this->params[$key] = \GuzzleHttp\json_decode($model->value);
			} else {
				$this->params[$key] = $model->value;
			}
		}
		parent::__construct($config);
	}

	public function save() {
		
		$post = Yii::$app->request->post();
		foreach ($post['Setting']['params'] as $key => $val) {
			$model = KeyStorageItem::getModuleParam('timereservation', $key);
			if ($model == null) {
				if ($val == null) {
					continue;
				}
				$model = new KeyStorageItem();
			}
			if (is_array($val)) {
				$val = \GuzzleHttp\json_encode($val);
			}
			$model->key = $key;
			$model->value = $val;
			$model->module_id = 'timereservation';
			$model->save();
		}
		return true;
	}
	

}
