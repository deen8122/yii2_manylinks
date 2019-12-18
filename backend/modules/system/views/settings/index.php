<?php

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
use common\components\keyStorage\FormWidget;

/**
 * @var $model \common\components\keyStorage\FormModel
 */
$this->title = Yii::t('backend', 'Настройки приложения');
?>

<div id="exTab2" class="container">	
    <ul class="nav nav-tabs">
	<li class="active">
	    <a  href="#1" data-toggle="tab">SEO</a>
	</li>
	<li><a href="#2" data-toggle="tab">Основные</a>
	</li>
	<li><a href="#3" data-toggle="tab">Solution</a>
	</li>
    </ul>

    <div class="tab-content ">
	<div class="tab-pane active" id="1">
	    <h3>SEO</h3>
	    <?php
	    echo FormWidget::widget([
		    'model' => $modelSeo,
		    'formClass' => '\yii\bootstrap\ActiveForm',
		    'submitText' => Yii::t('backend', 'Сохранить'),
		    'submitOptions' => ['class' => 'btn btn-primary'],
	    ])
	    ?>
	</div>
	<div class="tab-pane" id="2">
	    <h3>Notice the gap between the content and tab after applying a background color</h3>
	    <?php
	    echo FormWidget::widget([
		    'model' => $model,
		    'formClass' => '\yii\bootstrap\ActiveForm',
		    'submitText' => Yii::t('backend', 'Сохранить'),
		    'submitOptions' => ['class' => 'btn btn-primary'],
	    ])
	    ?>

	</div>
        <div class="tab-pane" id="3">
	    <h3>add clearfix to tab-content (see the css)</h3>
	</div>
    </div>
</div>


