<div class="block block-pad" id="block-11">
    <textarea  id="text_area-<?= $obj->id ?>"  name="text" data="elastic" placeholder="Описание..."><?= trim($obj->text) ?></textarea>
    <div id="text_area_div" class="text-field"><?= nl2br(str_replace(' ', '&thinsp;', $obj->text)) ?></div>

    <div class="sbv-ul-icon-list sortable">
	<?
//l($obj->values);
	if (is_array($obj->values)) {
		foreach ($obj->values as $obj2) {
			?>
			<div id="sbv-<?= $obj2->id ?>" class="sbv-item sbv-item-<?= $obj2->id ?> <?= ($obj2->status != 1 ? 'deactive' : 'active') ?>" data-id="<?= $obj2->id ?>">

			    <div class="mover ">
				<i class="icon icon-move"></i>
			    </div>

			    <div class="link-area ">
				<input  type="hidden" class="sort" name="SBV[sort][<?= $obj2->id ?>]" value="<?= $obj2->sort ?>">
				<input class="name focusout" type="text" name="SBV[name][<?= $obj2->id ?>]" value="<?= $obj2->name ?>">
				<input class="value focusout" type="text" name="SBV[value][<?= $obj2->id ?>]" value="<?= $obj2->value ?>">
			    </div>

			    <div class="menu toggleable dropdown"> 
				<i class="icon icon-menu dropdown-toggle"></i>

				<ul class="dropdown-menu dropdown-user-menu">
				    <li><a onclick="blockActivate(<?= $obj2->id ?>, 'SiteBlockValue')">акти\деакт</a></li>
				    <li><a onclick="sbvRemove(<?= $obj2->id ?>,<?= $obj->id ?>)">удалить</a></li>
				</ul>

			    </div>

			</div>
			<?
		}
	}
	?>

    </div>
    <a class="add-btn-link" data-block_id="<?= $obj->id ?>">Добавить ссылку</a>
</div>
