<?php

namespace common\modules\timereservation\models;

use common\models\query\ArticleQuery;
use Yii;
use common\modules\timereservation\models\ServiceCategory;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use common\models\User;
 use yii\base\Event;
class Service extends ActiveRecord {

	const STATUS_PUBLISHED = 1;
	const STATUS_DRAFT = 0;

	/**
	 * @var array
	 */
	public $attachments;

	/**
	 * @var array
	 */
	public $thumbnail;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%timereservation_service}}';
	}

	/**
	 * @return ArticleQuery
	 */
	public static function find() {
		/* you can add more dynamic logic here */
		return parent::find()->where(['site_id' => Yii::$app->user->identity->site->id]);
	}

	/**
	 * @return array statuses list
	 */
	public static function statuses() {
		return [
			self::STATUS_DRAFT => Yii::t('common', 'Draft'),
			self::STATUS_PUBLISHED => Yii::t('common', 'Опубликовано'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'site_id' => [
				'class' => AttributeBehavior::className(),
				'value' => function( $event) {
					return Yii::$app->user->identity->site->id;
				},
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['site_id'],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['title', 'body','longtime'], 'required'],
			[['body','color'], 'string'],
			[['category_id'], 'exist', 'targetClass' => ServiceCategory::class, 'targetAttribute' => 'id'],
			[['status','category_id'], 'integer'],
			[['price'], 'string'],
			[['title'], 'string', 'max' => 512],
			[['view'], 'string', 'max' => 255],
			 [['users'], 'safe']
			//[['site_id', 'integer'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => Yii::t('common', 'ID'),
			'users' => "Персонал",
			'longtime' => "Проложительность услуги в минутах",
			'price' => "Стоимость услуги",
			'sort' => "Сортировка",
			'title' => Yii::t('common', 'Название'),
			'body' => Yii::t('common', 'Текст'),
			'view' => Yii::t('common', 'Шаблон статьи'),
			'thumbnail' => Yii::t('common', 'Эскиз изображения'),
			'category_id' => Yii::t('common', 'Категория'),
			'status' => Yii::t('common', 'Опубликовано'),
			'published_at' => Yii::t('common', 'Дата публикации'),
			'created_by' => Yii::t('common', 'Автор'),
			'updated_by' => Yii::t('common', 'Обновивший'),
			'created_at' => Yii::t('common', 'Создано'),
			'updated_at' => Yii::t('common', 'Обновлено'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUsers() {
		return $this->hasMany(User::className(), ['id' => 'user_id'])
				->viaTable('timereservation_service_user', ['service_id' => 'id']);
	}

	public function setUsers($values) {
		return $this->users = $values;
	}

	public function afterSave($insert, $changedAttributes) {
		//обновляем связи с цветами
		$this->unlinkAll('users', true);
		foreach ($this->users as $userId) {
		      $user = User::findOne($userId);
			$this->link('users', $user);
		}


		parent::afterSave($insert, $changedAttributes);
		  Yii::$app->trigger('test', new \yii\base\Event(['sender' => []]));
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCategory() {
		return $this->hasOne(ArticleCategory::class, ['id' => 'category_id']);
	}

}
