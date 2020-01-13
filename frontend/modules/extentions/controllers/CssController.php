<?php

namespace frontend\modules\extentions\controllers;

use Yii;
use common\models\Site;
use frontend\modules\extentions\controllers\BaseController;
use frontend\modules\extentions\Module;

class CssController extends BaseController {

	public function actionIndex() {
		$module = Module::getInstance();
		$model = Site::find()->where(['id' => Yii::$app->user->identity->site_id])->one();
		if ($model->load(Yii::$app->request->post()) && $model->save()) {

			if (Yii::$app->request->isAjax) {
				return $module->renderJSON(['code' => "ok"]);
			} else {
				Yii::$app->session->setFlash('forceUpdateLocale');
				Yii::$app->session->setFlash('alert', [
					'options' => ['class' => 'alert-success'],
					'body' => "ok"
				]);
				return $this->refresh();
			}
		}

		if (Yii::$app->request->isAjax) {
			$this->layout = false;

			return $module->renderJSON(['code' => "ok", 'html' => $this->render('index', ['model' => $model])]);
		} else {
			return $this->render('index', ['model' => $model]);
		}
	}

	public function actionUpdate() {
		$data = Yii::$app->request->post();
		return parent::update(['style' => $data['style']]);
	}

}
