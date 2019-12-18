<?php

use yii\helpers\Html;
use common\modules\timereservation\assets\CalendareAsset;


$bundle = CalendareAsset::register($this);
$this->title = Yii::t('backend', 'Календарь');

$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <h1>Календарь</h1>
</div>


<? include '_table.php'?>


<div class="clear"></div>
<? //echo ServiceAddWidget::widget(); ?>
<? l($reservations) ?>
<? l($users) ?>

