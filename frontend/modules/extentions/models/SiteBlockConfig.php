<?php

namespace frontend\modules\extentions\models;

use Yii;
use yii\base\Model;
use \common\models\SiteBlock;
use common\models\SiteVersion;

/**
 * Account form
 */
class SiteBlockConfig extends SiteBlock {

	public static function getType2Data(){
		return [
			"type-1"=>["image"=>"/img/type2/0.jpg"],
			"type-2"=>["image"=>"/img/type2/1.jpg"]
		];
	}
	
}
