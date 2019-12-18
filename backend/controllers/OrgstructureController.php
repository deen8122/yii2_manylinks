<?php

namespace backend\controllers;

use Yii;
use app\models\OrgStructure;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * OrgstructureController implements the CRUD actions for OrgStructure model.
 */
class OrgstructureController extends Controller {

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
	 * Lists all OrgStructure models.
	 * @return mixed
	 */
	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			'query' => OrgStructure::find(),
		]);

		return $this->render('index', [
				'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single OrgStructure model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render('view', [
				'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new OrgStructure model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new OrgStructure();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}
		return $this->render('create', [
				'model' => $model, 'categories' => $this->getAll()
		]);
	}

	public function getAll($id=0) {
		$res = OrgStructure::find()->where('id != :id', [':id' => $id])->andWhere(['site_id' => Yii::$app->user->identity->site->id])->all();
		//l($res);
		 $res = ArrayHelper::map($res, 'id', 'title');
		// l($res);
		return $res;
	}

	/**
	 * Updates an existing OrgStructure model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render('update', [
				'model' => $model,
				'categories' => $this->getAll($id)
		]);
	}

	/**
	 * Deletes an existing OrgStructure model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the OrgStructure model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return OrgStructure the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = OrgStructure::findOne($id)) !== null) {
			return $model;
		}
		throw new NotFoundHttpException('The requested page does not exist.');
	}

}
