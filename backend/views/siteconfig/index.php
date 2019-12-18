<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">


    <p>
	<?php echo Html::a('Create Site', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    echo GridView::widget([
	    'dataProvider' => $dataProvider,
	    'columns' => [
		    ['class' => 'yii\grid\SerialColumn'],
		    'id',
		    'name',
		    'description:ntext',
		    'active',
		    'deleted',
		    [
			    'attribute' => 'users',
			     'format'=>'html',
			    'value' => function ($data) {
				    //return $data;
				    $t = '';
				    //l($data->users);
				    foreach($data->users as $user){
					    $t.='<p>'.$user->email.'</p>';
				    }
				    return $t;
			    },
		    ],
		    // 'logo',
		    ['class' => 'yii\grid\ActionColumn'],
	    ],
    ]);
    ?>

</div>
