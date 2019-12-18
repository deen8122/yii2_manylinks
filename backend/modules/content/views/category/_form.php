<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this       yii\web\View
 * @var $model      common\models\ArticleCategory
 * @var $categories common\models\ArticleCategory[]
 */

?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
]); ?>

<?php echo $form->field($model, 'title')->textInput(['maxlength' => 512]) ?>

<?php echo $form->field($model, 'slug')
    ->hint(Yii::t('backend', 'Если вы оставите это поле пустым, ЧПУ будет сгенерирован автоматически'))
    ->textInput(['maxlength' => 1024]) ?>

<?php //l($categories)?>
<?php echo $form->field($model, 'parent_id')->dropDownList($categories, ['prompt' => '']) ?>

<?php echo $form->field($model, 'status')->checkbox() ?>

<div class="form-group">
    <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Создать') : Yii::t('backend', 'Редактировать'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end() ?>
