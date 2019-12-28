<?php

namespace common\models;

use common\behaviors\JsonBehavior;
use common\models\SiteBlockValue;
use common\models\SiteVersion;

class SiteBlock extends \yii\db\ActiveRecord {

	const TYPE_SIMPLE_TEXT = 1;
	const TYPE_LINKS = 2;
	const TYPE_HTML_TEXT = 3;
	const TYPE_HEADER_PHOTO = 4;
	const STATUS_ACTIVE = 1;
	const STATUS_DEACTIVE = 2;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'site_block';
	}

	public static function getBlockNames() {
		return [
			self::TYPE_SIMPLE_TEXT => "text",
			self::TYPE_LINKS => "links",
			self::TYPE_HTML_TEXT => "html",
			self::TYPE_HEADER_PHOTO => "header",
		];
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
			[['sort'], 'default', 'value' => -1],
			[['name'], 'default', 'value' => "title..."],
		];
	}

	public function getValues() {
		return $this->hasMany(SiteBlockValue::class, ['site_block_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
	}

	public function beforeSave($insert) {
		if ($insert) {
			//проверяем текущую версию приложения
			$errorText = '';
			if (SiteVersion::check($this->type, $errorText)) {
				return parent::beforeSave($insert);
			} else {
				$this->addError('model', $errorText);
			}

			return false;
		} else
			return parent::beforeSave($insert);
	}

}
