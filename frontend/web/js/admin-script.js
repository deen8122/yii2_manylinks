var yii = new Yii();
function Yii() {

}
$(document).ready(function () {
    init();

});



function UpdateContent() {
    console.log('UpdateContent');
    $.ajax({
        type: "POST",
        url: '/site/index',
        data: {ajax: 1}, // serializes the form's elements.
        success: function (data) {
//console.log(data);
            $('#content-items').html(data)
        }
    });
}
/*
 * Создает новый блок с типом  = type
 * @param {type} type
 * @return {undefined}
 */
function addNewBLock(type) {
    $('.popup-bg').fadeOut(100);
    $('#add-block-form').fadeOut(100);
    doRequest('/user/page/createblock', {type: type}, function (json) {
        console.log('--->')
        console.log(json);
        if (json.code === "error") {
               alert(json.message)
        } else {

            window.location = "";
        }
    });
}

function init() {
    $('.add-btn').on('click', function () {
        $('#add-block-form').fadeIn(100);
        var offset = $(this).offset();
        console.log(offset);
        $('#add-block-form').css('top', offset.top + 'px');
        $('.popup-bg').fadeIn(100);
    });
    $('.add-btn-link').on('click', function () {
        var sortN = 0;
        var sort = $(this).closest('.block').find('.sbv-ul-icon-list').find('.sort').last();

        if (sort.val() != undefined) {
            sortN = sort.val();
            sortN++;
        }
        console.log(sortN);

        var form =
                '<div  class="sbv-item" data-id="0">\n\
                     <input  type="hidden" class="sort" name="SBV[sort][]" value="' + sortN + '">\n\
                     <input type="text" class="focusout" name="SBV[name][]">\n\
                    <input type="text" class="focusout"  name="SBV[value][]">\n\
                 </div>';
        $(this).closest('.block').find('.sbv-ul-icon-list').append(form);
    });

    /*
     * Обновление данных
     */
    $('.save-btn').on('click', function () {
        var id = $(this).data('id');
        var type = $(this).data('type');
        if (type === 3) {
            UpdateBlockContent(id);
        }
        var $form = $('#block-' + id).find('form');
        var data = $form.serialize();
        var _csrf = $('[name="_csrf"]').val();
        data += '&id=' + id + '&_csrf=' + _csrf;
        var $btn = $(this)
        $btn.html('- - - ');
        $.ajax({
            type: "POST",
            format: "JSON",
            url: '/user/page/update',
            data: data, // serializes the form's elements.
            success: function (data) {
                console.log(data);
                $btn.html('Сохранить');
                $btn.removeClass('active');
                document.getElementById('iframe').contentWindow.location.reload(true);
            }
        });
    });
//

    jQuery('textarea').autoResize();
    $('textarea').keyup(); //.css('height', h + 'px');
    $('textarea,input').keyup(function () {
        $(this).closest('form').find('.save-btn').addClass('active');
    });
    $('.adm-block-inner').hide();
  //  $('.adm-block-inner').first().show();


}

function UpdateBlockContent(id) {
    var $block = $('#block-' + id);
    var text = $block.find('textarea').val();
    $block.find('.block-draw').html(text);
}
function sbvRemove(id, sb_id) {
    var _csrf = $('[name="_csrf"]').val();
    var data = 'sb_id=' + sb_id + '&id=' + id + '&_csrf=' + _csrf;
    $.ajax({
        type: "POST",
        url: '/user/page/sbvdelete',
        data: data, // serializes the form's elements.
        success: function (data) {
            console.log(data)
            console.log('removed - ' + id);
        }
    });
    $('.sbv-item-' + id).fadeOut(500);
}

function sbvRemove(id, sb_id) {
    var _csrf = $('[name="_csrf"]').val();
    var data = 'sb_id=' + sb_id + '&id=' + id + '&_csrf=' + _csrf;
    $.ajax({
        type: "POST",
        url: '/user/page/sbvdelete',
        data: data, // serializes the form's elements.
        success: function (data) {
            console.log(data)
            console.log('removed - ' + id);
        }
    });
    $('.sbv-item-' + id).fadeOut(500);
}

function doRequest(action, dataObj, callBack) {
    var data = jQuery.param(dataObj);
    var _csrf = $('[name="_csrf"]').val();
    data += '&_csrf=' + _csrf;
    console.log(data);
    $.ajax({type: "POST",
        url: action,
        data: data, // serializes the form's elements.
        success: function (data) {
            console.log(data);
            if (callBack != undefined) {
                callBack(JSON.parse(data));
            }
        }
    });
}




function updateSort() {
    var data = {};
    $('.sbv-item').each(function () {

        var sort = $(this).find('.sort').val();
        var id = $(this).data('id');
        console.log(id + ':' + sort);
        data[id] = sort;
    });
    doRequest('/user/page/updatesort', {action: "bvUpdateSort", data: data}, function () {
        console.log('--->')
    });
}
$(function () {
    $(".sortable").sortable({
        handle: '.mover',
        stop: function (event, ui) {
            var sort = {};
            if ($(ui.item).hasClass('adm-block')) {
                var i = 0;
                console.log('adm-block')
                $(ui.item).closest('.adm-blocks-list').find('.adm-block').each(function () {
                    sort[$(this).data('id')] = i;
                    i++;
                });
                console.log(sort)
                doRequest('/user/page/updatesort', {action: "blockUpdateSort", data: sort}, function () {
                    console.log('--->')
                });
            } else {
                var i = 0;
                var parent = $(this).closest('.sbv-ul-icon-list').find('.sbv-item').each(function () {
                    console.log(i);
                    $(this).find('.sort').val(i);
                    i++;
                });
                updateSort();

            }


        }
    });
    $(".sortable").disableSelection();
});


function blockToggle(id) {
    var $innerBlock = $('#block-' + id).find('.adm-block-inner');
    var $btn = $('#block-' + id).find('.toggle-btn');
    if ($innerBlock.hasClass('opened')) {
        $innerBlock.hide();
        $innerBlock.removeClass('opened');
        $btn.removeClass('icon-minus');
        $btn.addClass('icon-plus');
    } else {
        $innerBlock.show();
        $innerBlock.addClass('opened')
        $btn.removeClass('icon-plus');
        $btn.addClass('icon-minus');
        // jQuery('textarea').autoResize();
        // jQuery('textarea').autoResize();
        // $('textarea').keyup(); //.css('height', h + 'px');
    }
}

function blockRemove(id, isConfirm) {
    if (isConfirm === undefined) {
        // alert('Точно удалить?');
    }
    doRequest('/user/page/blockremove', {id: id}, function (data) {
        console.log(data)
        $('#block-' + id).fadeOut(300);
    });
}