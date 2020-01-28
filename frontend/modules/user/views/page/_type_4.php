<?
/*
 * Блок с картинкой по центру.
 * 
 */
?>
<input type="hidden" id="width" name="width" />
<input type="hidden" id="height" name="height" />
<input type="hidden" id="x1" name="x1" />
<input type="hidden" id="y1" name="y1" />
<input type="hidden" id="x2" name="x2" />
<input type="hidden" id="y2" name="y2" />
<input type="hidden" id="w" name="w" />
<input type="hidden" id="h" name="h" />

<a onclick="$('.block-4-upload-form').show(100);$(this).hide();$('.hide-btn-4').show()" class="add-btn-4">изменить фото</a>
<a onclick="$('.block-4-upload-form').hide(100);$(this).hide();$('.add-btn-4').show()" class="hide-btn-4" style="display: none;">закрыть</a>

<div class="block-4-upload-form" style="display: none;background: #ccc;margin-bottom: 40px;">
    <div class="steps step-1">Выберите файл</div>
    <div class="steps step-2" style="display:none">Выделите прямоугольную область на изображении</div>
    <div class="info" style="display: none;">
	<label>Размер файла: </label> <span id="filesize"></span>
	<label>Размер изображения</label> <span id="filedim"> </span>
	<label>Ширина х высота</label><span id="w-text" ></span> х  <span  id="h-text" /></span>
    </div>


    <center>
	<br/>
	<input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" />
	<img id="preview" style="max-width: 100%;margin-top: 20px;" />
    </center>
     <div class="error" id="upload-error"></div>
    <button style="display:none" type="button" class="btn btn-save-upload-4" onclick="YiiData.image.upload(<?= $obj->id ?>,this)" >Обрезать</button>
</div>

<input type="text" style="display:none" name="DATA[file]" id="data_file" value="<?= $obj->data["file"] ?>" placeholde="Ссылка на фото"> 
<div class="result">
    <div class="block-4-header"> 
	<img id="preview-croped" src="<?= $obj->data["file"] ?>" class="rounded ava"> <br>
	<input class="input-text-edit" type="text" name="DATA[name]" value="<?= $obj->data["name"] ?>" style="min-width:350px;;" placeholde="Ваш ник или имя" >
    </div>
</div>