<?php

namespace frontend\modules\user\controllers;

use common\commands\SendEmailCommand;
use common\models\User;
use common\models\UserToken;
use frontend\modules\user\models\LoginForm;
use frontend\modules\user\models\PasswordResetRequestForm;
use frontend\modules\user\models\ResetPasswordForm;
use frontend\modules\user\models\SignupForm;
use Yii;
use yii\authclient\AuthAction;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class SignInController
 * @package frontend\modules\user\controllers
 * @author Eugene Terentev <eugene@terentev.net>
 */
class SignInController extends \yii\web\Controller {

	/**
	 * @return array
	 */
	public function actions() {
		return [
			'oauth' => [
				'class' => AuthAction::class,
				'successCallback' => [$this, 'successOAuthCallback']
			]
		];
	}

	public function beforeAction($action) {
		//$this->layout = 'site'; //your layout name
		$this->layout = '@app/views/layouts/site';
		return parent::beforeAction($action);
	}

	public  function goHome(){
		return Yii::$app->controller->redirect(['/user/sign-in/login']);
	}
	/**
	 * @return array testtest@mail.ru
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'actions' => [
							'signup', 'login', 'loginform', 'login-by-pass', 'request-password-reset', 'reset-password', 'oauth', 'activation'
						],
						'allow' => true,
						'roles' => ['?']
					],
					[
						'actions' => [
							'signup', 'loginform', 'login', 'request-password-reset', 'reset-password', 'oauth', 'activation'
						],
						'allow' => false,
						'roles' => ['@'],
						'denyCallback' => function () {
							return Yii::$app->controller->redirect(['/user/default/index']);
						}
					],
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
				//'logout' => ['post']
				]
			]
		];
	}

	/**
	 * @return array|string|Response
	 */
	public function actionLogin() {
		$model = new LoginForm();
		if (Yii::$app->request->isAjax) {
			$model->load($_POST);
			Yii::$app->response->format = Response::FORMAT_JSON;
			$result = ActiveForm::validate($model);
			if (count($result) > 0)
				return $result;
		}
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			//l($_REQUEST);
			/*
			  if ($_POST['need_responce']) {
			  Yii::$app->response->format = Response::FORMAT_JSON;
			  return json_encode(['code' => 1]);
			  }
			 * 
			 */
			if (isset($_REQUEST['back'])) {

				return Yii::$app->getResponse()->redirect($_GET['back']);
			}
			return Yii::$app->getResponse()->redirect('/user/page');
			//return $this->goBack();
		}

		return $this->render('login', [
				'model' => $model
		]);
	}

	public function actionLoginform() {
		$model = new LoginForm();
		return $this->render('login', [
				'model' => $model
		]);
	}

	/**
	 * @param $token
	 * @return array|string|Response
	 * @throws ForbiddenHttpException
	 * @throws \Exception
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
	 */
	public function actionLoginByPass($token) {
		if (!$this->module->enableLoginByPass) {
			throw new NotFoundHttpException();
		}

		$user = UserToken::use($token, UserToken::TYPE_LOGIN_PASS);

		if ($user === null) {
			throw new ForbiddenHttpException();
		}

		Yii::$app->user->login($user);
		return $this->goHome();
	}

	/**
	 * @return Response
	 */
	public function actionLogout() {
		Yii::$app->user->logout();
		return $this->goHome();
	}

	/**
	 * @return string|Response
	 */
	public function actionSignup() {
		$model = new SignupForm();
		if ($model->load(Yii::$app->request->post())) {
			$user = $model->signup();
			if ($user) {
				if ($model->shouldBeActivated()) {
					Yii::$app->getSession()->setFlash('alert', [
						'body' => Yii::t(
							'frontend', 'На ваш e-mail отправлено письмо для активации аккаунта'
						),
						'options' => ['class' => 'alert-success']
					]);
				} else {
					Yii::$app->getUser()->login($user);
				}
				return Yii::$app->getResponse()->redirect('/user/page');
				//return $this->goHome();
			}
		}

		return $this->render('signup', [
				'model' => $model
		]);
	}

	/**
	 * @param $token
	 * @return Response
	 * @throws BadRequestHttpException
	 */
	public function actionActivation($token) {
		$token = UserToken::find()
			->byType(UserToken::TYPE_ACTIVATION)
			->byToken($token)
			->notExpired()
			->one();

		if (!$token) {
			throw new BadRequestHttpException;
		}

		$user = $token->user;
		$user->updateAttributes([
			'status' => User::STATUS_ACTIVE
		]);
		$token->delete();
		Yii::$app->getUser()->login($user);
		Yii::$app->getSession()->setFlash('alert', [
			'body' => Yii::t('frontend', 'Ваш аккаунт был успешно активирован. '),
			'options' => ['class' => 'alert-success']
		]);

		return $this->goHome();
	}

	/**
	 * @return string|Response
	 */
	public function actionRequestPasswordReset() {
		$model = new PasswordResetRequestForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail()) {
				Yii::$app->getSession()->setFlash('alert', [
					'body' => Yii::t('frontend', 'Проверьте ваш e-mail.'),
					'options' => ['class' => 'alert-success']
				]);

				return $this->goHome();
			} else {
				Yii::$app->getSession()->setFlash('alert', [
					'body' => Yii::t('frontend', 'Извините, мы не можем сбросить пароль для этого e-mail.'),
					'options' => ['class' => 'alert-danger']
				]);
			}
		}

		return $this->render('requestPasswordResetToken', [
				'model' => $model,
		]);
	}

	/**
	 * @param $token
	 * @return string|Response
	 * @throws BadRequestHttpException
	 */
	public function actionResetPassword($token) {
		try {
			$model = new ResetPasswordForm($token);
		} catch (InvalidArgumentException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
			Yii::$app->getSession()->setFlash('alert', [
				'body' => Yii::t('frontend', 'Новый пароль был сохранён'),
				'options' => ['class' => 'alert-success']
			]);
			return $this->goHome();
		}

		return $this->render('resetPassword', [
				'model' => $model,
		]);
	}

	/**
	 * @param $client \yii\authclient\BaseClient
	 * @return bool
	 * @throws Exception
	 */
	public function successOAuthCallback($client) {
		// use BaseClient::normalizeUserAttributeMap to provide consistency for user attribute`s names
		$attributes = $client->getUserAttributes();
		//l($attributes);exit; 
		$user = User::find()->where([
				'oauth_client' => $client->getName(),
				'oauth_client_user_id' => ArrayHelper::getValue($attributes, 'id')
			])->one();
		if (!$user) {
			$user = new User();
			$user->scenario = 'oauth_create';
			$user->username = ArrayHelper::getValue($attributes, 'login');
			// check default location of email, if not found as in google plus dig inside the array of emails
			$email = ArrayHelper::getValue($attributes, 'email');
			if ($email === null) {
				$email = ArrayHelper::getValue($attributes, ['emails', 0, 'value']);
			}
			if($email === null){
			$email = ArrayHelper::getValue($attributes, ['user_id', 0, 'value']).'@nomail.net';
			
		}
			$user->email = $email;
			$user->oauth_client = $client->getName();
			$user->oauth_client_user_id = ArrayHelper::getValue($attributes, 'id');
			$user->status = User::STATUS_ACTIVE;
			$password = Yii::$app->security->generateRandomString(8);
			$user->setPassword($password);
			if ($user->save()) {
				$profileData = [];
				if ($client->getName() === 'vkontakte') {
					$profileData['firstname'] = ArrayHelper::getValue($attributes, 'first_name');
					$profileData['lastname'] = ArrayHelper::getValue($attributes, 'last_name');
				}
				$user->afterSignup($profileData);
				/*
				$sentSuccess = Yii::$app->commandBus->handle(new SendEmailCommand([
					'view' => 'oauth_welcome',
					'params' => ['user' => $user, 'password' => $password],
					'subject' => Yii::t('frontend', '{app-name} | Информация о пользователе', ['app-name' => Yii::$app->name]),
					'to' => $user->email
				]));
				*/
				if ($sentSuccess) {
					Yii::$app->session->setFlash(
						'alert', [
						'options' => ['class' => 'alert-success'],
						'body' => Yii::t('frontend', 'Добро пожаловать в {app-name}. E-mail с информацией о пользователе был отправлен на вашу почту.', [
							'app-name' => Yii::$app->name
						])
						]
					);
				}
			} else {
				// We already have a user with this email. Do what you want in such case
				if ($user->email && User::find()->where(['email' => $user->email])->count()) {
					Yii::$app->session->setFlash(
						'alert', [
						'options' => ['class' => 'alert-danger'],
						'body' => Yii::t('frontend', 'Пользователь с e-mail {email} уже зарегистрирован.', [
							'email' => $user->email
						])
						]
					);
				} else {
					Yii::$app->session->setFlash(
						'alert', [
						'options' => ['class' => 'alert-danger'],
						'body' => Yii::t('frontend', 'Ошибка в процессе OAuth авторизации.')
						]
					);
				}
			};
		}
		if (Yii::$app->user->login($user, 3600 * 24 * 30)) {
			return true;
		}

		throw new Exception('OAuth error');
	}

}
