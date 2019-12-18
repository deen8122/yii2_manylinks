<?php

/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:01 PM
 */

namespace frontend\controllers;

use common\models\Page;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PageController extends Controller {

	public function actionWorker($id) {
		
		return $this->render('worker', ['model' => \frontend\models\UserData::getById($id)]);
	}

	public function actionView2() {
		//l($slug);
		$ar1 = explode('?', $_SERVER['REQUEST_URI']);
		$arUrl = explode('/',$ar1[0]);
		$slug = array_pop($arUrl);
		$model = Page::find()->where(['slug' => $slug, 'status' => Page::STATUS_PUBLISHED])->one();
		if (!$model) {
			throw new NotFoundHttpException(Yii::t('frontend', 'Страница не найдена'));
		}

		$viewFile = $model->view ? : 'view';
		return $this->render($viewFile, ['model' => $model]);
	}
	public function actionView($slug) {
		//l($slug);
		$model = Page::find()->where(['slug' => $slug, 'status' => Page::STATUS_PUBLISHED])->one();
		if (!$model) {
			throw new NotFoundHttpException(Yii::t('frontend', 'Страница не найдена'));
		}

		$viewFile = $model->view ? : 'view';
		return $this->render($viewFile, ['model' => $model]);
	}

}
