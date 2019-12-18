<?php

namespace common\models;

use common\models\City;
use common\models\UserProfile;
use common\models\TaskCategory;
use common\models\TaskMessage;

class Task extends \yii\db\ActiveRecord {

	const STATUS_ACTIVE = 1;
	const STATUS_DEACTIVE = 2;

	public $isOwner = 0;
	public $categories = [];
	public $priceTypeArr = [
		1 => "за всю работу",
		2 => "за 1 час работы",
	];

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'task';
	}

	public static function statuses() {
		return [
			self::STATUS_ACTIVE => "Активен",
			self::STATUS_DEACTIVE => "Не активен",
		];
	}

	public static function priceTypes() {
		return [
			1 => "за работу",
			2 => "за 1 час работы",
		];
	}

	public function getRespnoses() {
		return \common\models\TaskMessage::find()->andWhere(['task_id'=>$this->id])->groupBy('user_id')->count();
		//return $this->responses;
	}

	public static function respnosePlus($task_id, $user_id) {
		
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['name', 'text', 'location', 'user_id'], 'required'],
			[['text', 'price', 'tags'], 'string'],
			[['location', 'user_id', 'status', 'date_create', 'price_type'], 'integer'],
			[['name'], 'string', 'max' => 300],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'name' => 'Заголовок',
			'text' => 'Описание',
			'price' => 'Цена',
			'location' => 'Местоположение',
			'locationfull' => 'Местоположение',
			'user_id' => 'User ID',
			'status' => 'Статус',
			'tags' => 'Теги',
			'date_create' => 'Дата создания',
		];
	}

	public function getShowTime() {
		return $this->showDate($this->date_create);
	}

	public function getPriceTypeText() {
		return $this->priceTypeArr[$this->price_type];
	}

	public function getUserProfile() {
		return $this->hasOne(UserProfile::class, ['user_id' => 'user_id']);
	}

	public function getCategoriesId() {
		$arr = explode(",", $this->category_text);
		$arrRet = [];
		foreach ($arr as $id) {
			$id = str_replace('"', '', $id);
			$arrRet[$id] = $id;
		}
		return $arrRet;
	}

	public function getCity() {
		return $this->hasOne(City::class, ['city_id' => 'location']);
	}

	public function getUserowner() {
		return $this->hasOne(UserProfile::className(), ['user_id' => 'user_owner_id']);
	}

	public function getTaskMessage() {
		return $this->hasOne(TaskMessage::class, ['task_id' => 'id']);
	}

	public function getMessagesCount() {
		$col = TaskMessage::find()
			->andWhere(['task_id' => $this->id])
			//->andWhere(['message_to' => Yii::$app->user->identity->id])
			->count();
		return $col;
	}

	public function getCategoriesText() {
		$arTC = TaskCategory::getAll();
		//$arrCat = 
		$arr = explode(",", $this->category_text);
		$arrRet = [];
		foreach ($arr as $id) {
			$id = str_replace('"', '', $id);
			$arrRet[$id] = $arTC[$id];
		}
		return $arrRet;
		//return $this->hasOne(City::class, ['city_id' => 'location']);
	}

	public function getLocationFull() {
		//<?=$model->city->name.' '.$model->city->area

		return $this->city->name . ($this->city->region != '' ? ', ' . $this->city->region : '') . ($this->city->area != '' ? ', ' . $this->city->area : '');
	}

	public function beforeSave($insert) {
		$ci = '';
		foreach ($this->categories as $id) {
			$ci.='"' . $id . '",';
		}
		$this->category_text = chop($ci, ',');
		$this->date_create = time();

		return parent::beforeSave($insert);
	}

	function showDate($date) { // $date --> время в формате Unix time
		$stf = 0;
		$cur_time = time();
		$diff = $cur_time - $date;

		$seconds = array('секунда', 'секунды', 'секунд');
		$minutes = array('минута', 'минуты', 'минут');
		$hours = array('час', 'часа', 'часов');
		$days = array('день', 'дня', 'дней');
		$weeks = array('неделя', 'недели', 'недель');
		$months = array('месяц', 'месяца', 'месяцев');
		$years = array('год', 'года', 'лет');
		$decades = array('десятилетие', 'десятилетия', 'десятилетий');

		$phrase = array($seconds, $minutes, $hours, $days, $weeks, $months, $years, $decades);
		$length = array(1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600);

		for ($i = sizeof($length) - 1; ( $i >= 0 ) && ( ( $no = $diff / $length[$i] ) <= 1 ); $i --) {
			;
		}
		if ($i < 0) {
			$i = 0;
		}
		$_time = $cur_time - ( $diff % $length[$i] );
		$no = floor($no);
		$value = sprintf("%d %s ", $no, $this->getPhrase($no, $phrase[$i]));

		if (( $stf == 1 ) && ( $i >= 1 ) && ( ( $cur_time - $_time ) > 0 )) {
			$value .= time_ago($_time);
		}

		return $value;
	}

	function getPhrase($number, $titles) {
		$cases = array(2, 0, 1, 1, 1, 2);

		return $titles[( $number % 100 > 4 && $number % 100 < 20 ) ? 2 : $cases[min($number % 10, 5)]];
	}

}
