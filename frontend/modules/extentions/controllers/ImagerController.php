<?php

namespace frontend\modules\extentions\controllers;

use Yii;
use yii\filters\AccessControl;
use frontend\modules\extentions\models\Imager;
use frontend\modules\extentions\controllers\BaseController;
use frontend\modules\extentions\Module;

class ImagerController extends BaseController {

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@']
					]
				]
			]
		];
	}

	public function actionIndex() {

		$model = new Imager();
		$module = Module::getInstance();
		$post = Yii::$app->request->post();


		if (Yii::$app->request->isAjax) {
			$this->layout = false;
			if ($_FILES) {
				if ($model->save()) {
					return $module->renderJSON([
							'code' => "ok",
							"files" => $model->getFilesInDir(),
							"allFilesSize" => FileSizeConvert($model->getDirSize())
					]);
				}
				return $module->renderJSON(['code' => "error", "error" => $model->errors]);
			} else {
				return $module->renderJSON(['code' => "ok", "step" => 2, 'html' => $this->render('index', ['model' => $model])]);
			}
		} else {
			return $this->render('index', ['model' => $model]);
		}
	}

	public function actionDelete() {
		$data = Yii::$app->request->post();
		$module = Module::getInstance();
		//l($data);
		$model = new Imager();
		$model->deleteByNum($data['i']);
		return $module->renderJSON([
				'code' => "ok",
				'post' => $data,
				"files" => $model->getFilesInDir(),
				"allFilesSize" => FileSizeConvert($model->getDirSize())
		]);
	}

}
