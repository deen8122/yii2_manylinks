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
	<title><?php echo Html::encode($this->title) ?></title>
	<?php $this->head() ?>
	<?php echo Html::csrfMetaTags() ?>
	<link rel="shortcut icon" type="image/x-icon" href="/images/sm_5af41d89826b5.png" /> 
	<script>
                var YiiData = {
                    action: null
                };
	</script>
    </head>
    <body>
	<!-- header -->
	<div class="left-menu" style="display: none">
	    <div class="menu-btn" style="margin-bottom: 50px;">
		<a href="/"><img src="/images/sm_5af41d89826b5.png" style="max-width: 100%"></a>
	    </div>
	    <div id="user-profile">
		<? if (Yii::$app->user->isGuest): ?>
			<a href="<?= Url::to(['/user/sign-in/login']) ?>" class="menu-item">
			    <svg style="width:34px; " viewBox="0 0 64 64" 
				 xmlns="http://www.w3.org/2000/svg"><defs></defs><title/>
			    <path class="cls-1" d="M40.82,29.73a13.56,13.56,0,0,0,4.76-10.31V17.58a13.59,13.59,0,0,0-27.17,0v1.84a13.57,13.57,0,0,0,4.77,10.31A19.4,19.4,0,0,0,9,48.38V55a2,2,0,0,0,2,2H53a2,2,0,0,0,2-2V48.38A19.4,19.4,0,0,0,40.82,29.73ZM22.41,17.58a9.59,9.59,0,0,1,19.17,0v1.84a9.59,9.59,0,0,1-19.17,0ZM51,53H13V48.38A15.4,15.4,0,0,1,28.38,33h7.25A15.4,15.4,0,0,1,51,48.38Z"/>
			    </svg>
			    <span >Вход</span>
			</a>

		<? else: ?>

			<a href="/user/default/index" class="menu-item">
			    <svg style="width:34px; " viewBox="0 0 64 64" 
				 xmlns="http://www.w3.org/2000/svg"><defs></defs><title/>
			    <path class="cls-1" d="M40.82,29.73a13.56,13.56,0,0,0,4.76-10.31V17.58a13.59,13.59,0,0,0-27.17,0v1.84a13.57,13.57,0,0,0,4.77,10.31A19.4,19.4,0,0,0,9,48.38V55a2,2,0,0,0,2,2H53a2,2,0,0,0,2-2V48.38A19.4,19.4,0,0,0,40.82,29.73ZM22.41,17.58a9.59,9.59,0,0,1,19.17,0v1.84a9.59,9.59,0,0,1-19.17,0ZM51,53H13V48.38A15.4,15.4,0,0,1,28.38,33h7.25A15.4,15.4,0,0,1,51,48.38Z"/>
			    </svg>
			    <span >Личный<br>кабинет</span>
			</a>
		<? endif ?>   
	    </div>

	    <a href="<?= Url::to(['/']) ?>" class="menu-item menu-item-purple">
		<svg  height="32px" width="32px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title/>
		<g id="briefcase">
		<path d="M20.5,5H17A3.5,3.5,0,0,0,13.5,2h-3A3.5,3.5,0,0,0,7.05,5H3.5A1.5,1.5,0,0,0,2,6.5v9a.5.5,0,0,0,.5.5H3v4.5A1.5,1.5,0,0,0,4.5,22h15A1.5,1.5,0,0,0,21,20.5V16h.5a.5.5,0,0,0,.5-.5v-9A1.5,1.5,0,0,0,20.5,5Zm-10-2h3A2.5,2.5,0,0,1,16,5H8.05A2.5,2.5,0,0,1,10.5,3ZM20,20.5a.5.5,0,0,1-.5.5H4.5a.5.5,0,0,1-.5-.5V16h6v1.5a.5.5,0,0,0,.5.5h3a.5.5,0,0,0,.5-.5V16h6ZM11,17V14h2v3Zm10-2H14V13.5a.5.5,0,0,0-.5-.5h-3a.5.5,0,0,0-.5.5V15H3V6.5A.5.5,0,0,1,3.5,6h17a.5.5,0,0,1,.5.5Z"/></g></svg>
		<span >Компании</span>
	    </a>
	    <a href="<?= Url::to(['/article']) ?>" class="menu-item menu-item-blue">
		<svg enable-background="new 0 0 32 32" 
		     height="32px" 
		     id="Layer_1" version="1.1" 
		     viewBox="0 0 32 32" width="32px" 
		     xml:space="preserve" xmlns="http://www.w3.org/2000/svg" 
		     xmlns:xlink="http://www.w3.org/1999/xlink">
		<g id="news">
		<path clip-rule="evenodd" d="M29,0H7C5.343,0,4,1.342,4,3v2H3C1.343,5,0,6.342,0,8v20   c0,2.209,1.791,4,4,4h24c2.209,0,4-1.791,4-4V3C32,1.342,30.656,0,29,0z M30,28c0,1.102-0.898,2-2,2H4c-1.103,0-2-0.898-2-2V8   c0-0.552,0.448-1,1-1h1v20c0,0.553,0.447,1,1,1s1-0.447,1-1V3c0-0.552,0.448-1,1-1h22c0.551,0,1,0.448,1,1V28z" fill="#333333" fill-rule="evenodd"/><path clip-rule="evenodd" d="M19.498,13.005h8c0.277,0,0.5-0.224,0.5-0.5s-0.223-0.5-0.5-0.5   h-8c-0.275,0-0.5,0.224-0.5,0.5S19.223,13.005,19.498,13.005z" fill="#333333" fill-rule="evenodd"/><path clip-rule="evenodd" d="M19.498,10.005h8c0.277,0,0.5-0.224,0.5-0.5s-0.223-0.5-0.5-0.5   h-8c-0.275,0-0.5,0.224-0.5,0.5S19.223,10.005,19.498,10.005z" fill="#333333" fill-rule="evenodd"/><path clip-rule="evenodd" d="M19.498,7.005h8c0.277,0,0.5-0.224,0.5-0.5s-0.223-0.5-0.5-0.5h-8   c-0.275,0-0.5,0.224-0.5,0.5S19.223,7.005,19.498,7.005z" fill="#333333" fill-rule="evenodd"/><path clip-rule="evenodd" d="M16.5,27.004h-8c-0.276,0-0.5,0.225-0.5,0.5   c0,0.277,0.224,0.5,0.5,0.5h8c0.275,0,0.5-0.223,0.5-0.5C17,27.229,16.776,27.004,16.5,27.004z" fill="#333333" fill-rule="evenodd"/><path clip-rule="evenodd" d="M16.5,24.004h-8c-0.276,0-0.5,0.225-0.5,0.5   c0,0.277,0.224,0.5,0.5,0.5h8c0.275,0,0.5-0.223,0.5-0.5C17,24.229,16.776,24.004,16.5,24.004z" fill="#333333" fill-rule="evenodd"/><path clip-rule="evenodd" d="M16.5,21.004h-8c-0.276,0-0.5,0.225-0.5,0.5   c0,0.277,0.224,0.5,0.5,0.5h8c0.275,0,0.5-0.223,0.5-0.5C17,21.229,16.776,21.004,16.5,21.004z" fill="#333333" fill-rule="evenodd"/><path clip-rule="evenodd" d="M27.5,27.004h-8c-0.277,0-0.5,0.225-0.5,0.5   c0,0.277,0.223,0.5,0.5,0.5h8c0.275,0,0.5-0.223,0.5-0.5C28,27.229,27.775,27.004,27.5,27.004z" fill="#333333" fill-rule="evenodd"/><path clip-rule="evenodd" d="M27.5,24.004h-8c-0.277,0-0.5,0.225-0.5,0.5   c0,0.277,0.223,0.5,0.5,0.5h8c0.275,0,0.5-0.223,0.5-0.5C28,24.229,27.775,24.004,27.5,24.004z" fill="#333333" fill-rule="evenodd"/><path clip-rule="evenodd" d="M27.5,21.004h-8c-0.277,0-0.5,0.225-0.5,0.5   c0,0.277,0.223,0.5,0.5,0.5h8c0.275,0,0.5-0.223,0.5-0.5C28,21.229,27.775,21.004,27.5,21.004z" fill="#333333" fill-rule="evenodd"/><path clip-rule="evenodd" d="M27.5,15.004h-19c-0.276,0-0.5,0.224-0.5,0.5s0.224,0.5,0.5,0.5   h19c0.275,0,0.5-0.224,0.5-0.5S27.775,15.004,27.5,15.004z" fill="#333333" fill-rule="evenodd"/><path clip-rule="evenodd" d="M27.5,18.004h-19c-0.276,0-0.5,0.225-0.5,0.5   c0,0.277,0.224,0.5,0.5,0.5h19c0.275,0,0.5-0.223,0.5-0.5C28,18.229,27.775,18.004,27.5,18.004z" fill="#333333" fill-rule="evenodd"/><path clip-rule="evenodd" d="M9,13h7c0.553,0,1-0.447,1-1V5.004c0-0.553-0.447-1-1-1H9   c-0.553,0-1,0.447-1,1V12C8,12.552,8.447,13,9,13z M10,6h5v5h-5V6z" fill="#333333" fill-rule="evenodd"/></g></svg>
		<span >Новости</span>
	    </a>
	    <a href="<?= Url::to(['/page']) ?>" class="menu-item menu-item-green">
		<svg enable-background="new 0 0 32 32" height="32px" 
		     id="svg2" version="1.1" viewBox="0 0 32 32" width="32px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" 
		     xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" 
		     xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg"><g id="background"><rect fill="none" height="32" width="32"/></g><g id="document_x5F_text_x5F_information"><path d="M24,14.059V5.584L18.414,0H0v32h24v-0.059c4.499-0.5,7.998-4.309,8-8.941C31.998,18.366,28.499,14.556,24,14.059z    M17.998,2.413L21.586,6h-3.588V2.413z M2,30V1.998h14v6.001h6v6.06c-1.752,0.194-3.352,0.89-4.652,1.941H4v2h11.517   c-0.412,0.616-0.743,1.289-0.994,2H4v2h10.059C14.022,22.329,14,22.661,14,23c0,2.829,1.308,5.351,3.349,7H2z M23,29.883   c-3.801-0.009-6.876-3.084-6.884-6.883c0.008-3.801,3.083-6.876,6.884-6.885c3.799,0.009,6.874,3.084,6.883,6.885   C29.874,26.799,26.799,29.874,23,29.883z M20,12H4v2h16V12z"/>
		<path d="M22,28h2v-6h-2V28z M22,18v2h2v-2H22z"/></g></svg>
		<span >Информация</span>
	    </a>



	</div>

	<? if (!$this->params['hide_header'] && is_array($this->params['menu'])): ?>
		<header class="content header">
		    <div class="menu">
			<ul class="nav">
			    <? foreach ($this->params['menu'] as $arr): ?>
				    <li><a href="<?=$arr['url']?>" class="active"><?=$arr['title']?></a></li>
			    <? endforeach ?>
			</ul>
		    </div>
		    <div class="clear"></div>


		</header>
	<? endif ?>

	<!-- /header -->
	<main class="main">
	    <div class="content">


		<?php $this->beginBody() ?>
		<?php echo $content ?>
		<?php $this->endBody() ?>


	    </div>
	</main>

	<!-- footer -->
	<footer class="footer">
	    <div class="footer__top">

	    </div>
	</footer>
	<!-- /footer -->


	<div class="popup-bgx"></div>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,500,500i,700,700i&display=swap&subset=cyrillic,cyrillic-ext" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= Url::base() ?>/css/org_main.css" />

	<script src="<?= Url::base() ?>/js/libs/textarea-elastic.js"></script>
	<script src="<?= Url::base() ?>/js/libs/jquery-ui.js"></script>
	<script src="<?= Url::base() ?>/js/main.js"></script>
    </body>
</html>
<?php $this->endPage() ?>