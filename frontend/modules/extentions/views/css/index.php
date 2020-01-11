<?php
/* @var $this yii\web\View */
/* @var $model common\base\MultiModel */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('frontend', 'Настройки пользователя')
?>

<div class="user-profile-form">
    <h2>Css</h2>
</div>


<center> 
    <button type="button" class="btn btn-secondary">Отменить</button>
</center>
<input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />