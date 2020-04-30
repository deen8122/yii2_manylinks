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
	<script src="<?= Url::base() ?>/js/libs/jquery.min.js?ver=1"></script>
	<title><?= $this->context->seo['title'] == '' ? '' . $this->title . '' : $this->context->seo['title'] ?> | ManyLinks.ru</title>
	<meta name="keywords" content="<?= $this->context->seo['keywords'] ?>">
	<meta name="description" content="<?= $this->context->seo['description'] ?>">
	<link rel="stylesheet" href="<?= Url::base() ?>/css/personal-page.css?ver=1"/> 
	<link rel="stylesheet" type="text/css" href="<?= Url::base() ?>/css/block-style.css" />
	<?php $this->head() ?>
	<?php echo Html::csrfMetaTags() ?>
	<link rel="shortcut icon" type="image/x-icon" href="/img/logo-32.png?ver=2" /> 
    </head>

    <body class="<?= $this->context->bodyClass; ?>" style="<?= $this->context->bodyStyle; ?>">
	<div class="container">
	    <?php echo $content ?>
	</div>
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