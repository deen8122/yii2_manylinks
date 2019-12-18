<?php

namespace frontend\modules\user;

class Module extends \yii\base\Module {

	/**
	 * @var string
	 */
	public $controllerNamespace = 'frontend\modules\user\controllers';

	/**
	 * @var bool Is users should be activated by email
	 */
	public $shouldBeActivated = false;

	/**
	 * @var bool Enables login by pass from backend
	 */
	public $enableLoginByPass = false;

	/**
	 * @inheritdoc
	 */
	public function init() {
		parent::init();
		$this->view->params['menu'] = [
			["title" => "Страница", "url" => "/user/page/index"],
			["title" => "Отзывы", "url" => "/user/config/profile"],
			["title" => "Настройки профиля", "url" => "/user/config/profile"],
			["title" => "Настройки авторизации", "url" => "/user/config/auth"],
			["title" => "Выход", "url" => "/user/sign-in/logout"],
			
		];
	}

}
