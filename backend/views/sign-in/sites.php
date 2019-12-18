<?php

use common\models\UserProfile;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = Yii::t('backend', 'Редактировать профиль');

foreach ($model->sites as $site){
	$arSites[$site->id] = $site->name;
}
//l($arSites);
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin() ?>

    <?php  echo $form->field($model, 'site_id')->dropDownlist($arSites) ?>



    <?php //echo $form->field($model, 'site_id')->textInput(['maxlength' => 255]) ?>
    <div class="form-group">
	<?php echo Html::submitButton(Yii::t('backend', 'Редактировать'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
