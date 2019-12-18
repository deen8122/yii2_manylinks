<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->getPublicIdentity();
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Пользователи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
	<?php echo Html::a(Yii::t('backend', 'Редактировать'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
	<?php
	echo Html::a(Yii::t('backend', 'Удалить'), ['delete', 'id' => $model->id], [
		'class' => 'btn btn-danger',
		'data' => [
			'confirm' => Yii::t('backend', 'Вы уверены, что хотите удалить эту запись?'),
			'method' => 'post',
		],
	])
	?>
    </p>

    <?php
    echo DetailView::widget([
	    'model' => $model,
	    'attributes' => [

		    'id',
		    'username',
		    'auth_key',
		    'email:email',
		    'status',
		    'created_at:datetime',
		    'updated_at:datetime',
		    'logged_at:datetime',
		    'userProfile.lastname',
		    'userProfile.firstname',
		    'site.name',
		    'userProfile.avatar:image',
	    ],
    ])
    ?>

</div>
