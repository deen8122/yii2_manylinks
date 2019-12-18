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

    <center>
	разработка Deen&Team
    </center>
</div>
<?
//l$model->blocks)?>