<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrgStructure */

$this->title = 'Create Org Structure';
$this->params['breadcrumbs'][] = ['label' => 'Org Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-structure-create">

    <?php
    echo $this->render('_form', [
	    'model' => $model,
	    'categories' => $categories,
    ])
    ?>

</div>
