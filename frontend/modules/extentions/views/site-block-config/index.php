<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\extentions\models\SiteBlockConfig;
?>

<div class="user-profile-form">
    <h3>Настройки отображения иконок</h3>
</div>
<?php
$selected = $model->data['type'];

$form = ActiveForm::begin(['id' => 'form', 'action' => '/extentions/site-block-config/update']);
?>
<? $data = SiteBlockConfig::getType2Data(); ?>
<? foreach ($data as $i => $val): ?> 
	<label class="label-item" for="cb-<?= $i ?>">
	    <input type="radio" name="viewed_style" value="<?= $i ?>" id="cb-<?= $i ?>" <?=$i==$selected?'checked':''?>>
	    <Img  src="<?= $val['image'] ?>">
	</label>

<? endforeach ?>
<div class="form-group">
    <input type="hidden" name="id" value="<?= $model->id ?>">
    <div class="error" id="js-error"></div>
    <?php echo Html::submitButton(Yii::t('frontend', 'Сохранить'), ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
<script>
        $(document).ready(function () {
            $('#form').on('submit', function () {
                var $yiiform = $(this);
                console.log('submit...');
                var $btn = $(this).find('button');
                var t = $btn.text();
                console.log(t);
                $btn.text(".........");
                // отправляем данные на сервер
                $.ajax({
                    type: $yiiform.attr('method'),
                    url: $yiiform.attr('action'),
                    data: $yiiform.serializeArray()
                }
                ).done(function (data) {
                            data = JSON.parse(data);
                            console.log(data);
                            $btn.text('Сохранить');
                            console.log(t);
                            if (data.error !== undefined) {
                                var t = '<div class="alert alert-danger"><ul>';
                                for (key in data.error) {
                                    var obj = data.error[key];
                                    t += '<li>' + obj + '</li>';
                                }
                                t += '<ul></div>';
                                $('#js-error').html(t);
                                setTimeout(function () {
                                    $('#js-error').html("")
                                }, 5000);
                                return false;
                            }

                            debuggerUpdate();
                        })
                        .fail(function () {
                            // не удалось выполнить запрос к серверу
                        })

                return false; // отменяем отправку данных формы
            })
        })
</script>
<? //l($model->type); ?>
<?// l($model->id); ?>
<style>
    .label-item {    border: 1px solid #ccc;
    margin: 5px;
    width: 100%;
    padding: 10px;}
 </style>