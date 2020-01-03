<textarea  id="text_area-<?=$obj->id?>"  placeholder="Текст..." name="text" data="elastic" xonkeyup="textarea_resize(event, 2, 2);"><?= trim($obj->text) ?>
</textarea>


<div id="text_area_div" class="text-field">
    <?=nl2br(str_replace(' ', '&thinsp;', $obj->text)) ?>	
</div>

