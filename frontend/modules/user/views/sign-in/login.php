<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\LoginForm */

$this->title = Yii::t('frontend', 'Вход');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login wnd-panel">
    <h1><?php echo Html::encode($this->title) ?></h1>
    <div class="">
	<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
	<?php echo $form->field($model, 'identity') ?>
	<?php echo $form->field($model, 'password')->passwordInput() ?>
	<?php echo $form->field($model, 'rememberMe')->checkbox() ?>
	<div style="color:#999;margin:1em 0">
	    <?php
	    echo Yii::t('frontend', 'Если вы забыли пароль, вы можете сбросить его <a href="{link}">здесь</a>', [
		    'link' => yii\helpers\Url::to(['sign-in/request-password-reset'])
	    ])
	    ?>
	</div>
	<div class="form-group">
	    <?php echo Html::submitButton(Yii::t('frontend', 'Вход'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
	</div>
	<div class="form-group">
	    <br>
	    <?php echo Html::a(Yii::t('frontend', 'Нужен аккаунт? Зарегистрируйтесь'), ['signup' . (isset($_GET['back']) ? '?back=' . $_GET['back'] : '')])
	    ?>
	</div>

	

	  <h4><?php echo Yii::t('frontend', 'Войти с помощью') ?>:</h4>
	  <div class="form-group">
	  <?php
	  echo yii\authclient\widgets\AuthChoice::widget([
	  'baseAuthUrl' => ['/user/sign-in/oauth']
	  ])
	  ?>
	  </div>

	<?php ActiveForm::end(); ?>

    </div>
</div>
