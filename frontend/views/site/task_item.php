<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use yii\helpers\Html;
?>
<br>
<div class="content-list__item">
    <div class="task row">
	<?php echo Html::a($model->name, ['/' . $model->id], ['class' => 'task-title']) ?>

    </div>
</div>
