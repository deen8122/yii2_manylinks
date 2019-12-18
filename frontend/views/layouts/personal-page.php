<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

//\frontend\assets\FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
    <head>
	<meta charset="utf-8"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
	<meta name = "format-detection" content = "telephone=no" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="HandheldFriendly" content="true">
	<script src="<?= Url::base() ?>/js/jquery.min.js?ver=1"></script>
	<title>ManyLinks.ru - <?php echo Html::encode($this->title) ?></title>
	<?php $this->head() ?>
	<?php echo Html::csrfMetaTags() ?>
	<link rel="shortcut icon" type="image/x-icon" href="/img/logo-32.png" /> 
	<script>
                var YiiData = {
                    action: null
                };
	</script>
    </head>
    <body>



	<? // include 'test_header_menu.php'; ?>


	<div class="container">
	    <?php echo $content ?>
	    <? //l($_SESSION['USER']); ?>
	</div>


	

<link rel="stylesheet" href="<?= Url::base() ?>/css/personal-page.css"/> 
	<link rel="stylesheet" type="text/css" href="<?= Url::base() ?>/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="<?= Url::base() ?>/css/public-site.css" />
    </body>
</html>
<?php $this->endPage() ?>