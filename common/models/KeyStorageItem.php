<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;

/**
 * This is the model class for table "key_storage_item".
 *
 * @property integer $key
 * @property integer $value
 */
class KeyStorageItem extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%key_storage_item}}';
	}

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
			[
				'class' => TimestampBehavior::class,
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['key', 'value'], 'required'],
			[['key'], 'string', 'max' => 128],
			[['value', 'comment'], 'safe'],
			[['key'], 'unique']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'key' => Yii::t('common', 'Ключ'),
			'value' => Yii::t('common', 'Значение'),
			'comment' => Yii::t('common', 'Комментарий'),
		];
	}

	/**
	 * @return ArticleQuery
	 */
	public static function find() {
		/* you can add more dynamic logic here */
		return parent::find()->where(['site_id' => Yii::$app->user->identity->site->id]);
	}
	public static function getModuleParam($module_id=1,$key="c") {
		/* you can add more dynamic logic here */
		return parent::find()->where([
			'site_id' => Yii::$app->user->identity->site->id,
			'module_id'=>$module_id,
			'key'=>$key])->one();
	}
	public static function getModuleAllParams($module_id=1) {
		/* you can add more dynamic logic here */
		return parent::find()->where([
			'site_id' => Yii::$app->user->identity->site->id,
			'module_id'=>$module_id,
			])->asArray()->All();
	}

}
