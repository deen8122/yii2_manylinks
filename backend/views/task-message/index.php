<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Task Messages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-message-index">


    <p>
        <?php echo Html::a('Create Task Message', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'task_id',
            'user_id',
            'message:ntext',
            'is_new',
            // 'message_to',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
