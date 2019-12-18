<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Site */

$this->title = 'Update Site: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="site-update">

    <?php
    echo $this->render('_form', [
	    'model' => $model,
	   'modelSettings' => $modelSettings,
    ])
    ?>

</div>
