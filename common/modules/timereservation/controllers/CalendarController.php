<?php

namespace common\modules\timereservation\controllers;

use common\models\User;
use yii\data\ActiveDataProvider;
use common\modules\timereservation\models\Service;
use common\modules\timereservation\models\ServiceReservation;
use common\traits\FormAjaxValidationTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CalendarController extends Controller {

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
		$serviceArr = Service::find()->AsArray()->all();
		$ids = [];
		foreach ($serviceArr as $arr) {
			$ids[] = $arr['id'];
		}
		//l($ids);
		$firstDayOfMonth = strtotime(date('Y-m-01'));
		$lastDayOfMonth = strtotime(date('Y-m-t'));
		$model = ServiceReservation::find()
			->where(['service_id' => $ids])
			->andWhere(['>', 'date', $firstDayOfMonth])
			->andWhere(['<', 'date', $lastDayOfMonth])
			->AsArray()
			->all();
		//l(Yii::$app->user->identity->site);
		return $this->render('index', [
				'reservations' => $model,
				'users' => User::find()->with('userProfile')->where(['site_id'=>Yii::$app->user->identity->site->id])->all(),
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
