<?php

use common\models\UserProfile;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = Yii::t('backend', 'Редактировать профиль')
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin() ?>

    <?php echo $form->field($model, 'picture')->widget(\trntv\filekit\widget\Upload::class, [
        'url'=>['avatar-upload']
    ]) ?>

    <?php echo $form->field($model, 'firstname')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'middlename')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'lastname')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'locale')->dropDownlist(Yii::$app->params['availableLocales']) ?>

    <?php echo $form->field($model, 'gender')->dropDownlist([
        UserProfile::GENDER_FEMALE => Yii::t('backend', 'Женский'),
        UserProfile::GENDER_MALE => Yii::t('backend', 'Мужской')
    ]) ?>

     <?php echo $form->field($model, 'work_position')->textInput(['maxlength' => 255]) ?>
     <?php echo $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>
     <?php echo $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>
     <?php echo $form->field($model, 'work_position_id')->textInput(['maxlength' => 255]) ?>
    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Редактировать'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
