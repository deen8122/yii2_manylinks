<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 */
$this->title = "Помощь";
?>
<div class="content content-inner">
    <h1><?php echo $this->title ?></h1>
    <div>
	Пишите мне:
	<ul class="original-ul">
	    <li>Если возникли трудности в создании страниц</li>
	    <li>Если нашли какую то ошибку</li>
	    <li>Если есть предложения по развитию проекта</li>
	</ul>

    </div>
    <h2 class="title">Мои контакты</h2>
    <table class="table" >
	<tr>
	    <td>email: </td>
	    <td>deen812@mail.ru</td>
	</tr>
	<tr>
	    <td>Вконтакте: </td>
	    <td> <a href="https://vk.com/kagarmanov812" rarget="_blank">открыть страницу</a></td>
	</tr>
	<tr>
	    <td>Страница на ManyLinks.ru </td>
	    <td><a href="https://manylinks.ru/deen812" rarget="_blank">https://manylinks.ru/deen812</a></td>
	</tr>
    </table>
</div>
<style>
    .table {
	max-width: 400px;
	border:1px solid #ccc;
    }
    .table td {border:1px solid #ccc;}
    .original-ul {margin:20px 0 20px;}
    .original-ul li {    list-style: disc;
			 margin-left: 30px;}
</style>
