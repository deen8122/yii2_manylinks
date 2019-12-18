<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('backend', 'Настройки модуля');

$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <?php
    $form = ActiveForm::begin([
		    'enableClientValidation' => false,
		    'enableAjaxValidation' => true,
    ]);
    ?>

    <div class="col">
	<div class="col-md-6">
	    <h2>Рабочее время</h2>
	    <div class="row">
		<div class="col-md-4">
		    <?php echo $form->field($model, 'params[work_time_start]')->textInput(['maxlength' => 512])->label("Начало рабочего времени") ?>
		</div>   
		<div class="col-md-4">
		    <?php echo $form->field($model, 'params[work_time_end]')->textInput(['maxlength' => 512])->label("Конец рабочего времени") ?>
		</div>   
	    </div>



	    <?php echo $form->field($model, 'params[lunch_break]')->checkbox()->label("Обеденный перерыв") ?>
	    <?php echo $form->field($model, 'params[email]')->textInput(['maxlength' => 512])->label("Email для уведомлений") ?>
	</div>
	<div class="col-md-6">

	    <?php
	    echo $form->field($model, 'params[multy]')->dropDownList([ "X" => "XXXX", "Y" => "YYYY"], ['prompt' => ''])
	    ?>

	    <?php
	    echo $form->field($model, 'params[multy2]')->listBox([ "X" => "XXXX", "Y" => "YYYY"], ['multiple' => true,])
	    ?>
	</div>
    </div>

    <?php //l($categories) ?>
    <?php //echo $form->field($model, 'parent_id')->dropDownList($categories, ['prompt' => '']) ?>



    <div class="form-group">
	<?php echo Html::submitButton("Сохранить", ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
<?
//l($model)?>