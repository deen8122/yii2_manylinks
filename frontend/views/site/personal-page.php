<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 */
$this->title = $model->name;
?>
<div class="mobile-conent">

    <? foreach ($model->blocks as $block): ?>
	    <? if ($block->status != \common\models\SiteBlock::STATUS_ACTIVE) continue; ?>
	    <div id="block-<?= $block->id ?>" class="block block-<?= $block->type ?> ">
		<? include 'type/block-' . $block->type . '.php' ?>	
	    </div>

    <? endforeach ?>
</div>

<div class="footer">
    <line></line>
    <a class="logo" href="/" target="_blank">
	<img src="/img/icons/logo.svg">
	<span>ManyLinks.ru</span>
    </a>
</div>

<? if (strlen($model->style) > 5) echo '<style>' . $model->style . '</style>'; ?>

<?
if (file_exists(\Yii::getAlias('@webroot') . "/upload/" . $model->id . '/style.css')) {
	$this->registerCssFile("/upload/" . $model->id . '/style.css');
}

//l($model->dataArray);
//l$model->blocks)?>