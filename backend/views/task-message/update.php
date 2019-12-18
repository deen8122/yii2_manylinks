<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaskMessage */

$this->title = 'Update Task Message: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Task Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-message-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
