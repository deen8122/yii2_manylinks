<?php

use common\grid\EnumColumn;
use common\modules\timereservation\models\Service;
use common\models\ArticleCategory;
use trntv\yii\datetime\DateTimeWidget;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;

/**
 * @var $this         yii\web\View
 * @var $searchModel  backend\modules\content\models\search\ArticleSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */
$this->title = "Услуги";

$this->params['breadcrumbs'][] = $this->title;

//l(Yii::$app->user->identity->site);
?>

<p>
    <?php
    echo Html::a("Добавить услугу", ['create'], ['class' => 'btn btn-success'])
    ?>
</p>

<?php
echo GridView::widget([
	'dataProvider' => $dataProvider,
	//  'filterModel' => $searchModel,
	'options' => [
		'class' => 'grid-view table-responsive',
	],
	'columns' => [
		[
			'attribute' => 'id',
			'options' => ['style' => 'width: 5%'],
		],
		[
			'attribute' => 'sort',
		],
		[
			'attribute' => 'color',
			'value' => function ($model) {
				return '<div style="width:20px; height:20px; border-radius:50%; background:' . $model->color . '"></div>';
			},
			'format' => 'raw',
		],
		[
			'attribute' => 'title',
			'value' => function ($model) {
				return Html::a($model->title, ['update', 'id' => $model->id]);
			},
				'format' => 'raw'
			],
			[
				'attribute' => 'price',
			],
			[
				'attribute' => 'longtime',
				'label' => 'Продолжительность'
			],
			[
				'attribute' => 'users',
				'value' => function($model) {
					$t = '';
					foreach ($model->users as $user) {
						$t.=$user->userProfile->fullNameExt . '<br>';
					}
					return $t;
				},
				'format' => 'raw',
			],
			[
				'class' => EnumColumn::class,
				'attribute' => 'status',
				'options' => ['style' => 'width: 10%'],
				'enum' => Service::statuses(),
				'filter' => Service::statuses(),
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'options' => ['style' => 'width: 5%'],
				'template' => '{update} {delete}',
			],
		],
	]);
	?>
