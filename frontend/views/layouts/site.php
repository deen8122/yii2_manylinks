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

	<header>
	    <nav class="navbar navbar-expand-lg navigation d-flex align-items-center ">
		<div class="container">
		    <div class="row-flex">
			<div class="col-md-3">
			    <a class="logo" href="<?= Url::to(['/site/index']) ?>">
				<img src="/img/icons/logo.svg">
				<span>ManyLinks.ru</span>
			    </a>
			</div>
			<div class="col-md-9">    
			
			    <div class="navgition-menu d-flex align-items-center justify-content-center">
				<ul class="mb-0">
				    <li class="toggleable"> 
					<a class="menu-item <?= Yii::$app->request->url == '/' ? 'active' : '' ?>" href="<?= Url::to(['/site/index']) ?>">Главная</a>
				    </li>
				    <li class="toggleable"> 
					<a class="menu-item <?= strpos($_SERVER['REQUEST_URI'], '/price') !== false ? 'active' : '' ?>" 
					   href="<?= Url::to(['/price']) ?>">Цены</a>
				    </li>
				    <li class="toggleable">
					<a class="menu-item <?= strpos($_SERVER['REQUEST_URI'], '/help') !== false ? 'active' : '' ?>" 
					   href="<?= Url::to(['/help']) ?>">Помощь</a>				
				    </li>
				    <li class="toggleable"> 
					<a class="menu-item <?= strpos($_SERVER['REQUEST_URI'], '/contacts')  !== false ? 'active' : '' ?>" 
					   href="<?= Url::to(['/contacts']) ?>">Контакты</a>				
				    </li>

				    <? if (Yii::$app->user->isGuest): ?>
					    <li  class="toggleable" style="padding-right: 0"> 
						<a  style="color: #f79823;" class="menu-item" href="<?= Url::to(['/user/sign-in/signup']) ?>">Регистрация</a> /				
					    </li>
					    <li  class="toggleable" style="padding-left: 0"> 
						<a style="color: #f79823;" class="menu-item" href="<?= Url::to(['/user/sign-in/login']) ?>">Вход</a>				
					    </li>
				    <? else: ?>
					       <li class="toggleable dropdown ">
					<a class="menu-item dropdown-toggle" 
					   href="/user/page/index" 
					   style="color: #f79823;">
					       <?= Yii::$app->user->identity->getPublicIdentity() ?>
					    <span class="caret"></span></a>
					<ul class="dropdown-menu dropdown-user-menu">
					    <li><a href="/user/page/index" tabindex="-1">Панель управления</a></li>
					    <li><a href="/user/config/profile" tabindex="-1">Настройки</a></li>
					    <li style="margin-top:15px;border-top:1px solid #ccc">
						<a href="/user/sign-in/logout" data-method="post" tabindex="-1">Выход</a>
					    </li>
					</ul>
				    </li>
				    <? endif ?>

				</ul>
			    </div>
			</div>

		    </div>
		</div>
	    </nav>
	    <div class="container top-line"></div>
	</header>

	<? // include 'test_header_menu.php'; ?>


	<div class="container">
	    <?php echo $content ?>
	    <? //l($_SESSION['USER']); ?>
	</div>


	<!-- footer -->
	<div class="footer">
	    <div class="container">
		<div class="footer-line"></div>
		<div class="row">	
		    <div class="col-md-12">		
			<a href="/privacy_policy">Политика обработки персональный данных</a>
			<center>2019 - <?= date('Y') ?></center>
		    </div>
		</div>
	    </div>
	</div>


	<div class="popup-bgx"></div>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,500,500i,700,700i&display=swap&subset=cyrillic,cyrillic-ext" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= Url::base() ?>/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="<?= Url::base() ?>/css/public-site.css" />
    </body>
</html>
<?php $this->endPage() ?>