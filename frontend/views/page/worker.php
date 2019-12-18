<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 */
$this->title = '' . $model['user']->userProfile->fullName . ' - профиль фрилансера';
?>
<div class="underline-title mini-tab-title">
    <h1>
	<?= $model['user']->userProfile->fullName ?>
    </h1>    
</div>

<div class="user-info-detail">

    <div class="row">
	<div class="col-md-3">
	    <div class="photo">
		<img  src="<?= $model['user']->userProfile->avatar ?>" alt="" >
	    </div>
	</div>
	<div class="col-md-9">
	    <div class="location-info">
		Россия, Москва, 34 года
	    </div>

	    <div class="about-me-text">

		<?= $model['user']->userProfile->about ?>

	    </div>
	    
	    
	    <div class="user-statistics" style="">
		<div class="title">Статистика заказчика</div>

		<div class="stat-item">
		    <span class="name">В избранном</span>
		    <span class="value">1</span>
		</div>
		<div class="stat-item">
		    <span class="name">Просмотры</span>
		    <span class="value">9 </span>
		</div>
		<div class="stat-item">
		    <span class="name">Размещенные заказы</span>
		    <span class="value">
			<a href="/freelancers/Morfius777/tasks_published">8</a> / <a href="/freelancers/Morfius777/tasks_published?only_active=true">4</a>
		    </span>
		</div>
		<div class="stat-item">
		    <span class="name">Отзывы исполнителей</span>
		    <span class="value"><a href="/freelancers/Morfius777/opinions">+0</a> / <a href="/freelancers/Morfius777/opinions">-0</a></span>
		</div>
		<div class="stat-item">
		    <span class="name">Зарегистрирован</span>
		    <span class="value">8 месяцев назад</span>
		</div>
		<div class="stat-item">
		    <span class="name">Был последний раз</span>
		    <span class="value">сегодня</span>
		</div>
	    </div>
	</div>
	<?// l($model)?>
    </div>
</div>
<? /*
<div class="underline-title mini-tab-title">
    <div class="title">Ключевые навыки</div>
    <div>
	<ul>

	    <li>Профессионально играю в броски казулек на дальние дистанции</li>
	</ul>
    </div>    
</div>
*/?>
<? /*
<div class="underline-title mini-tab-title">
    <div class="title">Портфолио</div>    
</div>
<div class="underline-title mini-tab-title">
    <div class="title">Отзывы</div>    
</div>
 * 
 * 
 * 
 * 
 *  */?>

<?
//l($model)
?>
