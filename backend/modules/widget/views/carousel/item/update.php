<?php

/**
 * @var $this  yii\web\View
 * @var $model common\models\WidgetCarouselItem
 */

$this->title = Yii::t('backend', 'Редактирование {modelClass}: ', [
        'modelClass' => 'Widget Carousel Item',
    ]) . ' ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Слайды'), 'url' => ['/widget/carousel/index']];
$this->params['breadcrumbs'][] = ['label' => $model->carousel->key, 'url' => ['/widget/carousel/update', 'id' => $model->carousel->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Редактировать');

?>

<?php echo $this->render('_form', [
    'model' => $model,
]) ?>
