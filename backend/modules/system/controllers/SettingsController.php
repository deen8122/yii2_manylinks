<?php

namespace backend\modules\system\controllers;

use common\components\keyStorage\FormModel;
use Yii;
use yii\web\Controller;

class SettingsController extends Controller {

	public function actionIndex() {
		$model = new FormModel([

			'keys' => [
				'time_zone' => [
					'label' => "Часовой пояс",
					'type' => FormModel::TYPE_TEXTINPUT,
				],
				'frontend.maintenance' => [
					'label' => Yii::t('backend', 'Сервисный режим фронтенд части'),
					'type' => FormModel::TYPE_DROPDOWN,
					'items' => [
						'disabled' => Yii::t('backend', 'Неактивно'),
						'enabled' => Yii::t('backend', 'Активно'),
					],
				],
				'frontend.maintenance.x2' => [
					'label' => Yii::t('backend', 'Виджет'),
					'type' => FormModel::TYPE_WIDGET,
					//'options' => [ 'phpDatetimeFormat' => 'yyyy-MM-dd',],
					'widget' => 'trntv\yii\datetime\DateTimeWidget',
					'rules' => [
						[ 'default', 'value' => function () {
								return date(DATE_ISO8601);
							}],
						[ 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true]
					],
				],
				'backend.theme-skin' => [
					'label' => Yii::t('backend', 'Тема панели управления'),
					'type' => FormModel::TYPE_DROPDOWN,
					'items' => [
						'skin-black' => 'skin-black',
						'skin-blue' => 'skin-blue',
						'skin-green' => 'skin-green',
						'skin-purple' => 'skin-purple',
						'skin-red' => 'skin-red',
						'skin-yellow' => 'skin-yellow',
					],
				],
				'backend.layout-fixed' => [
					'label' => Yii::t('backend', 'Фиксированный шаблон панели управления'),
					'type' => FormModel::TYPE_CHECKBOX,
				],
				'backend.layout-boxed' => [
					'label' => Yii::t('backend', 'Коробочный шаблон панели управления'),
					'type' => FormModel::TYPE_CHECKBOX,
				],
				'backend.layout-collapsed-sidebar' => [
					'label' => Yii::t('backend', 'Скрыть боковую панель'),
					'type' => FormModel::TYPE_CHECKBOX,
				],
				'backend.sidebar-mini' => [
					'label' => Yii::t('backend', 'Mini Backend Sidebar on Collapse'),
					'type' => FormModel::TYPE_CHECKBOX,
				],
			],
		]);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->setFlash('alert', [
				'body' => Yii::t('backend', 'Настройки были успешно сохранены'),
				'options' => ['class' => 'alert alert-success'],
			]);
		}
		$modelSeo = new FormModel([

			'keys' => [
				'title' => [
					'label' => "Заголовок",
					'type' => FormModel::TYPE_TEXTINPUT,
				],
				'description' => [
					'label' => "Описание",
					'type' => FormModel::TYPE_TEXTAREA,
				],
				'keywords' => [
					'label' => "Ключевые слова (через запятую)",
					'type' => FormModel::TYPE_TEXTINPUT,
				],
			],
		]);

		if ($modelSeo->load(Yii::$app->request->post()) && $modelSeo->save()) {
			Yii::$app->session->setFlash('alert', [
				'body' => Yii::t('backend', 'SEO Настройки были успешно сохранены'),
				'options' => ['class' => 'alert alert-success'],
			]);

			return $this->refresh();
		}
		return $this->render('index', ['model' => $model, 'modelSeo' => $modelSeo,]);
	}

}
