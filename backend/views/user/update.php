<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $roles yii\rbac\Role[] */

$this->title = Yii::t('backend', 'Редактирование пользователя: ', ['modelClass' => 'User']) . '' . $profile->user_id.' / '. $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Пользователи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->email, 'url' => ['view', 'id' => $model->email]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Редактировать')];
?>
<div class="user-update">

    <?php
    
    echo $this->render('_form', [
	    'model' => $model,
	    'profile' => $profile,
	    'roles' => $roles
    ])
    ?>

</div>
