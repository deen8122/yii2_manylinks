<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\User;
use common\modules\timereservation\models\Service;
use common\modules\timereservation\models\ServiceReservation;
use yii\web\Response;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class OrgController extends Controller {

	/** @inheritdoc */
	public function behaviors() {
		return [
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'add' => ['post'],
				],
			],
		];
	}

	/*
	 * Добавление бронирования услуги
	 */

	public function actionAdd($id) {
		if (Yii::$app->user->isGuest) {
			return json_encode(['status' => 0, 'code' => "isGuest"], JSON_UNESCAPED_UNICODE);
		}
		$sr = new ServiceReservation();
		$sr->service_id = $_POST['service'];
		$sr->user_id = $_POST['user'];
		$sr->date = strtotime($_POST['date']);
		$sr->client_id = $id;
		$sr->save();
		$res = $this->getReservations($id, date('Y-m-d',$sr->date));
		return json_encode(['status' => 1, 'post' => $_POST, 'reservation' => $res['reservations']], JSON_UNESCAPED_UNICODE);
	}

	public function actionView($id) {
		$this->view->params['hide_header'] = true;
		//$user = Yii::$app->user->identity->userProfile->;
		//l($user);

		$site = \common\models\Site::find()->where(['id' => $id])->one();
		$siteConfig = \common\models\KeyStorageItem::find()->where(['site_id' => $id])->indexBy('key')->asArray()->All();

		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => $siteConfig['description']['value']
		]);
		\Yii::$app->view->registerMetaTag([
			'name' => 'keywords',
			'content' => $siteConfig['keywords']['value']
		]);

		//Выбор даты
		$paramDate = Yii::$app->request->get('date');
		$curentTime = time();
		if (isset($paramDate)) {

			$curentTime = strtotime($paramDate);
			$res = $this->getReservations($id, $paramDate);
		} else {
			$res = $this->getReservations($id);
		}
		$siteConfig['time'] = $curentTime + ((int) $siteConfig['time_zone']['value'] * 60 * 60);
		//$siteConfig['time'] = strtotime("2019-11-11 10:45:00");

		if (Yii::$app->request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return json_encode(['status' => 1, 'reservation' => $res['reservations']]);
		}
		$users = [];
		foreach ($res['services'] as $arr){
			foreach ($arr['users'] as $arr2){
			$users[$arr2['id']] = $arr2['id'];
		}
		//l($users);
		}
		return $this->render('view', [
				'site' => $site,
				'reservations' => $res['reservations'],
				'services' => $res['services'],
				'siteConfig' => $siteConfig,
				'users' => User::find()->with('userProfile')->where(['id' => $users])->asArray()->all(),
		]);
	}

	/*
	 * Возвращает массив услуг и зарезервированных дней
	 */

	private function getReservations($id, $date = false) {
		$serviceArr = Service::find()->with('users')->where(['site_id' => $id])->indexBy('id')->AsArray()->all();
		$ids = [];
		foreach ($serviceArr as $arr) {
			$ids[] = $arr['id'];
		}
		/*
		 * $firstDayOfMonth = strtotime(date('Y-m-01'));
		  $lastDayOfMonth = strtotime(date('Y-m-t'));
		 */
		if (!$date) {
			$date = date('Y-m-d');
		}

		$firstDayOfMonth = strtotime(date($date . ' 00:01:00'));
		$lastDayOfMonth = strtotime(date($date . ' 23:59:59'));
		$reservations = ServiceReservation::find()
			->where(['service_id' => $ids])
			->andWhere(['>', 'date', $firstDayOfMonth])
			->andWhere(['<', 'date', $lastDayOfMonth])
			->AsArray()
			->all();
		$arrNorm = [];

		foreach ($reservations as &$arr) {
			$ids[] = $arr['id'];
			//формируем для удобства только часы
			$arr['time_hour_min'] = (int)date('H', $arr['date'])*360000 + date('i', $arr['date'])*6000;
			$endTime = $serviceArr[$arr['service_id']]['longtime'] * 60;
			$arr['time_hour_min_end'] = date('H', $endTime) . date('i', $endTime);

			$arr['time_norm'] = date('H:i', $arr['date']);
			$arr['date_norm'] = date('Y-m-d H:i:s', $arr['date']);
			$arr['longtime'] = $serviceArr[$arr['service_id']]['longtime'];
			$arr['date_end'] = (int) $arr['date'] + (int) $serviceArr[$arr['service_id']]['longtime'] * 60;
			$arr['service_name'] = $serviceArr[$arr['service_id']]['title'];
			$arr['service_color'] = $serviceArr[$arr['service_id']]['color'];
		}
		return ['reservations' => $reservations, 'services' => $serviceArr];
	}

}
