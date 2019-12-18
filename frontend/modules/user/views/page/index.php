<?php
//$this->registerCssFile('/css/admin-page.css');
//$this->registerCssFile('/css/main.css');
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
//https://www.iconfinder.com/iconsets/evil-icons-user-interface
//$this->title = 'Tasks';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">
    <div class="top-inform">
	<h1>Ваша страница</h1>
	<div class="you-links">
	    <span>Ссылка на вашу страницу:</span> 
	    <span>https://manylinks.ru/deen812.page</span>	
	</div>

	<center>
	    <a class="add-btn">Добавить блок</a>	
	</center>

    </div>


    <div class="adm-blocks-list sortable" >
	<? foreach ($siteBlock as $obj):
		?>
		<div class="adm-block adm-block-<?= $obj->type ?>" id="block-<?= $obj->id ?>" data-id="<?= $obj->id ?>" data-sort="<?= $obj->sort ?>">
		    <form class="block-form">
			<div class="adm-block-config">
			    <div class="mover ">
				<i class="icon icon-move"></i>
			    </div>
			    <div class="midle">

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
			</div>
			<button type="button" class="save-btn" data-id="<?= $obj->id ?>">сохранить</button>
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
<? include 'popup.php'?>
