<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\search\ArticleSearch */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use frontend\widgets\TaskCategoryWidget;

$this->title = Yii::t('frontend', 'Ссылки для вашего профиля в инстаграм')
?>
<div class="main-page">
    <h1>Ссылки для вашего профиля в инстаграм</h1>
</div>

<div class="row section-1 ">
    <div class="col-md-6" style="text-align: center">
	<img src="/img/images/test/mob.jpg">
    </div>
    <div class="col-md-6">

	<div class="text-block">
	    <h2>Как это работает.</h2>
	    <p>
		ManyLinks - это бесплатный инструмент для создания дополнительного описания и ссылки на ваши профили 
		в социальных сетях.  	
	    </p>
	    <p>
		Вы получаете одну ссылку для размещения всего контента, к которому вы привлекаете подписчиков. 
		Поделитесь этой ссылкой где угодно, например, с вашей прифили в Instagram, 
		постами в Facebook или Vkontakte.

	    </p>

	    <? if (Yii::$app->user->isGuest): ?>
		    <a href="/user/sign-in/signup" class="btn-bgreen">Бесплатная регистрация</a>    
	    <? else: ?>
		    <a href="/user/page/" class="btn-bgreen">Перейти в личный кабинет</a>    
	    <? endif ?>

	</div>
    </div>	
</div>
<div class="section">
    <h2>Что я получу после регистрации</h2>
    <div>
	- 
    </div>
</div>
<div class="section">
    <h2>Как это работает</h2>
    <div>
	ПРимеры красиво оформленных страниц!
    </div>
</div>

<? /*
<div class="section">
    <h2>Отзывы</h2>
    <div class="slider">
	
	
	    
    </div>
</div>

*/?>


