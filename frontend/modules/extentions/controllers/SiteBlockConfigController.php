<?php

namespace frontend\modules\extentions\controllers;

use Yii;
use yii\filters\AccessControl;
use frontend\modules\extentions\models\Imager;
use frontend\modules\extentions\controllers\BaseController;
use frontend\modules\extentions\Module;
use \common\models\SiteBlock;

class SiteBlockConfigController extends BaseController {

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
		$model = $this->getModel();

		$module = Module::getInstance();
		if (Yii::$app->request->isAjax) {
			$this->layout = false;
			return $module->renderJSON(['code' => "ok", "step" => 2, 'html' => $this->render('index', ['model' => $model])]);
		} else {
			return $this->render('index', ['model' => $model]);
		}
	}

	public function actionUpdate() {
		$module = Module::getInstance();
		if (Yii::$app->user->identity->site->version == \common\models\Site::SITE_VERSION_FREE) {
			
			//return $module->renderJSON(['code' => "error", 'error' => ["Версия вашего приложения не позволяет редактировать JS код проекта"]]);
		}
		$post = Yii::$app->request->post();
		$id = $post['id'];
		$result =  $module->setSiteBlockValueData($id, ["viewed_style"=>$post["viewed_style"]]);
		return $module->renderJSON(['code' => "ok", "result" =>$result]);
	}

	private function getModel() {
		$post = Yii::$app->request->post();
		if ($post == null) {
			$post['id'] = 56;
		}
		$siteBlock = SiteBlock::findOne(['id' => $post['id'], 'site_id' => Yii::$app->user->identity->site_id]);
		return $siteBlock;
	}

}
