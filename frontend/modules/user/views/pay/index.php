<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 */
$this->title = "Версия приложения";
?>
<div class="content">
    <h1><?php echo $this->title ?></h1>

    <div style="margin:20px;">
	Версия: <span style="font-weight: bold; color:green;"><?=Yii::$app->user->identity->site->versionName?> </span>
    </div>
    <p> 
    
	Для  смены версии приложения напишите на нашу почту deen812@mail.ru
    
    </p>
    <p>
	Версии приложения можете посмотреть по этой ссылке: <a href="/price">цены и версии</a>
    </p>
</div>