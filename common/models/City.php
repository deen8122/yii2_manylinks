<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property string $city_id
 * @property string $country_id
 * @property string $region_id
 * @property string $name
 */
class City extends \yii\db\ActiveRecord {

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'city';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['country_id', 'region_id'], 'integer'],
			[['name'], 'string', 'max' => 128],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'city_id' => 'City ID',
			'country_id' => 'Country ID',
			'region_id' => 'Region ID',
			'name' => 'Name',
		];
	}

	public static function search($search) {
		//запрос
		//$names = Yii::$app->db->createCommand('DELETE FROM _cities WHERE country_id!=1')->execute();
		$countryId = 1;
		$modelArray = City::find()
			//->select('city.name, city.city_id, region.name as region_name')
			->where(['LIKE', 'name', $search.'%',false])
			->andWhere(['=','country_id',$countryId])
			//->orderby(['city.name'=>SORT_ASC])
			//->joinWith('region')
			//
			// ->leftJoin('region', '`region`.`region_id` = `city`.`region_id`')
			->AsArray()
			->limit(20)
			->all();
		// вывод данных
		return $modelArray;
		//l($model);
	}

}
