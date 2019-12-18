<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use common\modules\timereservation\widgets\ServiceAddWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = $siteConfig['title']['value'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="task-detail-page">
    <div class="header">
	<div class="org-name"><?= $site->name ?> </div>  
    </div>
    <? include '_table.php' ?>
    <? include '_form.php' ?>

    <? //l($reservations) ?>

</div>
<? //l($siteConfig)  ?>


<br> <br> <br> <br> <br> <br> <br> <br> <br> <br>


<script>
        var reservation = <?= json_encode($reservations); ?>;
        var services = <?= json_encode($services); ?>;
        var site_id = <?= $site->id ?>;
        console.log(reservation);
        var dateCurrent = 1;
</script>

<div id="auth-popup" class="popupx">
    <? // l($siteConfig)?>
</div>