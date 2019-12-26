<?php

namespace frontend\modules\user\models;

use cheatsheet\Time;
use common\commands\SendEmailCommand;
use common\models\User;
use common\models\UserToken;
use frontend\modules\user\Module;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\Url;

/**
 * Signup form
 */
class SignupForm extends Model {

	/**
	 * @var
	 */
	public $username;

	/**
	 * @var
	 */
	public $email;

	/**
	 * @var
	 */
	public $password;

	/**
	 * @inheritdoc
	 */
    public function rules()
    {
        return [
		/*
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('frontend', 'Это имя пользователя уже занято.')
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],
*/
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('frontend', 'Этот e-mail уже занят.')
            ],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

	/**
	 * @return array
	 */
	public function attributeLabels() {
		return [
			'username' => Yii::t('frontend', 'Имя пользователя'),
			'email' => Yii::t('frontend', 'E-mail'),
			'phone' => Yii::t('frontend', 'Телелефон'),
			'password' => Yii::t('frontend', 'Пароль'),
		];
	}

	/**
	 * Signs user up.
	 *
	 * @return User|null the saved model or null if saving fails
	 * @throws Exception
	 */
	public function signup() {
		if ($this->validate()) {
			$shouldBeActivated = $this->shouldBeActivated();
			$user = new User();
			$user->username = $this->email;
			$user->email = $this->email;
			$user->status = $shouldBeActivated ? User::STATUS_NOT_ACTIVE : User::STATUS_ACTIVE;
			$user->setPassword($this->password);
			if (!$user->save()) {
				//var_dump($user->errors);
				throw new Exception("User couldn't be  saved");
			};
			$user->afterSignup();
			if ($shouldBeActivated) {
				$token = UserToken::create(
						$user->id, UserToken::TYPE_ACTIVATION, Time::SECONDS_IN_A_DAY
				);
				Yii::$app->commandBus->handle(new SendEmailCommand([
					'subject' => Yii::t('frontend', 'Письмо активации'),
					'view' => 'activation',
					'to' => $this->email,
					'params' => [
						'url' => Url::to(['/user/sign-in/activation', 'token' => $token->token], true)
					]
				]));
			}
			return $user;
		}

		return null;
	}

	
	/**
	 * @return bool
	 */
	public function shouldBeActivated() {
		/** @var Module $userModule */
		$userModule = Yii::$app->getModule('user');
		if (!$userModule) {
			return false;
		} elseif ($userModule->shouldBeActivated) {
			return true;
		} else {
			return false;
		}
	}

}
