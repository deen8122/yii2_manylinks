<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * ContactForm is the model behind the contact form.
 */
class UserData {

	public $user;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;

	/**
	 * @return array customized attribute labels
	 */
	public static function getById($user_id) {
		$arr = [];
		$arr['user'] = User::findIdentity($user_id);
		$arr['reviews'] = [];
		return $arr;
	}

}
