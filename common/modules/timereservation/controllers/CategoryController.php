<?php

namespace common\modules\timereservation\controllers;

use yii\data\ActiveDataProvider;
use common\modules\timereservation\models\ServiceCategory;
use common\traits\FormAjaxValidationTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller {

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
			'query' => ServiceCategory::find(),
		]);
		return $this->render('index', [
				'dataProvider' => $dataProvider,
				'model' => $category,
				//     'categories' => $categories,
		]);
	}

	/**
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$category = $this->findModel($id);

		$this->performAjaxValidation($category);

		if ($category->load(Yii::$app->request->post()) && $category->save()) {
			return $this->redirect(['index']);
		}
		$categories = ArticleCategory::find()->noParents()->andWhere(['not', ['id' => $id]])->all();
		$categories = ArrayHelper::map($categories, 'id', 'title');

		return $this->render('update', [
				'model' => $category,
				'categories' => $categories,
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
	 * @return ArticleCategory the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = ArticleCategory::findOne(['id' => $id, 'site_id' => Yii::$app->user->identity->site])) !== null) {
			return $model;
		}
		throw new NotFoundHttpException('The requested page does not exist.');
	}

}
