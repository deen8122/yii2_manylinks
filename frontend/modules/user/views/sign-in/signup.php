<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\SignupForm */

$this->title = Yii::t('frontend', 'Регистрация');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup wnd-panel">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="">
        
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?php// echo $form->field($model, 'username') ?>
                <?php echo $form->field($model, 'email') ?>
                <?php echo $form->field($model, 'password')->passwordInput() ?>
                <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Регистрация'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
	<? /*
                <h2><?php echo Yii::t('frontend', 'Создать аккаунт с помощью')  ?>:</h2>
                <div class="form-group">
                    <?php echo yii\authclient\widgets\AuthChoice::widget([
                        'baseAuthUrl' => ['/user/sign-in/oauth']
                    ]) ?>
                </div>
	 * 
	 */?>
            <?php ActiveForm::end(); ?>
        <div class="text">
	    
	</div>
    </div>
</div>
