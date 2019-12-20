<?php

namespace common\models;

class SiteBlockValue extends \yii\db\ActiveRecord {

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'site_block_value';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['site_block_id'], 'required'],
			[['value', 'name'], 'string'],
			[['sort'], 'integer'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		
	}

	public static function getIconByUrl($link) {
		$uri = strtolower(trim($link));
		$uri = preg_replace('%^(http:\/\/)*(https:\/\/)*(www.)*%usi', '', $uri);
		$uri = preg_replace('%\/.*$%usi', '', $uri);
		$arr = explode('.', $uri);
		return $arr[0];
	}

}
