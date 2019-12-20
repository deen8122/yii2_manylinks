<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 */
$this->title = $model->name;
?>
<div class="mobile-conent">

    <? foreach ($model->blocks as $block): ?>
	    <? // l($block);?>
	    <div>
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

<?
$this->registerCssFile("/upload/deen812/" . $model->code . '.css');
//l$model->blocks)?>