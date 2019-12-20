<?
/**
 * Вывод Блока со списком ссылок + описание
 * 
 */
?>
<?= $block->text ?>
<div class="ul-icon-list">
    <?
//l($obj->values);
    if (is_array($block->values)) {
	    foreach ($block->values as $obj2) {
		    if (strlen($obj2->name) > 2 && strlen($obj2->value) > 8) {
			    ?>
			   
			    <a href="<?= $obj2->value ?>"> 
				<i class="icon icon-<?= common\models\SiteBlockValue::getIconByUrl($obj2->value) ?>"></i> 
				<span> <?= $obj2->name ?> </span>
			    </a>
			    <?
		    }
	    }
    }
    ?>

</div>
