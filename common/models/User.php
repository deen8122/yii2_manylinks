<?php

namespace common\models;

use common\commands\AddToTimelineCommand;
use common\models\query\UserQuery;
use common\models\Site;
use common\models\SiteBlock;
use common\models\SiteBlockValue;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property string $auth_key
 * @property string $access_token
 * @property string $oauth_client
 * @property string $oauth_client_user_id
 * @property string $publicIdentity
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $logged_at
 * @property string $password write-only password
 *
 * @property \common\models\UserProfile $userProfile
 */
class User extends ActiveRecord implements IdentityInterface {

	const STATUS_NOT_ACTIVE = 1;
	const STATUS_ACTIVE = 2;
	const STATUS_DELETED = 3;
	const ROLE_USER = 'user';
	const ROLE_MANAGER = 'manager';
	const ROLE_ADMINISTRATOR = 'administrator';
	const EVENT_AFTER_SIGNUP = 'afterSignup';
	const EVENT_AFTER_LOGIN = 'afterLogin';

	//public $site = 0;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%user}}';
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id) {
		return static::find()
				->active()
				->andWhere(['id' => $id])
				->one();
	}

	/**
	 * @return UserQuery
	 */
	public static function find() {
		return new UserQuery(get_called_class());
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null) {
		return static::find()
				->active()
				->andWhere(['access_token' => $token])
				->one();
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return User|array|null
	 */
	public static function findByUsername($username) {
		return static::find()
				->active()
				->andWhere(['username' => $username])
				->one();
	}

	/**
	 * Finds user by username or email
	 *
	 * @param string $login
	 * @return User|array|null
	 */
	public static function findByLogin($login) {
		return static::find()
				->active()
				->andWhere(['or', ['username' => $login], ['email' => $login]])
				->one();
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			TimestampBehavior::class,
			'auth_key' => [
				'class' => AttributeBehavior::class,
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => 'auth_key'
				],
				'value' => Yii::$app->getSecurity()->generateRandomString()
			],
			'access_token' => [
				'class' => AttributeBehavior::class,
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => 'access_token'
				],
				'value' => function () {
					return Yii::$app->getSecurity()->generateRandomString(40);
				}
			]
		];
	}

	/**
	 * @return array
	 */
	public function scenarios() {
		return ArrayHelper::merge(
				parent::scenarios(), [
				'oauth_create' => [
					'oauth_client', 'oauth_client_user_id', 'email', 'username', '!status'
				]
				]
		);
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['site_id'], 'integer'],
			[['username', 'email'], 'unique'],
			['status', 'default', 'value' => self::STATUS_NOT_ACTIVE],
			['site_id', 'default', 'value' => 0],
				['phone', 'default', 'value' => 0],
			['status', 'in', 'range' => array_keys(self::statuses())],
			[['username'], 'filter', 'filter' => '\yii\helpers\Html::encode']
		];
	}

	/**
	 * Returns user statuses list
	 * @return array|mixed
	 */
	public static function statuses() {
		return [
			self::STATUS_NOT_ACTIVE => Yii::t('common', '??????????????????'),
			self::STATUS_ACTIVE => Yii::t('common', '??????????????'),
			self::STATUS_DELETED => Yii::t('common', '??????????????')
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'username' => Yii::t('common', '?????? ????????????????????????'),
			'email' => Yii::t('common', 'E-mail'),
			'status' => Yii::t('common', '????????????'),
			'access_token' => Yii::t('common', '?????????? ?????????????? ?? API'),
			'created_at' => Yii::t('common', '??????????????'),
			'updated_at' => Yii::t('common', '?????????????????? ????????????????????'),
			'logged_at' => Yii::t('common', '?????????????????? ????????'),
			'site_id' => "?????????????? ????????????",
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUserProfile() {
		return $this->hasOne(UserProfile::class, ['user_id' => 'id']);
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey) {
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey() {
		return $this->auth_key;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password) {
		return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password) {
		$this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
	}

	/**
	 * Creates user profile and application event
	 * @param array $profileData
	 */
	public function afterSignup(array $profileData = []) {
		$this->refresh();
		Yii::$app->commandBus->handle(new AddToTimelineCommand([
			'category' => 'user',
			'event' => 'signup',
			'data' => [
				'public_identity' => $this->getPublicIdentity(),
				'user_id' => $this->getId(),
				'created_at' => $this->created_at
			]
		]));
		$profile = new UserProfile();
		$profile->locale = Yii::$app->language;
		$profile->load($profileData, '');
		$this->link('userProfile', $profile);
		$this->trigger(self::EVENT_AFTER_SIGNUP);
		// Default role
		$auth = Yii::$app->authManager;
		$auth->assign($auth->getRole(User::ROLE_USER), $this->getId());
	}

	

	/**
	 * @return string
	 */
	public function getPublicIdentity() {
		if ($this->userProfile && $this->userProfile->getFullname()) {
			return $this->userProfile->getFullname();
		}
		if ($this->username) {
			return $this->username;
		}
		return $this->email;
	}

	public function getSite() {
		//return $this->site_id;
		return $this->hasOne(Site::class, ['id' => 'site_id']);
	}

	public function getSites() {
		//return $this->site_id;
		return $this->hasMany(Site::className(), ['id' => 'site_id'])
				->viaTable('user_site', ['user_id' => 'id']);
	}

	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->getPrimaryKey();
	}

	public function getLastname() {
		return $this->userProfile->lastname;
	}

	public static function setConfig($key = "def", $arr = []) {
		$config = json_decode(Yii::$app->user->identity->userProfile->config, true);
		$config[$key] = $arr;
		$profileModel = UserProfile::findOne(Yii::$app->user->identity->id);
		$profileModel->config = \GuzzleHttp\json_encode($config);
		$profileModel->save();
	}

	public static function getConfig() {
		return json_decode(Yii::$app->user->identity->userProfile->config, true);
	}
	
	
	public  function checkAppVersion(){
		/*
		 * 1 . ?????????????? ?????????????? ???????????? ?????? ????????????????????.
		 * 2 . ???????? ???????????????????? ???? ?????????? ????????????????
		 */
	}
	

}
