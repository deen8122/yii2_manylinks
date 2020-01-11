<?php

namespace frontend\modules\extentions\controllers;


use Yii;
use frontend\modules\extentions\Module;
use yii\web\Controller;

class BaseController extends Controller {

	public function actionUpdate() {
		$module = Module::getInstance();
		$module->setSiteData(Yii::$app->request->post());
	}
	public function update($data) {
		$module = Module::getInstance();
		return $module->setSiteData($data);
	}

}
