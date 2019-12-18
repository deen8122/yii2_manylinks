<?php

namespace common\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class City extends Widget {

	public function run() {
		return '<input type="text" placeholder="поиск"> ';
	}

}
