<?php

namespace frontend\modules\extentions\controllers;

use Yii;

use frontend\modules\extentions\controllers\BaseController;
use frontend\modules\extentions\Module;

class JsController extends BaseController {

	public function actionIndex() {

		
		if (Yii::$app->request->isAjax) {
			$this->layout = false;
			$module = Module::getInstance();
			return $module->renderJSON(['code' => "ok", 'html' => $this->render('index',['site'=>$this->getSiteModel()])]);
		} else {
			return $this->render('index',['site'=>$this->getSiteModel()]);
		}
	}

	public function actionUpdate() {
		$data = Yii::$app->request->post();
		log2file('post', $data);
		return parent::update(['jsCode' => $data['Site']['dataArray']['jsCode']]);
	}

}
