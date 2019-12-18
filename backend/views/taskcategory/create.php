<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaskCategory */

$this->title = 'Create Task Category';
$this->params['breadcrumbs'][] = ['label' => 'Task Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-category-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
