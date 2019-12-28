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
	public function actions() {
		
	}

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
		if($site == null){
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
			return $this->renderJSON(['code' => "error", "message" => "nAjax"]);
		}
		$model = SiteBlock::findOne(['id' => $post['id'], 'site_id' => Yii::$app->user->identity->site_id]);
		if ($model === null) {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
		if (isset($post['SBV'])) {
			foreach ($post['SBV']['name'] as $id => $name) {
				$value = $post['SBV']['value'][$id];
				$sort = $post['SBV']['sort'][$id];
				$SBV = SiteBlockValue::findOne(['id' => $id, 'site_block_id' => $model->id]);
				if ($SBV == null) {
					$SBV = new SiteBlockValue();
				}
				$SBV->site_block_id = $model->id;
				$SBV->name = $name;
				$SBV->sort = $sort;
				$SBV->value = $value;
				$SBV->save();
			}
		}
		$model->text = $post['text'];
		$model->data = $post['data'];
		$model->save();
		return $this->renderJSON(['code' => "ok"]);
	}

	public function renderJSON($data) {
		Yii::$app->response->format = Response::FORMAT_JSON;
		return json_encode($data, JSON_PRETTY_PRINT);
	}

	public function actionUpdate2($id) {
		$siteBlock = \common\models\SiteBlock::find()->orderBy(['sort' => SORT_ASC])->where(['site_id' => Yii::$app->user->identity->site_id])->asArray()->all();
		$model = $this->findModel($id);
		$model->user_id = Yii::$app->user->identity->id;
		$model->categories = $_POST['category'];
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['update', 'id' => $model->id]);
		}
		return $this->render('update', [
				'model' => $model,
		]);
	}

	public function actionUpdatesort() {
		l($_POST);
		foreach ($_POST['data'] as $id => $sort) {
			if ($_POST['action'] == "blockUpdateSort") {
				$siteBlockValue = SiteBlock::findOne(['id' => $id]);
			} else {
				$siteBlockValue = SiteBlockValue::findOne(['id' => $id]);
			}

			$siteBlockValue->sort = $sort;
			$siteBlockValue->save();
		}
		return true;
	}

	/**
	 * Создаем новый блок!
	 * @return $id
	 */
	public function actionCreateblock() {
		$sb = new SiteBlock();
		$sb->site_id =  Yii::$app->user->identity->site_id;
		$sb->type = (int)$_POST['type'];
		if($sb->save()){
			return $this->renderJSON(['code' => "ok","id" => $sb->id]);
		}else {
			return $this->renderJSON(['code' => "error","message" =>implode(",",$sb->errors['model'])]);
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

	
	protected function findModel($id) {
		if (($model = Task::findOne(['id' => $id, 'user_id' => Yii::$app->user->identity->id])) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
		//  throw new NotFoundHttpException('The requested page does not exist.');
	}


	
	
		}
