<?php

namespace frontend\modules\user\controllers;

use common\base\MultiModel;
use frontend\modules\user\models\AccountForm;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;

class ConfigController extends Controller {

	/**
	 * @return array
	 */
	public function actions() {
		return [
			'avatar-upload' => [
				'class' => UploadAction::class,
				'deleteRoute' => 'avatar-delete',
				'on afterSave' => function ($event) {
					/* @var $file \League\Flysystem\File */
					$file = $event->file;
					$img = ImageManagerStatic::make($file->read())->fit(215, 215);
					$file->put($img->encode());
				}
			],
			'avatar-delete' => [
				'class' => DeleteAction::class
			]
		];
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
	public function actionAuth() {
		$accountForm = new AccountForm();
		$accountForm->setUser(Yii::$app->user->identity);

		$model = new MultiModel([
			'models' => [
				'account' => $accountForm,
				'profile' => Yii::$app->user->identity->userProfile
			]
		]);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$locale = $model->getModel('profile')->locale;
			Yii::$app->session->setFlash('forceUpdateLocale');
			Yii::$app->session->setFlash('alert', [
				'options' => ['class' => 'alert-success'],
				'body' => Yii::t('frontend', 'Ваш аккаунт был успешно сохранён', [], $locale)
			]);
			return $this->refresh();
		}
		return $this->render('auth', ['model' => $model]);
	}

	/**
	 * @return string|\yii\web\Response
	 */
	public function actionSite() {
		$model = \common\models\Site::find()->where(['id' => Yii::$app->user->identity->site_id])->one();
		if ($model == null) {
			$model = new \common\models\Site();
			$model->name = Yii::$app->user->identity->email;
			$model->code = Yii::$app->user->identity->email;
			$model->save();
			$user = User::findOne(['id' => Yii::$app->user->identity->id]);
			$user->site_id = $model->id;
			$user->save();
		}


		if ($model->load(Yii::$app->request->post()) && $model->save()) {

			//Yii::$app->user->identity->site_id = $model->id;
			//$locale = $model->getModel('profile')->locale;
			Yii::$app->session->setFlash('forceUpdateLocale');
			Yii::$app->session->setFlash('alert', [
				'options' => ['class' => 'alert-success'],
				'body' => Yii::t('frontend', 'Ваш аккаунт был успешно сохранён', [], $locale)
			]);
			return $this->refresh();
		}
		
		
		
		return $this->render('site', ['model' => $model]);
	}

	public function actionSelectsite() {
		$model = Yii::$app->user->identity;
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->setFlash('alert', [
				'options' => ['class' => 'alert-success'],
				'body' => "Данные сохранены"
			]);			
		}
		return $this->redirect(['/user/config/site']);
		
	}

	public function actionProfile() {
		$accountForm = new AccountForm();
		$accountForm->setUser(Yii::$app->user->identity);

		$model = new MultiModel([
			'models' => [
				//'account' => $accountForm,
				'profile' => Yii::$app->user->identity->userProfile
			]
		]);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {

			$locale = $model->getModel('profile')->locale;
			Yii::$app->session->setFlash('forceUpdateLocale');
			Yii::$app->session->setFlash('alert', [
				'options' => ['class' => 'alert-success'],
				'body' => Yii::t('frontend', 'Ваш аккаунт был успешно сохранён', [], $locale)
			]);
			return $this->refresh();
		} else {
			//l($_POST);
		}
		return $this->render('profile', ['model' => $model]);
	}

}
