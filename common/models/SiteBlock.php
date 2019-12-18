<?php

namespace common\models;

use common\behaviors\JsonBehavior;
use common\models\SiteBlockValue;

class SiteBlock extends \yii\db\ActiveRecord {

	const STATUS_ACTIVE = 1;
	const STATUS_DEACTIVE = 2;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'site_block';
	}

	public static function statuses() {
		return [
			self::STATUS_ACTIVE => "Активен",
			self::STATUS_DEACTIVE => "Не активен",
		];
	}

	public function behaviors() {
		return [
			[
				'class' => JsonBehavior::class,
				'property' => 'data',
				'jsonField' => 'data'
			]
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['site_id'], 'required'],
			[['text', 'name'], 'string'],
			[['sort', 'site_id', 'status'], 'integer'],
			[['name'], 'string', 'max' => 300],
			[['sort'], 'default', 'value' =>-1],
			[['name'], 'default', 'value' =>"title..."],
		];
	}

	public function getValues() {
		return $this->hasMany(SiteBlockValue::class, ['site_block_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
	}

}
