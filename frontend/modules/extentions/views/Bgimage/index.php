<?php
/* @var $this yii\web\View */
/* @var $model common\base\MultiModel */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('frontend', 'Настройки пользователя')
?>

<div class="user-profile-form">



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
<?
$arColors = [
];
?>
<div style="margin:10px auto; max-width: 500px;overflow: hidden">
    <div style="display: flex;    white-space: nowrap;">
<? for ($i = 0; $i < 10; $i++): ?>
		<div onclick="Config.selectBackgroundColor(this)" data-color="bg-gradient-<?= $i ?>" class="block-gradient bg-gradient-<?= $i ?>"></div>
	<? endfor ?>

    </div>
</div>
<input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />