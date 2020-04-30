<div class="block block-pad" id="block-11">
    <textarea  id="text_area-<?= $obj->id ?>"  name="text" data="elastic" placeholder="HTML Описание..."><?= trim($obj->text) ?></textarea>
    <div id="text_area_div" class="text-field"><?= nl2br(str_replace(' ', '&thinsp;', $obj->text)) ?></div>

    <div class="sbv-ul-icon-list sortable">
	<?
	foreach ($obj->values as $obj2) {
		$obj2->value = json_decode($obj2->value, true);
		?>
		<div id="sbv-<?= $obj2->id ?>" class="sbv-item sbv-item-<?= $obj2->id ?> <?= ($obj2->status == 2 ? 'deactive' : 'active') ?>" data-id="<?= $obj2->id ?>">

		    <div class="mover ">
			<i class="icon icon-move"></i>
		    </div>

		    <div class="link-area ">
			<input  type="hidden" class="sort" name="SBV[template][<?= $obj2->id ?>]" value="1">
			<input  type="hidden" class="sort" name="SBV[sort][<?= $obj2->id ?>]" value="<?= $obj2->sort ?>">

			<input class="name focusout" placeholder="Название"  type="text" name="SBV[name][<?= $obj2->id ?>]" value="<?= $obj2->name ?>">
			<input class="value focusout" placeholder="Ссылка" type="text" name="SBV[value][<?= $obj2->id ?>][link]" value="<?= $obj2->value['link'] ?>">
			<input class="value focusout" placeholder="Описание" type="text" name="SBV[value][<?= $obj2->id ?>][text]" value="<?= $obj2->value['text'] ?>">
			<input class="value focusout"  placeholder="Ссылка на изображение"  type="text" name="SBV[value][<?= $obj2->id ?>][text2]" value="<?= $obj2->value['text2'] ?>">
		    </div>

		    <div class="menu toggleable dropdown"> 
			<i class="icon icon-menu dropdown-toggle"></i>

			<ul class="dropdown-menu dropdown-user-menu">
			    <li><a onclick="blockActivate(<?= $obj2->id ?>, 'SiteBlockValue')">акти\деакт</a></li>
			    <li><a onclick="sbvRemove(<?= $obj2->id ?>,<?= $obj->id ?>)" >удалить</a></li>
			</ul>

		    </div>

		</div>
		<?
	}
	?>


    </div>
    <!-- rempl --> 
    <div id="sbv-<?= $obj->id ?>-template" 
	 class="sbv-item sbv-item-0 template"
	 style="display: none"
	 data-id="<?= $obj2->id ?>">
	<div class="mover ">
	    <i class="icon icon-move"></i>
	</div>
	<div class="link-area ">
	    <input  type="hidden" class="sort" name="">

	    <input class="name focusout" placeholder="Название"  type="text" name="">
	    <input class="link focusout" placeholder="Ссылка" type="text" name="">
	    <input class="text focusout" placeholder="Описание" type="text" name="SBV[value][<?= $obj2->id ?>][text]" value="<?= $obj2->value['text'] ?>">
	    <input class="text2 focusout"  placeholder="Ссылка на изображение"  type="text" name="SBV[value][<?= $obj2->id ?>][text2]" value="<?= $obj2->value['text2'] ?>">
	</div>
	<div class="menu toggleable dropdown"> 
	    <i class="icon icon-menu dropdown-toggle"></i>

	    <ul class="dropdown-menu dropdown-user-menu">
		<li><a onclick="blockActivate(<?= $obj2->id ?>, 'SiteBlockValue')">акти\деакт</a></li>
		<li><a onclick="sbvRemove(<?= $obj2->id ?>,<?= $obj->id ?>)" >удалить</a></li>
	    </ul>
	</div>
    </div>
    <a class="add-btn-link" data-block_id="<?= $obj->id ?>">Добавить запись</a>
</div>
