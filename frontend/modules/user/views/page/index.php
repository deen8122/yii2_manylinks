<?php

use common\models\SiteBlock;

//$this->registerCssFile('/css/admin-page.css');
//$this->registerCssFile('/css/main.css');
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
//https://www.iconfinder.com/iconsets/evil-icons-user-interface
//$this->title = 'Tasks';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">
    <br>
    <div class="top-inform">
	<div class="you-links">
	    <span class="name">Ссылка на вашу страницу:</span> 
	    <span class="link">
		<a target="_blank" href="<?= env('FRONTEND_HOST_INFO') ?><?= $site->code ?>">
		    <span class="domain"><?= env('FRONTEND_HOST_INFO') ?></span><span class="code"><?= $site->code ?></span>
		</a>
	    </span>	
	</div>

	<center>
	    <a class="add-btn">Добавить блок</a>	
	</center>

    </div>


    <div class="adm-blocks-list sortable" >
	<?
	$namesArr = SiteBlock::getBlockNames();
	?>
	<? foreach ($siteBlock as $obj):
		?>
		<div class="adm-block adm-block-<?= $obj->type ?>" id="block-<?= $obj->id ?>" data-id="<?= $obj->id ?>" data-sort="<?= $obj->sort ?>">
		    <form class="block-form">
			<div class="adm-block-config">
			    <div class="mover ">
				<i class="icon icon-move"></i>
			    </div>
			    <div class="midle">
				<a onclick="blockToggle(<?= $obj->id ?>)">
				    <i class="icon toggle-btn icon-plus"></i>
				</a>
				<a><?= $namesArr[$obj->type] ?></a>


			    </div>

			    <div class="menu toggleable dropdown"> 

				<i class="icon icon-menu dropdown-toggle"></i>

				<ul class="dropdown-menu dropdown-user-menu">
				    <li><a onclick="blockRemove(<?= $obj->id ?>)">акти\деакт</a></li>
				    <li><a onclick="blockRemove(<?= $obj->id ?>)">удалить</a></li>
				</ul>

			    </div>
			</div>		    
			<div class="adm-block-inner">
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
<? include 'popup.php' ?>
<? /*
<iframe id="iframe" class="iframe-phone" src="<?= env('FRONTEND_HOST_INFO') ?><?= $site->code ?>"  style="width: 330px; height: 600px;"></iframe>
 * 
 */
?>