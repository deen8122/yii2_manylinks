<?php

namespace backend\models\search;
use Yii;
use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User {

	public $lastname;

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['id', 'status'], 'integer'],
			[['created_at', 'updated_at', 'logged_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
			[['created_at', 'updated_at', 'logged_at'], 'default', 'value' => null],
			[['username', 'auth_key', 'password_hash', 'email'], 'safe'],
			//Добавляем для фильтрации
			[['lastname'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Creates data provider instance with search query applied
	 * @return ActiveDataProvider
	 */
	public function search($params) {
		$query = User::find()->where(['site_id' => Yii::$app->user->identity->site->id]);
		//$query->joinWith(array('userProfile'));
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		/*
		  $dataProvider->sort->attributes['lastname'] = [
		  // The tables are the ones our relation are configured to
		  // in my case they are prefixed with "tbl_"
		  'asc' => ['lastname' => SORT_ASC],
		  'desc' => ['lastname' => SORT_DESC],
		  ];
		 * 
		 */
		/**
		 * Настройка параметров сортировки
		 * Важно: должна быть выполнена раньше $this->load($params)
		
		$dataProvider->setSort([
			'attributes' => [
				'lastname' => [
					'asc' => ['user_profile.lastname' => SORT_ASC],
					'desc' => ['user_profile.lastname' => SORT_DESC],
				],
			]
		]);
		 *  
		 */
		$dataProvider->sort->attributes['lastname'] = [
			'asc' => ['user_profile.lastname' => SORT_ASC],
			'desc' => ['user_profile.lastname' => SORT_DESC],
		];
		if (!($this->load($params) && $this->validate())) {
			/**
			 * Жадная загрузка данных модели Страны
			 * для работы сортировки.
			 */
			$query->joinWith('userProfile');
			return $dataProvider;
		}

		$dataProvider->sort->attributes['lastname'] = [
			'asc' => ['user_profile.lastname' => SORT_ASC],
			'desc' => ['user_profile.lastname' => SORT_DESC],
		];
		//$query->andFilterWhere(['like', 'user_profile.lastname', "" . $this->lastname]);
		/*
		 * $query->andFilterWhere(['like', 'lastname', $this->userProfile->lastname]);
		 */
// Фильтр по стране
		$query->joinWith(['userProfile' => function ($q) {
				$q->where('user_profile.lastname LIKE "%' . $this->lastname . '%"');
			}]);

		$query->andFilterWhere([
			'id' => $this->id,
			'status' => $this->status,
		]);

		if ($this->created_at !== null) {
			$query->andFilterWhere(['between', 'created_at', $this->created_at, $this->created_at + 3600 * 24]);
		}

		if ($this->updated_at !== null) {
			$query->andFilterWhere(['between', 'updated_at', $this->updated_at, $this->updated_at + 3600 * 24]);
		}

		if ($this->logged_at !== null) {
			$query->andFilterWhere(['between', 'logged_at', $this->logged_at, $this->logged_at + 3600 * 24]);
		}

		$query->andFilterWhere(['like', 'username', $this->username])
			->andFilterWhere(['like', 'auth_key', $this->auth_key])
			->andFilterWhere(['like', 'password_hash', $this->password_hash])
			->andFilterWhere(['like', 'email', $this->email]);

		/*

		 * 
		 */
		return $dataProvider;
	}

}
