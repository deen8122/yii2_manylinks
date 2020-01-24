<?php

namespace frontend\modules\extentions\controllers;

use Yii;
use common\models\SiteVersion;
use frontend\modules\extentions\controllers\BaseController;
use frontend\modules\extentions\Module;

class JsController extends BaseController {

	public function actionIndex() {


		if (Yii::$app->request->isAjax) {
			$this->layout = false;
			$module = Module::getInstance();
			return $module->renderJSON(['code' => "ok", 'html' => $this->render('index', ['site' => $this->getSiteModel()])]);
		} else {
			return $this->render('index', ['site' => $this->getSiteModel()]);
		}
	}

	public function actionUpdate() {
		if (Yii::$app->user->identity->site->version == \common\models\Site::SITE_VERSION_FREE) {
			$module = Module::getInstance();
			return $module->renderJSON(['code' => "error", 'error' =>["Версия вашего приложения не позволяет редактировать JS код проекта"]]);
		}
		$data = Yii::$app->request->post();
		log2file('post', $data);
		return parent::update(['jsCode' => $data['Site']['dataArray']['jsCode']]);
	}

}
