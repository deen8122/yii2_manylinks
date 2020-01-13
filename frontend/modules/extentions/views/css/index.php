<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="user-profile-form">
    <h2>CSS</h2>
</div>

<?php
$form = ActiveForm::begin(['id' => 'form',]);
?>
<?php echo $form->field($model, 'style')->textArea(['style'=>"min-height:400px"]) ?>
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
                // отправляем данные на сервер
                $.ajax({
                    type: $yiiform.attr('method'),
                    url: $yiiform.attr('action'),
                    data: $yiiform.serializeArray()
                }
                )
                        .done(function (data) {
				console.log(data);
                             debuggerUpdate();
                        })
                        .fail(function () {
                            // не удалось выполнить запрос к серверу
                        })

                return false; // отменяем отправку данных формы
            })
        })
</script>