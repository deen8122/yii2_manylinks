<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaskMessage */

$this->title = 'Create Task Message';
$this->params['breadcrumbs'][] = ['label' => 'Task Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-message-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
