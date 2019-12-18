<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaskCategory */

$this->title = 'Update Task Category: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Task Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-category-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
