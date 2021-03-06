<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\ResetPasswordForm */

$this->title = Yii::t('frontend', 'Сброс пароля');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password wnd-panel">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="">
      
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                <?php echo $form->field($model, 'password')->passwordInput() ?>
                <div class="form-group">
                    <?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        
    </div>
</div>
