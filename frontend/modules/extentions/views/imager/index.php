<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="user-profile-form">
    <h2>Файлы проекта</h2>
</div>
<p>


    <? //l($model->files) ?>
    <? //l(FileSizeConvert($model->allFilesSize)) ?>
</p>
<div>
    Использовано <span id="allFilesSize"><?= FileSizeConvert($model->allFilesSize) ?></span> из <span style="color:red; font-weight: bold"><?= FileSizeConvert($model->maxDirSize) ?></span>
</div>
<div id="fileList" class="image-list-wrap">

</div>
<div style="clear: both"></div>
<form id="formId" action="/extentions/imager">
    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />

    <center>
	<br/>
	<input type="file" name="image_file_imager" id="image_file_imager" xonchange="fileSelectHandler()" />
	<img id="preview" style="max-width: 100%;margin-top: 20px;" />
    </center>
    <div class="error" id="upload-error"></div>
    <button  type="button" class="btn btn-save-upload-4" onclick="
                YiiData.image.uploadToStorage('formId', {
                    btn: this,
                    callback: function (data) {
                        updateImagesList(data);
                    }
                })" >загрузить</button>

</form>
<script>
        var files = <?= json_encode($model->files) ?>;
        var allFilesSize = <?= $model->allFilesSize ?>;
        function imagerCreateList() {
            // console.log(allFilesSize);
            // console.log(files);
            var t = "";

            for (key in files) {
                var obj = files[key];
                //  console.log(obj);
                t += '<div class="image-list-item image-list-item-' + key + '" onclick="selectedImage(\'' + key + '\')">';
                if (obj.type === "image") {
                    t += '<img src="' + obj.fileSrc + '">';
                } else {
                    t += '<img src="/img/file.png">';
                }


                t += '<div class="file-info">\n\
		      <ul><li><a onclick="copyfIleSrc(' + key + ')">скопировать ссылку</a></li>\n\
                          <li><br><a onclick="deletefIle(' + key + ')">удалить файл</a></li></ul></div>';
                t += '</div>';

            }
            $('#fileList').html(t);
        }

        imagerCreateList();
        function updateImagesList(data) {
            // console.log('updateImagesList');
            //console.log(data);
            if (data.error !== undefined) {
                var t = '<div class="alert alert-danger"><ul>';
                for (key in data.error) {
                    var obj = data.error[key];
                    t += '<li>' + obj + '</li>';
                }
                t += '<ul></div>';
                $('#upload-error').html(t);
                setTimeout(function () {
                    $('#upload-error').html("")
                }, 5000);
                return false;
            }
            //allFilesSize
            $('#allFilesSize').text(data.allFilesSize);
            files = data.files;
            imagerCreateList();
        }


        function deletefIle(i) {
            doRequest('/extentions/imager/delete', {i: i}, function (json) {
                console.log(json);
                updateImagesList(json);
            });
        }
        function selectedImage(i) {
            //alert(i)
            var file = files[i];
            var t = '';

            // $('.image-list-item-' + i + '').append(t);

        }
        function copyfIleSrc(i) {
            //app.smallLable("Ссылка скопировна!");
            alert("Ссылка на файл '" + files[i].fileSrc + "' скопировна!");
            var copytext = document.createElement('input')
            copytext.value = files[i].fileSrc
            document.body.appendChild(copytext)
            copytext.select()
            document.execCommand('copy')
            document.body.removeChild(copytext)
        }

</script>
<style>
    .image-list-wrap {display: block}
    .image-list-item {width: 100px;
		      height: 100px;
		      xoverflow: hidden;
		      float: left;
		      position: relative;
		      border: 1px solid #ccc;
		      margin: 5px;}
    .image-list-item img{ max-height: 100px; max-width: 100px;}
    .file-info {position: absolute;
		background: #fafafa;
		z-index: 1;
		padding: 5px;
		border: 1px solid #ccc;
		font-size: 10px;top:0;
		height: 100px;
		width: 100px;
		display:none;}
    .image-list-item:hover  .file-info {display: block}
    .image-list-item:hover  {border:2px solid red;}
</style>
<? ?>