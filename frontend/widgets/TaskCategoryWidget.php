<?php

namespace frontend\widgets;

use common\models\TaskCategory;
use yii\base\Widget;
use yii\helpers\Html;

class TaskCategoryWidget extends Widget {

	private $data;
	public $arCategories = [];

	public function init() {
		$this->data = TaskCategory::find()->AsArray()->all();
	}

	public function run() {
		//l($this->arCategories);
		$t.= '<!-- r> '.rand(0, 99999).' -->';
		$arrFilter = $_SESSION['USER']['category'];
		if(count($this->arCategories)>0){
			$arrFilter =$this->arCategories;
		}
		if ($arrFilter == null)
			$arrFilter = [];
		$t.= '<ul class="category_ul">';
		foreach ($this->data as $arr) {
			if ($arr['parent_id'] == 0) {

				$t2 = '';

				foreach ($this->data as $arr2) {

					if ($arr2['parent_id'] == $arr['id']) {
						$active = in_array($arr2['id'], $arrFilter) ? true : false;
						$t2.='<li class="' . ($active ? 'active' : '') . '">
							<label>
							   <input type="checkbox" class="category_checkbox" name="category[]" value="' . $arr2['id'] . '" ' . ($active ? 'checked' : '') . '>
                                                           <a >' . $arr2['id'] . ' ' . $arr2['name'] . '</a>
							</label>
						    </li>';
					}
				}
				
				$active = in_array($arr['id'], $arrFilter) ? true : false;
				$t.='<li class="' . ($active ? 'active' : '') . '">
					<label>
					  <input class="category_checkbox" type="checkbox" name="category[]" value="' . $arr['id'] . '" ' . ($active ? 'checked' : '') . '>
					  <a>' . $arr['id'] . ' ' . $arr['name'] . '</a>
					</label>';
				if ($t2 != '') {
					$t.='<ul>' . $t2 . '</ul>';
				}
				$t.='</li>';
			}
		}
		$t.='</ul>
			
			

                ';
		return $t;
	}

}
