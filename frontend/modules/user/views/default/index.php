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
		<div class="col-md-4">
		    <?php
		    echo $form->field($model->getModel('profile'), 'gender')->dropDownlist([
			    \common\models\UserProfile::GENDER_FEMALE => Yii::t('frontend', 'Женский'),
			    \common\models\UserProfile::GENDER_MALE => Yii::t('frontend', 'Мужской')
			    ], ['prompt' => ''])
		    ?>
		</div>
	    </div>

	    <div class="col-md-12">
		<?php
		echo $form->field($model->getModel('profile'), 'about')->widget(
			\yii\imperavi\Widget::class, [
			'plugins' => ['fullscreen', 'fontcolor'],
			'options' => [
				'minHeight' => 400,
				'maxHeight' => 400,
				'buttonSource' => true,
				'convertDivs' => false,
				'removeEmptyTags' => true,
				//'imageUpload' => Yii::$app->urlManager->createUrl(['/file/storage/upload-imperavi']),
			],
			]
		)
		?>
<?php echo $form->field($model->getModel('profile'), 'about')->textArea() ?>
	    </div>




	    <?php echo $form->field($model->getModel('profile'), 'location')->textInput(['maxlength' => 255]) ?>
<?php //echo $form->field($model->getModel('profile'), 'locale')->dropDownlist(Yii::$app->params['availableLocales'])   ?>



	</div>
	<div class="col-md-4">
	    <?php
	    echo $form->field($model->getModel('profile'), 'picture')->widget(
		    Upload::class, [
		    'url' => ['avatar-upload']
		    ]
	    )
	    ?>
	</div>   
    </div>



    <h2><?php echo Yii::t('frontend', 'Настройки аккаунта') ?></h2>

    <?php echo $form->field($model->getModel('account'), 'username') ?>

    <?php echo $form->field($model->getModel('account'), 'email') ?>

    <?php echo $form->field($model->getModel('account'), 'password')->passwordInput() ?>

<?php echo $form->field($model->getModel('account'), 'password_confirm')->passwordInput() ?>

    <div class="form-group">
<?php echo Html::submitButton(Yii::t('frontend', 'Редактировать'), ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
    <button type="button" class="btn btn-primary">Primary</button>
    <button type="button" class="btn btn-secondary">Secondary</button>
    <button type="button" class="btn btn-success">Success</button>
    <button type="button" class="btn btn-danger">Danger</button>
    <button type="button" class="btn btn-warning">Warning</button>
    <button type="button" class="btn btn-info">Info</button>
    <button type="button" class="btn btn-light">Light</button>
    <button type="button" class="btn btn-dark">Dark</button>

    <button type="button" class="btn btn-link">Link</button>
</div>
