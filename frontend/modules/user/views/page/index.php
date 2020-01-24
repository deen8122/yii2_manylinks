<?php

use common\models\SiteBlock;

//$this->registerCssFile('/css/admin-page.css');
//$this->registerCssFile('/css/main.css');
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
//https://www.iconfinder.com/iconsets/evil-icons-user-interface
//$this->title = 'Tasks';
//$this->params['breadcrumbs'][] = $this->title;
$cookies = Yii::$app->request->cookies;
?>
<div class="task-index">
    <br>
    <div class="top-inform">
	<div class="row">
	    <div class="col-md-2">
		<div class="menu toggleable dropdown"> 
		    <a class="menu-main">Меню</a>
		    <span class="caret"></span>
		    <ul style="margin-top: -1px;" class="dropdown-menu dropdown-main-menu">
			<li><a class="add-new-block">Добавить блок</a></li>
			<li><a onclick="debuggerOpen()">Показать отладчик</a></li>
			<li><a onclick="app.popupModule('bgimage')">Настройки фона </a></li>
			<li><a onclick="app.popupModule('css')">Правка CSS</a></li>
			<li><a onclick="app.popupModule('js')">Правка JS</a></li>
			<li><a onclick="app.popupModule('imager')">Картинки</a></li>
			<? /*
			  <li><a class="">Страницы</a></li>
			  <li><a class="">Статистика</a></li>
			 * 
			 */
			?>
		    </ul>

		</div>

		<? /*

		 * <center>
		  <a class="add-btn">Добавить блок</a>
		  </center>
		 */
		?>
	    </div>
	    <div class="col-md-10">
		<div class="you-links" style="text-align: right">
		    <span class="name">Ссылка на вашу страницу:</span> 
		    <span class="link">
			<a target="_blank" href="<?= env('FRONTEND_HOST_INFO') ?><?= $site->code ?>">
			    <span class="domain"><?= env('FRONTEND_HOST_INFO') ?></span><span class="code"><?= $site->code ?></span>
			</a>
		    </span>	
		</div>
	    </div>
	</div>
    </div>


    <div class="adm-blocks-list sortable" >
	<?
	$namesArr = SiteBlock::getBlockNames();
	?>
	<? foreach ($siteBlock as $obj):
		?>
		<div class="adm-block adm-block-<?= $obj->type ?> <?= ($obj->status != SiteBlock::STATUS_ACTIVE ? 'deactive' : 'active') ?>" id="block-<?= $obj->id ?>" data-id="<?= $obj->id ?>" data-sort="<?= $obj->sort ?>">
		    <form class="block-form">
			<div class="adm-block-config ">
			    <div class="mover ">
				<i class="icon icon-move"></i>
			    </div>
			    <div class="midle">
				<a onclick="blockToggle(<?= $obj->id ?>)">
				    <i class=" icon toggle-btn icon-minus"></i>
				</a>
				<span class="name"><?= $namesArr[$obj->type] ?></span>


			    </div>

			    <div class="menu toggleable dropdown"> 

				<i class="icon icon-menu dropdown-toggle"></i>

				<ul class="dropdown-menu dropdown-user-menu">
				    <? if ($obj->type == SiteBlock::TYPE_LINKS): ?>
					    <li><a onclick="blockConfig(<?= $obj->id ?>,<?= $obj->type ?>)">настройки</a></li>
				    <? endif ?>
				    <li><a onclick="blockActivate(<?= $obj->id ?>)">актив/деактив</a></li>
				    <li><a onclick="blockRemove(<?= $obj->id ?>)">удалить</a></li>
				</ul>

			    </div>
			</div>		    
			<div class="adm-block-inner opened">
			    <? include '_type_' . $obj->type . '.php'; ?>
			    <input  type="hidden" class="sort" name="type" value="<?= $obj->type ?>">
			    <button type="button" class="save-btn" data-id="<?= $obj->id ?>" data-type="<?= $obj->type ?>">сохранить</button>
			</div>

		    </form>
		</div>

	<? endforeach ?>
    </div>

    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
    <?
//  l($user);
//   l($site);
    //l($siteBlock);
    ?>

</div>
<div class="iframe-phone" style="width: 272px;height: 510px;" >
    <button class="btn" onclick="debuggerClose()">закрыть</button>
    <iframe id="iframe"  src="<?= env('FRONTEND_HOST_INFO') ?><?= $site->code ?>"  style="width: 330px; height: 600px;border-radius: 5px;"></iframe>
</div>

<? include 'popup.php' ?>

<? // l($_COOKIE); ?>
