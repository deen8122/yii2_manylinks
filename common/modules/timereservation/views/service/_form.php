<?php

use trntv\filekit\widget\Upload;
use trntv\yii\datetime\DateTimeWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use zgb7mtr\colorPicker\ColorPicker;
/**
 * @var $this       yii\web\View
 * @var $model      common\models\Article
 * @var $categories common\models\ArticleCategory[]
 */
?>

<?php
$form = ActiveForm::begin([
		'enableClientValidation' => false,
		'enableAjaxValidation' => true,
	])
?>

<?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'longtime')->textInput(['maxlength' => true]) ?>


<?= $form->field($model, 'color', [
    'template' => "{input}"
    ])->input('color',['class'=>"input_class"]) ?>
<?php
echo $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(
		$categories, 'id', 'title'
	), ['prompt' => ''])
?>



<?=
$form->field($model, 'users')->listBox(ArrayHelper::map(\common\models\User::find()->where(['site_id' => Yii::$app->user->identity->site->id])->all(), 'id', 'userProfile.fullNameExt'), [
	'multiple' => true,
]);
?>

<?php
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
?>




<?php echo $form->field($model, 'status')->checkbox() ?>



<div class="form-group">
    <?php
    echo Html::submitButton(
	    $model->isNewRecord ? Yii::t('backend', 'Создать') : Yii::t('backend', 'Сохранить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'name' => 'save-button'])
    ?>
    <?php
    echo Html::submitButton(
	    "Обновить", ['class' => 'btn btn-success', 'name' => 'update-button', 'style' => "margin-left:30px;"])
    ?>
</div>

<?php ActiveForm::end() ?>

<?
foreach ($model->users as $user) {
	l($user->email);
}
//l($model->users);
?>