<?php

/**
 * @var $this  yii\web\View
 * @var $model common\models\Page
 */

$this->title = Yii::t('backend', 'Редактирование {modelClass}: ', [
        'modelClass' => 'Page',
    ]) . ' ' . $model->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Страницы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Редактировать');

?>

<?php echo $this->render('_form', [
    'model' => $model,
]) ?>
