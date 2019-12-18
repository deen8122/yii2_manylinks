<?php

namespace backend\models;

use Yii;
use common\models\KeyStorageItem;
use yii\base\Model;

class SiteSetting extends Model {

	const TYPE_JSON = 1;
	public $params = [];
	public $moduleName = 'main';

	public function __construct($config = array()) {
		$allParams = KeyStorageItem::getModuleAllParams($this->moduleName);
		if (count($allParams) > 0) {
			foreach ($allParams as $key => $arr) {				
				if ( $arr['type'] == SiteSetting::TYPE_JSON) {
					$this->params[$arr['key']] = \GuzzleHttp\json_decode($arr['value']);
				} else {
					$this->params[$arr['key']] = $arr['value'];
				}
			}
		}
		//l($this->params);
		parent::__construct($config);
	}

	public function save() {

		$post = Yii::$app->request->post();
		//l(get_called_class());
		//l($post);
		foreach ($post['SiteSetting']['params'] as $key => $val) {
			$model = KeyStorageItem::getModuleParam($this->moduleName, $key);
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
			$model->module_id = $this->moduleName;
			$model->save();
		}
		return true;
	}

}
