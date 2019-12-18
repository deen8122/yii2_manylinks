<?php

namespace frontend\modules\user\controllers;

use cheatsheet\Time;
use common\models\Task;
use yii\data\ActiveDataProvider;
use common\sitemap\UrlsIterator;
use frontend\models\ContactForm;
use Sitemaped\Element\Urlset\Urlset;
use Sitemaped\Sitemap;
use Yii;
use yii\filters\PageCache;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use common\models\City;
use common\models\UserConfig;
use yii\helpers\Url;
/**
 * Site controller
 */
class PayController extends Controller {

	 //fullversion
    public function actionIndex() {

		
		return $this->render('index');
	}

	
}
