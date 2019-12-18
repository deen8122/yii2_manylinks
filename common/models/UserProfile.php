<?php

namespace common\models;

use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\db\ActiveRecord;

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
class UserProfile extends ActiveRecord {

	const GENDER_MALE = 1;
	const GENDER_FEMALE = 2;

	/**
	 * @var
	 */
	public $picture;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%user_profile}}';
	}

	/**
	 * @return array
	 */
	public function behaviors() {
		return [
			'picture' => [
				'class' => UploadBehavior::class,
				'attribute' => 'picture',
				'pathAttribute' => 'avatar_path',
				'baseUrlAttribute' => 'avatar_base_url'
			]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['user_id'], 'required'],
			[['user_id', 'gender','location'], 'integer'],
			[['gender'], 'in', 'range' => [NULL, self::GENDER_FEMALE, self::GENDER_MALE]],
			[['firstname', 'middlename', 'lastname', 'avatar_path', 'avatar_base_url'], 'string', 'max' => 255],
			['locale', 'default', 'value' => Yii::$app->language],
			['locale', 'in', 'range' => array_keys(Yii::$app->params['availableLocales'])],
			['picture', 'safe'],
			['about', 'safe'],
			[['birthday'], 'default', 'value' => function () {
				return date(DATE_ISO8601);
			}],
			[['work_position', 'phone', 'address','config'], 'string', 'max' => 255],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'user_id' => Yii::t('common', 'ID пользователя'),
			'firstname' => Yii::t('common', 'Имя'),
			'middlename' => Yii::t('common', 'Отчество'),
			'lastname' => Yii::t('common', 'Фамилия'),
			'locale' => Yii::t('common', 'Локаль'),
			'picture' => Yii::t('common', 'Аватар'),
			'gender' => Yii::t('common', 'Пол'),
			'work_position' => "Должность",
			'phone' => "Телефон",
			'avatar' => "Фото карточка",
			'address' => "Адрес",
			'birthday' => "День рождения",
			'about' => "Информация о себе",
			'work_position_id' => "Привязка к структуре ",
			'config' => "Настройки",
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser() {
		return $this->hasOne(User::class, ['id' => 'user_id']);
	}

	/**
	 * @return null|string
	 */
	public function getFullName() {
		if ($this->firstname || $this->lastname) {
			return implode(' ', [$this->firstname, $this->lastname]);
		}
		return null;
	}
	public function getFullNameExt() {
		return $this->user->email.' - '.$this->firstname.''.$this->lastname;
	}
	public function getConfig() {
		return $this->config;
	}

	/**
	 * @param null $default
	 * @return bool|null|string
	 */
	public function getAvatar($default = null) {
		return $this->avatar_path ? Yii::getAlias($this->avatar_base_url . '/' . $this->avatar_path) : $default;
	}

}
