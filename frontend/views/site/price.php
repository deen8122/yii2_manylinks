<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 */
$this->title = "Цены";
?>
<div class="content content-page content-inner price-page">
    <div class="row justify-content-center">
	<div class="text-center">
	    <h1 style="margin-bottom: 20ppc">Цены</h1>
	    <div style="font-size: 16px;margin-bottom: 50px;">
		<p>Ниже представлены версии и цены на приложение.</p>
		<p>Если хотите приеобрести платную версию свяжитесь со мной  по указанными контактам: <a href="/help">перейти к контактам</a></p>   
	    </div>

	</div>	

    </div>					
    <div class="row">

	<!-- 1 -->

	<div class="col-lg-4 price-col">
	    <div class="single-price">
		<div class="top-sec">
		    <h4>Бесплатная версия</h4>
		    <p>Только все самое необходимое.</p>
		</div>
		<div class="bottom-sec free">
		    БЕСПЛАТНО
		</div>
		<div class="end-sec">
		    <ul>
			<li>Шапка страницы с фотографией</li>
			<li>Текстовый блок без возможности HTML форматирования</li>
			<li>Блок для ссылок на соцсети и сайты</li>
			<li>Возможность смены фона</li>
			<li>Только три блока</li>
		    </ul>
		</div>								
	    </div> 
	</div>

	<!-- 2 -->

	<div class="col-lg-4  price-col">
	    <div class="single-price">
		<div class="top-sec">
		    <h4>Расширенная версия</h4>
		    <p> Персонализируй свою страницу.</p>
		</div>
		<div class="bottom-sec">
		    300 рублей в год
		</div>
		<div class="end-sec">
		    <ul>
			<li>Доступны текстовые и HTML блоки</li>
			<li>Возможность менять базове стили CSS</li>
			<li>До 6 различных блоков </li>
			<li>Техподдержка</li>
			<li>Просмотр статистики</li>
		    </ul>
		    <? /*
		      <a href="/user/pay?type=extend" class="primary-btn price-btn mt-20">Выбрать версию</a>
		     * 
		     */
		    ?>
		</div>								
	    </div> 
	</div>

	<!-- 3 -->

	<div class="col-lg-4  price-col">
	    <div class="single-price">
		<div class="top-sec">
		    <h4>Полная версия</h4>
		    <p>Никаких ограничений.</p>
		</div>
		<div class="bottom-sec">
		    1200 рублей в год
		</div>
		<div class="end-sec">
		    <ul>
			<li>Доступны все блоки без ограничений</li>
			<li>Техподдержка</li>
			<li>Все новые улучшения доступны сразу</li>
			<!-- <li>Статистика</li> -->
			<li>Возможность устанавливать коды Яндекс и Гугл метрик</li>
		    </ul>
		    <? /*
		      <a href="/user/pay?type=pro" class="primary-btn price-btn mt-20">Выбрать версию</a>
		     * 
		     */
		    ?>
		</div>								
	    </div> 
	</div>							

    </div>

</div>