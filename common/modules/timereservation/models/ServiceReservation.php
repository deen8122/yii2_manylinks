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
class ServiceReservation extends ActiveRecord {

	const STATUS_NEW = 1;
	const STATUS_ACTIVE = 2;
	const STATUS_DRAFT = 3;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%timereservation_reservation}}';
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

	/**
	 * @inheritdoc
	 */
	public function rulesx() {
		return [
			//['client_id', '0', 'value' => Yii::$app->user->identity->id],
			['status', self::STATUS_NEW],
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

	public function afterSave($insert, $changedAttributes) {
		parent::afterSave($insert, $changedAttributes);
		$this->trigger("SR1");
	}

}
