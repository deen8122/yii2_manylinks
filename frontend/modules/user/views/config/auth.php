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

   


    <h2><?php echo Yii::t('frontend', 'Настройки аккаунта') ?></h2>

    <?php echo $form->field($model->getModel('account'), 'username') ?>

    <?php echo $form->field($model->getModel('account'), 'email') ?>

    <?php echo $form->field($model->getModel('account'), 'password')->passwordInput() ?>

<?php echo $form->field($model->getModel('account'), 'password_confirm')->passwordInput() ?>

    <div class="form-group">
<?php echo Html::submitButton(Yii::t('frontend', 'Редактировать'), ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
   
</div>
