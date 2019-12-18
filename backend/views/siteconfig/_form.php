<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\keyStorage\FormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Site */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="site-form">

    <ul class="nav nav-tabs">
	<li class="active">
	    <a  href="#main" data-toggle="tab">Основные</a>
	</li>
	<li>
	    <a href="#2" data-toggle="tab">SEO</a>
	</li>
	<li>
	    <a href="#3" data-toggle="tab">Интеграция</a>
	</li>
    </ul>

    <div class="tab-content ">
	<div class="tab-pane active" id="main">
	    <h3>Основные настройки</h3>

	    <?php $form = ActiveForm::begin(); ?>
	    <?php echo $form->errorSummary($model); ?>

	    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	    <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>

	    <?php echo $form->field($model, 'active')->textInput() ?>

	    <?php echo $form->field($model, 'deleted')->textInput() ?>

	    <?php echo $form->field($model, 'logo')->textInput(['maxlength' => true]) ?>

	    <div class="form-group">
		<?php echo Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	    <?php ActiveForm::end(); ?>

	</div>
	<div class="tab-pane" id="2">
	    <h3>SEO</h3>
	    <?php $form2 = ActiveForm::begin(); ?>
	    <?php echo $form2->field($modelSettings, 'params[seo_title]')->textInput(['maxlength' => 512])->label("seo_title") ?>
	     <?php echo $form2->field($modelSettings, 'params[seo_description]')->textInput(['maxlength' => 512])->label("seo_description") ?>
	    <div class="form-group">
		<?php echo Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	    <?php ActiveForm::end(); ?>
	</div>
	<div class="tab-pane" id="3">
	    <h3>add clearfix to tab-content (see the css)</h3>
	</div>

    </div>






</div>
<script>
	
</script>