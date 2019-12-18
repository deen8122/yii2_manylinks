<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrgStructure */

$this->title = 'Update Org Structure: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Org Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="org-structure-update">

    <?php
    echo $this->render('_form', [
	    'model' => $model,
	    'categories' => $categories,
    ])
    ?>

</div>
