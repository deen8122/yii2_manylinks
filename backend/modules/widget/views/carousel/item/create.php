<?php
/**
 * @var $this     yii\web\View
 * @var $model    common\models\WidgetCarouselItem
 * @var $carousel common\models\WidgetCarousel
 */

$this->title = Yii::t('backend', 'Создание {modelClass}', [
    'modelClass' => 'Widget Carousel Item',
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Слайды'), 'url' => ['/widget/carousel/index']];
$this->params['breadcrumbs'][] = ['label' => $carousel->key, 'url' => ['/widget/carousel/update', 'id' => $carousel->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Создать');

?>

<?php echo $this->render('_form', [
    'model' => $model,
]) ?>
