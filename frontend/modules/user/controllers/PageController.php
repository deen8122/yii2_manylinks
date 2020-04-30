<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\Site;
use common\models\SiteBlock;
use common\models\SiteBlockValue;
use yii\web\Response;

class PageController extends Controller {

	/**
	 * @return array
	 */
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

	/**
	 * @return string|\yii\web\Response
	 */
	public function actionIndex() {
		$site = Site::find()->where(['id' => Yii::$app->user->identity->site_id])->one();

		if ($site == null) {
			//l($site);
			$site = Site::createDefaultItems();
		}
		$siteBlock = SiteBlock::find()->orderBy(['sort' => SORT_ASC])->where(['site_id' => Yii::$app->user->identity->site_id])->all();
		return $this->render('index', [
				'site' => $site,
				'siteBlock' => $siteBlock,
		]);
	}

	/*
	 * Обновление данных
	 */

	public function actionUpdate() {
		$post = Yii::$app->request->post();
		if (!Yii::$app->request->isAjax) {
			//return $this->renderJSON(['code' => "error", "message" => "nAjax"]);
		}
		log2file('update', $_REQUEST);
		$model = SiteBlock::findOne(['id' => $post['id'], 'site_id' => Yii::$app->user->identity->site_id]);
		if ($model === null) {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
		if (isset($post['SBV'])) {
			foreach ($post['SBV']['name'] as $id => $name) {

				$value = $post['SBV']['value'][$id];
				if ($name == 'template' && $value == 1)
					continue;
				$sort = $post['SBV']['sort'][$id];
				$SBV = SiteBlockValue::findOne(['id' => $id, 'site_block_id' => $model->id]);
				if ($SBV == null) {
					$SBV = new SiteBlockValue();
				}
				$SBV->site_block_id = $model->id;
				$SBV->name = $name;
				$SBV->sort = $sort;
				if (is_array($value)) {
					$value = json_encode($value);
				}
				$SBV->value = $value;
				$SBV->save();
			}
		}
		$data = [];
		if (isset($post['DATA'])) {
			foreach ($post['DATA'] as $name => $value) {
				$data[$name] = $value;
			}
			$model->data = $data;
		}
		if (isset($post['text'])) {
			$model->text = $post['text'];
		}
		if (isset($post['blockname'])) {
			$model->blockname = $post['blockname'];
		}
		$model->save();
		return $this->renderJSON(['code' => "ok"]);
	}

	public function renderJSON($data) {
		Yii::$app->response->format = Response::FORMAT_JSON;
		return json_encode($data, JSON_PRETTY_PRINT);
	}

	public function actionUpdatesort() {
		//l($_POST);
		foreach ($_POST['data'] as $id => $sort) {
			if ($_POST['action'] == "blockUpdateSort") {
				$siteBlockValue = SiteBlock::findOne(['id' => $id]);
			} else {
				$siteBlockValue = SiteBlockValue::findOne(['id' => $id]);
			}

			$siteBlockValue->sort = $sort;
			$siteBlockValue->save();
		}
		return $this->renderJSON(['code' => "ok"]);
	}

	public function actionUpload() {
		$imager = new \frontend\modules\extentions\models\Imager();
		$sResultFileName = $imager->uploadImageAndCrop();
		if ($sResultFileName) {
			return $this->renderJSON(['code' => 'ok', "file" => $sResultFileName]);
		} else {
			return $this->renderJSON(['code' => 'error', "error" => $imager->errors]);
		}
	}

	/**
	 * Создаем новый блок!
	 * @return $id
	 */
	public function actionCreateblock() {
		$sb = new SiteBlock();
		$sb->type = (int) $_POST['type'];
		if ($sb->save()) {
			return $this->renderJSON(['code' => "ok", "id" => $sb->id]);
		} else {
			return $this->renderJSON(['code' => "error", "message" => implode(",", $sb->errors['model'])]);
		}
	}

	/**
	 * Создаем новый блок!
	 * @return $id
	 */
	public function actionSbvcreate() {
		$SBV = new SiteBlockValue();
		//$sb->site_id = Yii::$app->user->identity->site_id;
		$SBV->site_block_id = $_POST['block_id'];
		$SBV->sort = $_POST['sort'];
		if ($SBV->save()) {
			return $this->renderJSON(['code' => "ok", "id" => $SBV->id]);
		} else {
			return $this->renderJSON(['code' => "error", "message" => implode(",", $SBV->errors['model'])]);
		}
	}

	//createblock
	public function actionSbvdelete() {
		if ($_POST['id'] > 0) {
			$siteBlock = SiteBlock::findOne(['id' => $_POST['sb_id'], 'site_id' => Yii::$app->user->identity->site_id]);
			$siteBlockValue = SiteBlockValue::findOne(['id' => $_POST['id'], 'site_block_id' => $siteBlock->id]);
			$siteBlockValue->delete();
		}
		return true;
	}

	/*
	 * Удаление SiteBlock
	 */

	public function actionBlockremove() {
		if ($_POST['id'] > 0) {
			$siteBlock = SiteBlock::findOne(['id' => $_POST['id'], 'site_id' => Yii::$app->user->identity->site_id]);
			$siteBlock->delete();
			return json_encode(["code" => "ok", "id" => $_POST['id']]);
		}
	}

	/*
	 * Удаление SiteBlock
	 */

	public function actionBlockactivate() {
		$post = Yii::$app->request->post();
		if ($post['id'] > 0) {
			if ($post['type'] == "SiteBlockValue") {
				$siteBlock = SiteBlockValue::findOne(['id' => $post['id']]);
			} else {
				$siteBlock = SiteBlock::findOne(['id' => $post['id'], 'site_id' => Yii::$app->user->identity->site_id]);
			}
			$siteBlock->setActive($post['status'] > 0 ? true : false);
			return json_encode(["code" => "ok", "id" => $post['id'], 'status' => $siteBlock->status]);
		}
	}

}
