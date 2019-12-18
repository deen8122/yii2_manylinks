<?php

/**
 * @var $this       yii\web\View
 * @var $model      common\models\Article
 * @var $categories common\models\ArticleCategory[]
 */
$this->title = Yii::t('backend', 'Редактирование {modelClass}: ', [
		'modelClass' => 'Article',
	]) . ' ' . $model->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Статьи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Редактировать');
?>

<?php

echo $this->render('_form', [
	'model' => $model,
	'citeUsers' => $citeUsers,
	'categories' => $categories,
])
?>
