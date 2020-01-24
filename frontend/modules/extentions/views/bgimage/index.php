<?php ?>

<div class="user-profile-form">
    <h3>Выберите фон</h3>
</div>
<?
//l($site->dataArray);
?>

<div class="horizontal-block-section">
    <div class="title">своя картинка</div>
    <p>Укажите ссылку на фоновое изображение.</p>
    <div class="row">
	<div class="col-md-9">
	    <input type="text" value="<?= $site->dataArray['img'] ?>" placeholder="http://site.ru/img.jpg" id="imgPath" style="    padding: 5px;width:100%;">
	</div>  
	<div class="col-md-3">
	    <button type="button" 
		    data-class="bg-image-src" 
		    data-img="<?= $i ?>"
		    class="btn btn-danger" 
		    onclick=" 
			     console.log($('#imgPath').val());
			     $(this).attr('data-img', $('#imgPath').val());
			     Config.selectBackgroundColor(this)" 
		    >Установить</button>
	</div>  
    </div>

</div>

<div class="horizontal-block-section">
    <div class="title">выбрать градиент</div>
    <div class="horizontal-block-wrap">
	<? for ($i = 0; $i < 10; $i++): ?>
		<div onclick="Config.selectBackgroundColor(this)" 
		     data-class="bg-gradient-<?= $i ?>" 
		     style="left:<?= $i * 100 ?>px"
		     class="horizontal-block-item block-gradient bg-gradient-<?= $i ?> <?= $site->dataArray['bgClass'] == 'bg-gradient-' . $i ? 'selected active' : '' ?>">
		</div>
	<? endfor ?>

    </div>
</div>


<div class="horizontal-block-section">
    <div class="title">выбрать изображение</div>
    <div class="horizontal-block-wrap">
	<? for ($i = 0; $i < 10; $i++): ?>
		<div onclick="Config.selectBackgroundColor(this)" 
		     data-img="<?= $i ?>" 
		     data-class="bg-image" 
		     class="horizontal-block-item block-gradient block-image bg-image-<?= $i ?> <?= $site->dataArray['bgClass'] == 'bg-image-' . $i ? 'selected active' : '' ?>"
		     style="background-image:url(/img/bgImages/<?= $i ?>.jpg);left:<?= $i * 100 ?>px">
		</div>
	<? endfor ?>

    </div>
</div>
<center>
    <br>

    <button type="button" data-class="" class="btn btn-danger" onclick="Config.selectBackgroundColor(this)" data-default="<?= $site->dataArray['bgClass'] ?>">Сбросить</button>
</center>
<input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />