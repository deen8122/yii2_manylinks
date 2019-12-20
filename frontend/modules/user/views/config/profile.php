<?php

use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\base\MultiModel */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('frontend', 'Настройки пользователя')
?>

<div class="user-profile-form">


    <?php $form = ActiveForm::begin(); ?>

    <h2><?php echo Yii::t('frontend', 'Настройки профиля') ?></h2>
    <div class="row">
	<div class="col-md-8">
	    <div class="row">
		<div class="col-md-4">
		    <?php echo $form->field($model->getModel('profile'), 'lastname')->textInput(['maxlength' => 255]) ?>
		</div>
		<div class="col-md-4">
		    <?php echo $form->field($model->getModel('profile'), 'firstname')->textInput(['maxlength' => 255]) ?>
		</div>
		
	    </div>

	    <div class="col-md-12">
		

	    </div>


	</div>
	   
    </div>



    <div class="form-group">
	<?php echo Html::submitButton(Yii::t('frontend', 'Редактировать'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
