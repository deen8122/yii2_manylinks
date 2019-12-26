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
	<img src="/img/phone-dog2.jpg">
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
    <div class="container">
	<div class="title-block text-center">
	    <h2 class="mb-10">Как начать работу?</h2>
	</div>	   						
	<div class="row">

	    <div class="col-md-4 col-xs-12 single-offer d-flex flex-row pb-30">
		<div class="iconx">
		    1
		</div>
		<div class="desc">
		    <h4>Пройти регистрацию</h4>
		    <p>
			Перейдите на страницу регистрации и создайте Ваш персональный аккаунт. После регистрации
			необходимо подтвердить ваш email почту. 
			<br/>

		    </p>
		</div>
	    </div>
	    <div class="col-md-4 col-xs-12 single-offer d-flex flex-row pb-30">
		<div class="iconx iconx-2">
		    2
		</div>
		<div class="desc">
		    <a href="#"><h4>Настрой свою страницу</h4></a>
		    <p>
			В личном кабинете нужно настроить свою персональную страницу. Добавить  ссылки на соцсети, описание, ваше фото.

		    </p>
		</div>
	    </div>

	    <div class="col-md-4  col-xs-12  single-offer d-flex flex-row pb-30">
		<div class="iconx iconx-3">
		    3
		</div>
		<div class="desc">
		    <a href="#"><h4>Разместить ссылку в соцсетях</h4></a>
		    <p>
			Добавьте в описание ссылку на вашу страницу. Например, для инстаграм можно указать ваш веб сайт. Вот туда и добавьте
			ссылку.
		    </p>
		</div>
	    </div>



	</div>
	<div class="row" style="text-align: center;margin-top: 50px;">
	    <br><br>
	    <a class="btn btn-red" href="/user/sign-in/signup">Перейти к регистрации</a>
	</div>
    </div>	
</div>

<? /*
  <div class="section">
  <h2>Как это работает</h2>
  <div>
  ПРимеры красиво оформленных страниц!
  </div>
  </div>
 */ ?>
<? /*
  <div class="section">
  <h2>Отзывы</h2>
  <div class="slider">



  </div>
  </div>

 */ ?>


