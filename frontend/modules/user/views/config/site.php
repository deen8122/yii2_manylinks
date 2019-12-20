<?php

use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\base\MultiModel */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('frontend', 'Настройка публичной страницы')
?>

<div class="user-profile-form">


    <?php $form = ActiveForm::begin(); ?>

    <h2><?php echo Yii::t('frontend', 'Настройка публичной страницы') ?></h2>
    
    
    
    
    
    <div class="row">
	<div class="col-md-8">
	    <div class="row">
		<div class="col-md-12">
		    <?php echo $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
		</div>
		<div class="col-md-12">
		    <?php echo $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>
		</div>
		<div class="col-md-12">
		 <?php echo $form->field($model, 'code')->textInput(['maxlength' => 255]) ?>
		</div>
	    </div>

	



	    <?php //echo $form->field($model->getModel('profile'), 'location')->textInput(['maxlength' => 255]) ?>
	    <?php //echo $form->field($model->getModel('profile'), 'locale')->dropDownlist(Yii::$app->params['availableLocales'])   ?>



	</div>
	
    </div>



    <div class="form-group">
	<?php echo Html::submitButton(Yii::t('frontend', 'Редактировать'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <?
    $user = Yii::$app->user->identity;
    foreach ($user->sites as $site){
	$arSites[$site->id] = $site->name;
}
//l($arSites);
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin(['action' => ['/user/config/selectsite']]) ?>

    <?php  echo $form->field($user, 'site_id')->dropDownlist($arSites) ?>



    <?php //echo $form->field($model, 'site_id')->textInput(['maxlength' => 255]) ?>
    <div class="form-group">
	<?php echo Html::submitButton(Yii::t('backend', 'Редактировать'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
</div>
