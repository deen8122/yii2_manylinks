<?php
/* @var $this yii\web\View */
/* @var $model backend\models\UserForm */
/* @var $roles yii\rbac\Role[] */
$this->title = Yii::t('backend', 'Создание {modelClass}', [
		'modelClass' => 'User',
	]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Пользователи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-create">

    <?php
    echo $this->render('_form', [
	    'model' => $model,
	    'profile' => $profile,
	    'roles' => $roles
    ])
    ?>

</div>
