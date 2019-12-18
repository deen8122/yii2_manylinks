<?php
/*
 * Форма редактирования пользователя!
 */

use common\models\UserForm;
use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\UserProfile;
use yii\helpers\ArrayHelper;
use common\models\Site;
use trntv\yii\datetime\DateTimeWidget;

/* @var $this yii\web\View */
/* @var $model backend\models\UserForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */
//l(Yii::$app->user->identity->site);exit;
?>
<?php $form = ActiveForm::begin() ?>
<div class="user-form row">
    <div class="col-md-6">
	<?php echo $form->field($model, 'username') ?>
	<?php echo $form->field($model, 'email') ?>
	<?php echo $form->field($model, 'password')->passwordInput() ?>
	<?php echo $form->field($model, 'status')->dropDownList(User::statuses()) ?>
<?php echo $form->field($model, 'roles')->checkboxList($roles) ?> 
	<div>
	    Сайт:<? //l(Site::find()); ?>
	    <?
	    echo $form->field($model, 'site_id')->dropDownList([ArrayHelper::map(Site::find()->all(), 'id', 'name')]);
	    ?>
<?php //echo $form->field($model, 'site_id')->dropDownList([])   ?>
	</div>
    </div>


    <div class="col-md-6">
	<div class="col-md-4">
	    <?php
	    echo $form->field($profile, 'picture')->widget(\trntv\filekit\widget\Upload::class, [
		    'url' => ['avatar-upload']
	    ])
	    ?>
	</div>
	<div class="col-md-8">
	    <?php echo $form->field($profile, 'firstname')->textInput(['maxlength' => 255]) ?>

	    <?php echo $form->field($profile, 'middlename')->textInput(['maxlength' => 255]) ?>

	    <?php echo $form->field($profile, 'lastname')->textInput(['maxlength' => 255]) ?>

	    <?php echo $form->field($profile, 'locale')->dropDownlist(Yii::$app->params['availableLocales']) ?>

	    <?php
	    echo $form->field($profile, 'gender')->dropDownlist([
		    UserProfile::GENDER_FEMALE => Yii::t('backend', 'Женский'),
		    UserProfile::GENDER_MALE => Yii::t('backend', 'Мужской')
	    ])
	    ?>

	    <?php
	    /*
	      echo $form->field($model, 'body')->widget(
	      \yii\imperavi\Widget::class, [
	      'plugins' => ['fullscreen', 'fontcolor', 'video'],
	      'options' => [
	      'minHeight' => 400,
	      'maxHeight' => 400,
	      'buttonSource' => true,
	      'convertDivs' => false,
	      'removeEmptyTags' => true,
	      'imageUpload' => Yii::$app->urlManager->createUrl(['/file/storage/upload-imperavi']),
	      ],
	      ]
	      )
	     * 
	     */
	    ?>
	</div>



    </div>
    <div class="col-md-12">






	<?php echo $form->field($profile, 'work_position')->textInput(['maxlength' => 255]) ?>
	<?php echo $form->field($profile, 'phone')->textInput(['maxlength' => 255]) ?>
	<?php echo $form->field($profile, 'address')->textInput(['maxlength' => 255]) ?>
	<?php echo $form->field($profile, 'config')->textInput(['maxlength' => 255]) ?>
	<?php echo $form->field($profile, 'work_position_id')->textInput(['maxlength' => 255]) ?>
	    <? //l($profile);   ?>
	<div class="form-group">
	    <?php echo Html::submitButton(Yii::t('backend', 'Применить'), ['class' => 'btn btn-success', 'name' => 'save-button']) ?>
<?php echo Html::submitButton(Yii::t('backend', 'Сохранить'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
	</div>
    </div> 
<?php ActiveForm::end() ?>

</div>
