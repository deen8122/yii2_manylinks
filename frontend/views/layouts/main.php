<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

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
	<script src="<?= Url::base() ?>/js/libs/jquery.min2.js?ver=1"></script>
	<title>ManyLinks.ru - admin</title>
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

	<header class="admin-header">
	    <nav class="navbar navbar-expand-lg navigation d-flex align-items-center ">
		<div class="container">
		    <div class="row-flex">
			<div class="col-md-4 col-xs-12">
			    <a class="logo" href="<?= Url::to(['/site/index']) ?>">
				<? /*
				  <img src="/img/icons/logo.svg">
				  <span>ManyLinks.ru</span>
				 * <img style="width: 32px" src="/img/logo100.png">
				 */
				?>

				<img src="/img/icons/logo.svg">
				<span class="logo-text"><span>Many</span><span>Links</span>.ru</span>
			    </a>
			</div>
			<div class="col-md-8 col-xs-12"> 
			    <div class="navgition-menu d-flex align-items-center justify-content-center">
				<ul class="mb-0">
				    <li class="toggleable"> 
					<a class="menu-item <?= strpos($_SERVER['REQUEST_URI'], '/user/page') !== false ? 'active' : '' ?>" 
					   href="<?= Url::to(['/user/page/']) ?>">Страница</a>
				    </li>
				    <li class="toggleable">
					<a class="menu-item <?= strpos($_SERVER['REQUEST_URI'], '/user/pay') !== false ? 'active' : '' ?>" 
					   href="<?= Url::to(['/user/pay/']) ?>">Версия приложения</a>				
				    </li>
				    <li class="toggleable"> 
					<a class="menu-item <?= strpos($_SERVER['REQUEST_URI'], '/user/config/site') !== false ? 'active' : '' ?>" 
					   href="<?= Url::to(['/user/config/site']) ?>">Настройки</a>				
				    </li>

				    <li class="toggleable dropdown ">
					<a class="menu-item dropdown-toggle" 
					   href="#" 
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

				</ul>
			    </div>
			</div>

		    </div>
		</div>
	    </nav>
	    <div class="container top-line"></div>
	</header>

	<? // include 'test_header_menu.php'; ?>
	<?php if (Yii::$app->session->hasFlash('alert')): ?>
		<div class="container">
		    <?php
		    echo \yii\bootstrap\Alert::widget([
			    'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
			    'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
		    ])
		    ?>
		</div>
	<?php endif; ?>

	<? //l(Yii::$app->user->can('user')); ?>
	<div class="container">
	    <?php echo $content ?>
	    <? //l($_SESSION['USER']);   ?>
	</div>


	<!-- footer -->
	<div class="footer">
	    <div class="container">
		<div class="footer-line"></div>
		<div class="row">	
		    <div class="col-md-4">		
			<a href="/privacy_policy">Политика обработки персональный данных</a>

		    </div>
		    <div class="col-md-4">
			<center>2019 - <?= date('Y') ?></center>
		    </div>
		    <div col-md-4>

			<!-- Yandex.Metrika informer -->
			<a href="https://metrika.yandex.ru/stat/?id=56896387&amp;from=informer"
			   target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/56896387/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
							    style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="56896387" data-lang="ru" /></a>
			<!-- /Yandex.Metrika informer -->

		    </div>
		</div>
	    </div>
	</div>


	<div class="popup-bg"></div>
	<div class="popup">

	</div>

	<link rel="stylesheet" type="text/css" href="<?= Url::base() ?>/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="<?= Url::base() ?>/css/public-site.css" />	
	<link rel="stylesheet" type="text/css" href="<?= Url::base() ?>/css/admin-page.css?ver=3" />
	<link rel="stylesheet" type="text/css" href="<?= Url::base() ?>/css/block-style.css" />
	<link href="<?= Url::base() ?>/css/libs/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />

	<script src="<?= Url::base() ?>/js/libs/textarea-elastic.js"></script>
	<script src="<?= Url::base() ?>/js/libs/jquery-ui.js"></script>
	<script src="<?= Url::base() ?>/js/libs/jquery.Jcrop.min.js" async onload="console.log('->Jcrop init')"></script>
	<script src="<?= Url::base() ?>/js/admin/image.js"></script>
	<script src="<?= Url::base() ?>/js/admin-script.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,500,500i,700,700i&display=swap&subset=cyrillic,cyrillic-ext" rel="stylesheet">


	<!-- Yandex.Metrika counter -->
	<script type="text/javascript" >
                (function (m, e, t, r, i, k, a) {
                    m[i] = m[i] || function () {
                        (m[i].a = m[i].a || []).push(arguments)
                    };
                    m[i].l = 1 * new Date();
                    k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
                })
                        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

                ym(56896387, "init", {
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true
                });
	</script>
	<noscript><div><img src="https://mc.yandex.ru/watch/56896387" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->

    </body>
</html>
<?php $this->endPage() ?>