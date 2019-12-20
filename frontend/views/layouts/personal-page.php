<?php
/*
 * Страница вывода персональной страницы.
 */
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this \yii\web\View */
/* @var $content string */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
    <head>
	<meta charset="utf-8"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name = "format-detection" content = "telephone=no" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="HandheldFriendly" content="true">
	<script src="<?= Url::base() ?>/js/jquery.min.js?ver=1"></script>
	<title>ManyLinks.ru - <?php echo Html::encode($this->title) ?></title>
	<link rel="stylesheet" href="<?= Url::base() ?>/css/personal-page.css?ver=1"/> 
	<?php $this->head() ?>
	<link rel="shortcut icon" type="image/x-icon" href="/img/logo-32.png" /> 
	
    </head>
    <body>
	<div class="container">
	    <?php echo $content ?>
	</div>
    </body>
</html>
<?php $this->endPage() ?>