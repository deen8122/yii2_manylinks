<?php

namespace common\modules\timereservation\controllers;

use yii\data\ActiveDataProvider;
use common\modules\timereservation\models\Service;
use common\modules\timereservation\models\ServiceCategory;
use common\traits\FormAjaxValidationTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ServiceController extends Controller {

	use FormAjaxValidationTrait;

	/** @inheritdoc */
	public function behaviors() {
		return [
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	/**
	 * @return mixed
	 */
	public function actionIndex() {

		$dataProvider = new ActiveDataProvider([
			'query' => Service::find(),
		]);
		return $this->render('index', [
				'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * @return mixed
	 */
	public function actionCreate() {
		$article = new Service();

		$this->performAjaxValidation($article);

		if ($article->load(Yii::$app->request->post()) && $article->save()) {
			return $this->redirect(['index']);
		}

		return $this->render('create', [
				'model' => $article,
				'categories' => ServiceCategory::find()->all(),
		]);
	}

	/**
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$article = $this->findModel($id);

		$this->performAjaxValidation($article);
		\yii\helpers\Url::remember();
		if ($article->load(Yii::$app->request->post()) && $article->save()) {
			//l(Yii::$app->request->post());
			if ( isset($_POST['update-button'])) {
				return $this->goBack();
			}
			return $this->redirect(['index']);
		}
		return $this->render('update', [
				'model' => $article,
				'categories' => ServiceCategory::find()->all(),
		]);
	}

	/**
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * @param integer $id
	 *
	 * @return Article the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Service::findOne($id)) !== null) {
			return $model;
		}
		throw new NotFoundHttpException('The requested page does not exist.');
	}

}
