<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="user-profile-form">
    <h2>JS</h2>
</div>
<p>
Вставьте сюда JS код Яндекс или Google метрики
</p>
<?php
$form = ActiveForm::begin(['id' => 'form', 'action' => '/extentions/js/update']);
?>
<?php echo $form->field($site, 'dataArray[jsCode]')->textArea(['style' => "min-height:400px"])->label("") ?>
<div class="form-group">
    <?php echo Html::submitButton(Yii::t('frontend', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
<input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
<script>
        $(document).ready(function () {
            $('#form').on('submit', function () {
                var $yiiform = $(this);
                console.log('submit');
                var $btn = $(this).find('button');
                var t = $btn.text();
                $btn.text(".........");
                // отправляем данные на сервер
                $.ajax({
                    type: $yiiform.attr('method'),
                    url: $yiiform.attr('action'),
                    data: $yiiform.serializeArray()
                }
                )
                        .done(function (data) {
                            console.log(data);
                            $btn.text(t);
                            debuggerUpdate();
                        })
                        .fail(function () {
                            // не удалось выполнить запрос к серверу
                        })

                return false; // отменяем отправку данных формы
            })
        })
</script>