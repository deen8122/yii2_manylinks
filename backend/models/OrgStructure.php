<?php

namespace app\models;

use Yii;
use common\models\ArticleCategory;

/**
 * This is the model class for table "org_structure".
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property int $parent_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class OrgStructure extends ArticleCategory {

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'org_structure';
	}

	

	/**
	 * {@inheritdoc}
	 */
	public function rules2() {
		return [
			[['slug', 'title'], 'required'],
			[['body'], 'string'],
			[['parent_id', 'status', 'created_at', 'updated_at'], 'integer'],
			[['slug'], 'string', 'max' => 1024],
			[['title'], 'string', 'max' => 512],
		];
	}



	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels2() {
		return [
			'id' => 'ID',
			'slug' => 'Slug',
			'title' => 'Title',
			'body' => 'Body',
			'parent_id' => 'Parent ID',
			'status' => 'Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		];
	}

}
