<?php

namespace common\modules\timereservation\models;

use common\models\query\ArticleCategoryQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;

/**
 * This is the model class for table "article_category".
 *
 * @property integer         $id
 * @property string          $title
 * @property integer         $status
 *
 * @property Article[]       $articles
 * @property ArticleCategory $parent
 */
class ServiceCategory extends ActiveRecord {

	const STATUS_ACTIVE = 1;
	const STATUS_DRAFT = 0;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%timereservation_category}}';
	}

	public static function find() {
		/* you can add more dynamic logic here */
		return parent::find()->where(['site_id' => Yii::$app->user->identity->site->id]);
	}

	/**
	 * @return array statuses list
	 */
	public static function statuses() {
		return [
			self::STATUS_DRAFT => Yii::t('common', 'Не активен'),
			self::STATUS_ACTIVE => Yii::t('common', 'Активен'),
		];
	}

	/** @inheritdoc */
	public function behaviors() {
		return [
			'site_id' => [
				'class' => AttributeBehavior::className(),
				'value' => function( $event) {
					return Yii::$app->user->identity->site;
				},
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['site_id'],
				],
			]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [

			[['title'], 'required'],
			[['title'], 'string', 'max' => 512],
			['parent_id', 'exist', 'targetClass' => ArticleCategory::class, 'targetAttribute' => 'id'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => Yii::t('common', 'ID'),
			'title' => Yii::t('common', 'Название'),
			'parent_id' => Yii::t('common', 'Родительская категория'),
			'status' => Yii::t('common', 'Активно'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getArticles() {
		return $this->hasMany(Article::class, ['category_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getParent() {
		return $this->hasMany(ArticleCategory::class, ['id' => 'parent_id']);
	}

}
