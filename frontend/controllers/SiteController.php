<?php

namespace frontend\controllers;

use cheatsheet\Time;
use common\models\Site;
use yii\data\ActiveDataProvider;
use common\sitemap\UrlsIterator;
use frontend\models\ContactForm;
use Sitemaped\Element\Urlset\Urlset;
use Sitemaped\Sitemap;
use Yii;
use yii\filters\PageCache;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use common\models\City;
use common\models\UserConfig;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller {

	public $bodyClass = "default";
	public $bodyStyle = "";

	/**
	 * @return array
	 */
	public function behaviors() {
		return [
			[
				'class' => PageCache::class,
				'only' => ['sitemap'],
				'duration' => Time::SECONDS_IN_AN_HOUR,
			]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction'
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
			],
			'set-locale' => [
				'class' => 'common\actions\SetLocaleAction',
				'locales' => array_keys(Yii::$app->params['availableLocales'])
			]
		];
	}

	/*
	 * Публичная страница пользователя
	 */

	public function actionPage($slug) {
		$this->layout = 'personal-page'; //your layout name
		$model = Site::find()->where(['code' => $slug])->one();
		if (!$model) {
			throw new NotFoundHttpException(Yii::t('frontend', 'Страница не найдена'));
		}
		if ($model->dataArray['bgClass'] == 'bg-image') {
			$this->bodyStyle = 'background-image:url(/img/bgImages/' . $model->dataArray['img'] . '.jpg';
		}
		if ($model->dataArray['bgClass'] == 'bg-image-src') {
			$this->bodyStyle = 'background-image:url(' . $model->dataArray['img'] . ')';
		}
		if ($model->dataArray['bgClass']) {
			$this->bodyClass = $model->dataArray['bgClass'];
		}

		return $this->render('personal-page', ['model' => $model]);
	}

	public function beforeAction($action) {
		$this->layout = 'site'; //your layout name
		return parent::beforeAction($action);
	}

	/**
	 * @return string
	 */
	public function actionIndex() {
		$query = \common\models\Site::find();
		$query->orderBy(['id' => SORT_DESC]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 5,
			],
		]);

		return $this->render('index', [
				'dataProvider' => $dataProvider,
		]);
	}

	public function actionPrice() {


		return $this->render('price');
	}

	public function actionHelp() {


		return $this->render('help');
	}

	public function actionPrivacy_policy() {


		return $this->render('privacy_policy');
	}

	/**
	 * @return string|Response
	 */
	public function actionContacts() {
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post())) {
			if ($model->contact(Yii::$app->params['adminEmail'])) {
				Yii::$app->getSession()->setFlash('alert', [
					'body' => Yii::t('frontend', 'Спасибо. Мы свяжемся с Вами в ближайшее время.'),
					'options' => ['class' => 'alert-success']
				]);
				return $this->refresh();
			}

			Yii::$app->getSession()->setFlash('alert', [
				'body' => \Yii::t('frontend', 'Ошибка при отправке сообщения.'),
				'options' => ['class' => 'alert-danger']
			]);
		}

		return $this->render('contact', [
				'model' => $model
		]);
	}

	public function actionTest() {
		$email = new \frontend\models\EmailSend();
		$email->send(\frontend\models\EmailSend::TYPE_ACTIVATION, [
			'url' => Url::to(['/user/sign-in/activation', 'token' => "xxxxx"])
		]);

		return $this->render('price');
	}

}
