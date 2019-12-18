<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = 'Создание заявки';
//$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
