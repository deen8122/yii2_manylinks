<?php

namespace common\models;

class SiteBlockValue extends \yii\db\ActiveRecord {

	const STATUS_ACTIVE = 1;
	const STATUS_DEACTIVE = 2;

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
			[['sort', 'status'], 'integer'],
			[['status'], 'default', 'value' => SiteBlockValue::STATUS_ACTIVE],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		
	}

	public static function getIconByUrl($link) {

		if (strpos($link, 'blogspot.com') !== false)
			return 'blogspot';
		$uri = strtolower(trim($link));
		$uri = preg_replace('%^(http:\/\/)*(https:\/\/)*(www.)*%usi', '', $uri);
		$uri = preg_replace('%\/.*$%usi', '', $uri);
		$arr = explode('.', $uri);
		if($arr[1]!="com"&&$arr[1]!="ru"){
			$arr[0] = $arr[0].'-'.$arr[1];
		}
		return $arr[0];
	}

	public function setActive($bool) {

		if ($bool) {
			$this->status = SiteBlockValue::STATUS_ACTIVE;
		} else {
			$this->status = SiteBlockValue::STATUS_DEACTIVE;
		}
		$this->save();
	}

}
