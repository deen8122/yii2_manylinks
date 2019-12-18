<?php

namespace common\modules\timereservation\controllers;

use common\modules\timereservation\models\Setting;
use Yii;
use yii\web\Controller;

class SettingController extends Controller {

	public function actionIndex() {
		$model = new Setting();
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->refresh();
		}

		return $this->render('index', [
				'model' => $model,
		]);
	}

}
