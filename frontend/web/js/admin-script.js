var $openedPopup = null;
$(document).ready(function () {
    var openblocks = app.getParam("openblocks", {});
    console.log(openblocks);
    init();
});

function init() {
    //
    var debuggerActive = app.getParam("debuggerActive");
    console.log("============debuggerActive==============")
    console.log(debuggerActive);
    if (debuggerActive) {
        debuggerOpen();
    }
    $('.add-new-block').on('click', function () {
        $openedPopup = $('#add-block-form');
        $openedPopup.fadeIn(100);
        var offset = $(this).offset();
        console.log(offset);
        $openedPopup.css('top', offset.top + 'px');
        $('.popup-bg').fadeIn(100);
    });

    //Добавление ссылки
    $('.add-btn-link').on('click', function () {
        var sortN = 0;
        var sort = $(this).closest('.block').find('.sbv-ul-icon-list').find('.sort').last();

        if (sort.val() != undefined) {
            sortN = sort.val();
            sortN++;
        }
        //   console.log(sortN);

        //получаем шаблон
        var $item = $(this).closest('.block').find('.sbv-ul-icon-list').find('.sbv-item').last().clone();

        if ($item.length === 0) {
            var $item = $(this).closest('.block').find('.template').last().clone();
        }
        console.log($item);
        $item.find('input').val("");
        $item.find('.sort').val(sortN);

        $item.attr('style', '');
        $item.show();
        $(this).closest('form').find('.save-btn').addClass('active');
        $(this).closest('.block').find('.sbv-ul-icon-list').append($item);
        var block_id = $(this).data("block_id");
        doRequest('/user/page/sbvcreate', {block_id: $(this).data("block_id"), sort: sortN}, function (json) {
            // console.log(json);
            var id = json.id;
            if ($item === undefined) {
                reloadBlock(block_id);
            }
            $item.data("id", id);
            $item.attr("sbv-id", id);
            $item.find('.name').attr("name", "SBV[name][" + id + "]");
            $item.find('.value').attr("name", "SBV[value][" + id + "]");
            try {
                $item.find('.link').attr("name", "SBV[value][" + id + "][link]");
                $item.find('.text').attr("name", "SBV[value][" + id + "][text]");
                $item.find('.text2').attr("name", "SBV[value][" + id + "][text2]");
            } catch (e) {
                console.log(e);
            }
            $item.find('.sort').attr("name", "SBV[sort][" + id + "]");
        });
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
                debuggerUpdate();
            }
        });
    });
//

    jQuery('textarea').autoResize();
    $('textarea').keyup(); //.css('height', h + 'px');
    $('textarea,input').keyup(function () {
        $(this).closest('form').find('.save-btn').addClass('active');
    });
    //  $('.adm-block-inner').hide();
    //  $('.adm-block-inner').first().show();
    var openblocks = app.getParam("openblocks", {});
    ////  console.log(openblocks.length);
    console.log(openblocks);
    $('.adm-block').each(function () {
        var id = $(this).data('id');
        if (openblocks["block-" + id] !== 1 && openblocks["block-" + id] !== undefined) {
            blockToggle(id);
        }

    });

}


function reloadBlock(block_id) {
    console.log('reloadBlock >' + block_id)

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
        if (json.code === "error") {
            alert(json.message)
        } else {
            window.location = "";
        }
    });
}


function popup_close() {
    if ($openedPopup != null) {
        $openedPopup.fadeOut(100);
        $('.popup-bg').fadeOut(100);
        $openedPopup = null;
    }

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
    $('.sbv-item-' + id).remove();
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

        debuggerUpdate();
        console.log('-xxx-->');
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
                    debuggerUpdate();
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
    var openblocks = app.getParam("openblocks", {});
    var $innerBlock = $('#block-' + id).find('.adm-block-inner');
    var $parent = $('#block-' + id).closest('.adm-block');
    var $btn = $('#block-' + id).find('.block-form').find('.toggle-btn');
    if ($innerBlock.hasClass('opened')) {
        $innerBlock.hide();
        $innerBlock.removeClass('opened');
        $parent.removeClass('opened');
        $btn.removeClass('icon-minus');
        $btn.addClass('icon-plus');
        openblocks["block-" + id] = 0;
    } else {
        $innerBlock.show();
        $innerBlock.addClass('opened')
        $parent.addClass('opened')
        $btn.removeClass('icon-plus');
        $btn.addClass('icon-minus');
        openblocks["block-" + id] = 1;
    }
    app.setParam("openblocks", openblocks);
}

function blockRemove(id, isConfirm) {
    if (isConfirm === undefined) {
        var x = confirm("Подвтердите ваше намерение, пожалуйста.");
        if (x) {
            //return true;
        } else
            return false;

    }
    doRequest('/user/page/blockremove', {id: id}, function (data) {
        console.log(data)
        $('#block-' + id).fadeOut(300);
    });
}

function blockActivate(id, type) {
    var $obj = $('#block-' + id);
    if (type === "SiteBlockValue") {
        $obj = $('#sbv-' + id);
    }

    if (type === undefined) {
        type = "SiteBlock";
    }
    var param = 0;
    if (!$obj.hasClass("active")) {
        param = 1;
    }
    console.log(param);
    console.log(type);
    doRequest('/user/page/blockactivate', {id: id, status: param, type: type}, function (data) {
        console.log(data);


        if (data.status == 1) {
            $obj.addClass("active");
            $obj.removeClass("deactive");
        } else {
            $obj.addClass("deactive");
            $obj.removeClass("active");
        }

    });
}
//blockConfig
function blockConfig(id, type) {
    app.popupModule('site-block-config', {id: id, type: type});
}
