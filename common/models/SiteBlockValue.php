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

}
