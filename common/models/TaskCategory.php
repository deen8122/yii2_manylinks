<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_category".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $text
 */
class TaskCategory extends \yii\db\ActiveRecord {

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'task_category';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['parent_id', 'name', 'text'], 'required'],
			[['parent_id'], 'integer'],
			[['text'], 'string'],
			[['name'], 'string', 'max' => 200],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'parent_id' => 'Parent ID',
			'name' => 'Name',
			'text' => 'Text',
		];
	}

	public static function getAll() {

		$cache = Yii::$app->cache;
//Кешируем массив $arr_tags    
		if (!$arr_tags = $cache->get('TaglistWidget_init')) {

			$arr_tags2 = TaskCategory::find()->asArray()->all();
			$arr_tags = [];
			foreach($arr_tags2 as $arr){
				$arr_tags[$arr['id']]=$arr['name'];
			}
			//$arr_tags[] = "CASHED ".  rand(99, 9999);
			$cache->set('TaglistWidget_init', $arr_tags, 3600);
		}

		return $arr_tags;
		/*
		  $db = Yii::$app->db; // or Category::getDb()
		  $result = $db->cache(function ($db) {
		  //echo 'cahce';
		  return TaskCategory::find()->all();
		  }, 36666);
		  return $result;
		 * 
		 */
	}

}
