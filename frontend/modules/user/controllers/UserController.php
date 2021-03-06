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

class UserController extends Controller {

	/**
	 * @return array
	 */
	public function menu() {
		$this->view->params['menu'] = [
			["title" => "Настройки профиля", "url" => "/user/config/profile"],
			["title" => "Настройки авторизации", "url" => "/user/config/auth"]
		];
	}

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
	public function actionIndex() {
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
		return $this->render('index', ['model' => $model]);
	}

}
