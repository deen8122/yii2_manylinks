<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="user-profile-form">
    <h2>СЕО настройки</h2>
</div>
<p>
   Пропишите кастомные заголовки, описание и ключевые слова для вашей страницы.
</p>
<?php
//l($site->dataArray);
$form = ActiveForm::begin(['id' => 'form', 'action' => '/extentions/seo/update']);
?>
<input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
<?php echo $form->field($site, 'dataArray[seo][title]')->label("Заголовок (title)") ?>
<?php echo $form->field($site, 'dataArray[seo][keywords]')->label("Ключевые слова") ?>
<?php echo $form->field($site, 'dataArray[seo][description]')->textArea(['style' => "min-height:200px"])->label("Описание страницы") ?>
<div class="form-group">
    <div class="error" id="js-error"></div>
    <?php echo Html::submitButton(Yii::t('frontend', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

<script>
        $(document).ready(function () {
            $('#form').on('submit', function () {
                var $yiiform = $(this);
                console.log('submit');
                var $btn = $(this).find('button');
                let btntext = $btn.html();
                //console.log(btntext);
                $btn.text(".........");
                // отправляем данные на сервер
                $.ajax({
                    type: $yiiform.attr('method'),
                    url: $yiiform.attr('action'),
                    data: $yiiform.serializeArray()
                }
                )
                        .done(function (data) {

                            data = JSON.parse(data);
                            $btn.text("Сохранено!").addClass('btn-success');
                            setTimeout(function () {
                                $btn.text(btntext).removeClass('btn-success');
                                ;
                            }, 2000)
                            // console.log(btntext);

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