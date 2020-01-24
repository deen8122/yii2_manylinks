<?php

namespace frontend\modules\extentions;

use Yii;
use yii\web\Response;
use common\models\Site;
use common\models\SiteBlock;
class Module extends \yii\base\Module {

	/**
	 * @var string
	 */
	public $controllerNamespace = 'frontend\modules\extentions\controllers';

	public function setSiteBlockValueData($id,$data) {
		$site = SiteBlock::find()->where(['id'=>$id,  'site_id' => Yii::$app->user->identity->site_id])->one();
		log2file('SiteBlock', $site->data);
		log2file('SiteBlockData', $data);
		if ($site) {
			//$siteData = json_decode($site->data, true);
			$siteData = $site->data;
			log2file('SiteBlockSiteData1', $siteData);
			foreach ($data as $key => $val) {
				$siteData[$key] = $val;
			}
			log2file('SiteBlockSiteData', $siteData);
			$site->data = $siteData;
			$site->save();
			return true;
		} else {
			return false;
		}
	}

	public function setSiteData($data) {
		$site = Site::find()->where(['id' => Yii::$app->user->identity->site_id])->one();
		if ($site) {
			$siteData = json_decode($site->data, true);
			foreach ($data as $key => $val) {
				$siteData[$key] = $val;
			}
			$site->data = json_encode($siteData);
			$site->save();
			return true;
		} else {
			return false;
		}
	}

	public function renderJSON($data) {
		Yii::$app->response->format = Response::FORMAT_JSON;
		$data["js"] = "";
		return json_encode($data, JSON_PRETTY_PRINT);
	}

}
