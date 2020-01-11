<?php

namespace frontend\modules\extentions\controllers;

use Yii;
use frontend\modules\extentions\controllers\BaseController;
use frontend\modules\extentions\Module;

class BgimageController extends BaseController {

	public function actionIndex() {

		if (Yii::$app->request->isAjax) {
			$this->layout = false;
			$module = Module::getInstance();
			return $module->renderJSON(['code' => "ok", 'html' => $this->render('index')]);
		} else {
			return $this->render('index');
		}
	}

	public function actionUpdate() {
		$data = Yii::$app->request->post();
		return parent::update(['bgClass' => $data['bgClass']]);
	}

}
