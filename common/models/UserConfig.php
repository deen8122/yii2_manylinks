<?php

namespace common\models;

use Yii;
use common\models\UserProfile;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $user_id
 * @property integer $locale
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $picture
 * @property string $avatar
 * @property string $avatar_path
 * @property string $avatar_base_url
 * @property integer $gender
 *
 * @property User $user
 */
class UserConfig extends UserProfile {

	public static function setData($key="def", $arr=[]) {
		$config = json_decode(Yii::$app->user->identity->userProfile->config, true);
		$config[$key] = $arr;
		$profileModel = UserProfile::findOne(Yii::$app->user->identity->id);
		$profileModel->config = \GuzzleHttp\json_encode($config);
		$profileModel->save();
	}
	
	public  static function getConfig(){
		return  json_decode(Yii::$app->user->identity->userProfile->config, true);
	}

}
