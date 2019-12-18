<?php

namespace common\modules\timereservation\widgets;

use Yii;
use common\modules\timereservation\models\Service;
use common\modules\timereservation\models\ServiceReservation;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\bootstrap\ActiveForm;

class ServiceAddWidget extends Widget {

	private $data;
	public $arCategories = [];
	public $arUsers = [];
	public $arService = [];

	public function init() {
		if (isset($_POST['user'])) {
			//l($_POST);exit;
			$sr = new ServiceReservation();
			$sr->service_id=$_POST['service'];
			$sr->user_id=$_POST['user'];
			$sr->date = $_POST['user'];
			$sr->client_id=5;
			$sr->save();
			header('location:' . $_SERVER['REQUEST_URI']);
			exit;
		}
		$this->arService = Service::find()->with('users')->with('users.userProfile')->AsArray()->all();
		//$this->arService = Service::find()->AsArray()->all();
	}

	public function run() {
		$t = rand(9, 99999);
		$form = ActiveForm :: begin(['id' => 'custom-form']);
		$t.='<form action="" method="post">';
		$t.= Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []);
		$t.= $this->drawServiceHtml();
		$t.= $this->drawUserHtml();
		$t.= $this->drawTimeHtml();
		$t.= $this->createJsData();
		echo Html::submitButton('Save', ['class' => 'btn btn-success']);
		$t.='<button type="submit">Добавить</button>';
		ActiveForm :: end();
		return $t;
	}

	private function createJsData() {
		$cleanData = [];
		foreach ($this->arService as &$serviceArr) {
			$users = [];
			foreach ($serviceArr['users'] as $userArr) {
				$users[] = [
					"id" => $userArr['id'],
					"fullname" => $userArr['userProfile']['firstname'],
					"image" => $userArr['userProfile']['avatar_base_url'] . $userArr['userProfile']['avatar_path'],
				];
			}
			$serviceArr['users'] = $users;
		}
		//l($this->arService);
		Yii::$app->view->registerJs("var serviceAdddata = " . Json::encode($this->arService), \yii\web\View::POS_HEAD);
	}

	private function drawServiceHtml() {
		$t = '<select name="service" onchange="serviceAdd.changeService(this)">';
		foreach ($this->arService as $serviceArr) {
			$t.='<option value="' . $serviceArr['id'] . '">' . $serviceArr['title'] . '</option>';
		}
		$t.= '</select>';
		return $t;
	}

	private function drawUserHtml() {
		$t = '<select name="user" id="user-select"><option >Выберите персонал</option></select>';
		return $t;
	}

	private function drawTimeHtml() {
		$t = '<input type="text" name="time">';
		return $t;
	}

}
