<?php
/* @var $this yii\web\View */
/* @var $model common\base\MultiModel */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('frontend', 'Настройки пользователя')
?>

<div class="user-profile-form">
    <h3>Выберите фон</h3>
</div>
<?
l($site->dataArray);
?>

<div style="margin:10px auto; max-width: 500px;overflow: hidden">
    <div>Градиент</div>
    <div style="display: flex;    white-space: nowrap;">
	<? for ($i = 0; $i < 10; $i++): ?>
		<div onclick="Config.selectBackgroundColor(this)" 
		     data-class="bg-gradient-<?= $i ?>" 
		     class="block-gradient bg-gradient-<?= $i ?> <?=$site->dataArray['bgClass']=='bg-gradient-'.$i?'selected active':''?>">
		</div>
	<? endfor ?>

    </div>
</div>


<div style="margin:10px auto; max-width: 500px;overflow: hidden">
    <div>Изображение</div>
    <div style="display: block;    white-space: nowrap;">
	<? for ($i =1; $i < 10; $i++): ?>
		<div onclick="Config.selectBackgroundColor(this)" 
		      data-img="<?=$i?>" 
		      data-class="bg-image" 
		     class="block-gradient block-image bg-image-<?= $i ?> <?=$site->dataArray['bgClass']=='bg-image-'.$i?'selected active':''?>"
		     style="background-image:url(/img/bgImages/<?=$i?>.jpg)">
		</div>
	<? endfor ?>

    </div>
</div>
<center>
  
    <button type="button" class="btn btn-secondary" onclick="$('.block-gradient.selected').click()" data-default="<?=$site->dataArray['bgClass']?>">Отменить</button>
</center>
<input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />