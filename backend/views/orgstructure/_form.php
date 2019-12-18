<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrgStructure */
/* @var $form yii\bootstrap\ActiveForm 
  @var $categories common\models\ArticleCategory[]

 *  */
?>

<div class="org-structure-form">


    <?php
    $form = ActiveForm::begin([
		    'enableClientValidation' => false,
		    'enableAjaxValidation' => true,
    ]);
    ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => 512]) ?>

    <?php
    echo $form->field($model, 'slug')
	    ->hint(Yii::t('backend', 'Если вы оставите это поле пустым, ЧПУ будет сгенерирован автоматически'))
	    ->textInput(['maxlength' => 1024])
    ?>
    <? //l($categories);exit;?>
    <?php echo $form->field($model, 'parent_id')->dropDownList($categories, ['prompt' => '']) ?>

    <?php echo $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
	<?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Создать') : Yii::t('backend', 'Редактировать'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>


</div>
