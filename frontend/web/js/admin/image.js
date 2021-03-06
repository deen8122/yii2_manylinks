//один из примеров реализации jQuery.browser
jQuery.browser = {};
(function () {
    jQuery.browser.msie = false;
    jQuery.browser.version = 0;
    if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
    }
})();
function CImage() {
    this.uploadAction = "/user/page/upload";

}

CImage.prototype.uploadToStorage = function (formId, dataConfig) {
    var $form = $('#' + formId);
    var data = $form.serialize();
    var file_data = $('#image_file_imager').prop('files')[0];
    console.log(file_data);
    if (file_data === undefined)
        return;
    var form_data = new FormData();
    form_data.append('file', file_data);
    var _csrf = $('[name="_csrf"]').val();
    form_data.append('_csrf', _csrf);
    var url = $form.attr("action");
    console.log(url);
    console.log(form_data);

    if (dataConfig.btn !== undefined) {
        var $btn = $(dataConfig.btn);
        var textBtn = $btn.text();
        $btn.text("загружаю...");
    }

    $.ajax({
        url: url + "?" + data,
        //dataType: 'text',
        cache: false,
        format: "JSON",
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function (res) {
            var res = JSON.parse(res);
            console.log(res);
            console.log(dataConfig.callback);
            if (dataConfig.callback !== undefined) {
                dataConfig.callback(res);
            }
            $btn.text(textBtn);
        }
    });

}
CImage.prototype.upload = function (id, _thisBtn) {
    var $btn = $(_thisBtn);
    var textBtn = $btn.text();
    console.log(textBtn);
    $btn.text(".......");
    var $form = $('#block-' + id).find('form');
    var data = $form.serialize();
    var file_data = $('#image_file').prop('files')[0];

    if (file_data === undefined)
        return;
    var form_data = new FormData();
    form_data.append('file', file_data);
    var _csrf = $('[name="_csrf"]').val();
    form_data.append('_csrf', _csrf);
    var url = this.uploadAction;
    console.log(url)
    $.ajax({
        url: url + "?" + data,
        cache: false,
        format: "JSON",
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function (data) {
            $btn.text(textBtn);
            var data3 = JSON.parse(data);
            console.log(data3);
            if (data3.error !== undefined) {
                var t = '<div class="alert alert-danger"><ul>';
                for (key in data.error) {
                    var obj = data.error[key];
                    t += '<li>' + obj + '</li>';
                }
                t += '<ul></div>';
                $('#upload-error').html(t);
                setTimeout(function () {
                    $('#upload-error').html("")
                }, 5000);
                return false;
            }
            if (data3.code === "ok") {
                var file = "" + data3.file;
                console.log(file);
                $form.find(".result").find("img").addClass("xxx").attr("src", file);
                $('#data_file').val(file);
                $form.find("input").keyup();
            }
        }
    });

}
YiiData.image = new CImage();


// convert bytes into friendly format
function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB'];
    if (bytes == 0)
        return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
}
;

// check for selected crop region
function checkForm() {
    if (parseInt($('#w').val()))
        return true;
    $('.error').html('Please select a crop region and then press Upload').show();
    return false;
}
;

// update info by cropping (onChange and onSelect events handler)
function updateInfo(e) {
    $('#x1').val(parseInt(e.x));
    $('#y1').val(parseInt(e.y));
    $('#x2').val(e.x2);
    $('#y2').val(e.y2);
    $('#w').val(e.w);
    $('#h').val(e.h);
    $('#w-text').text(parseInt(e.w));
    $('#h-text').text(parseInt(e.h));
}
;

// clear info by cropping (onRelease event handler)
function clearInfo() {
    $('.info #w').val('');
    $('.info #h').val('');
}
;
var jcrop_api;
function fileSelectHandler() {
    var oFile = $('#image_file')[0].files[0];
    $('.error').hide();
    var rFilter = /^(image\/jpeg|image\/png)$/i;
    if (!rFilter.test(oFile.type)) {
        $('.error').html('Можно загружать только изображения.').show();
        return;
    }
    if (oFile.size > 5*1024 * 1024) {
        $('.error').html('Слишком большой файл').show();
            return;
    }
    var oImage = document.getElementById('preview');
    var oReader = new FileReader();

    oReader.onload = function (e) {
        oImage.src = e.target.result;
        oImage.onload = function () { // onload event handler
            $('.step-1').fadeOut();
            $('.step-2').fadeIn();

            // display some basic image info
            var sResultFileSize = bytesToSize(oFile.size);
            $('#filesize').text(sResultFileSize);
            $('#filetype').text(oFile.type);
            $('#filedim').text(oImage.naturalWidth + ' x ' + oImage.naturalHeight);
            console.log($(this).width());
            $('#width').val($(this).width());
            $('#height').val($(this).height());
            // Create variables (in this scope) to hold the Jcrop API and image size
            var  boundx, boundy;

            if (typeof jcrop_api != 'undefined')
                jcrop_api.destroy();

            // initialize Jcrop
           $('#preview').Jcrop({
                minSize: [32, 32], // min crop size
                boxWidth: 500,
                aspectRatio: 1, // keep aspect ratio 1:1
                bgFade: true, // use fade effect
                bgOpacity: .3, // fade opacity
                onChange: updateInfo,
                onSelect: updateInfo,
                onRelease: clearInfo
            }, function () {
                // use the Jcrop API to get the real image size
                var bounds = this.getBounds();
                boundx = bounds[0];
                boundy = bounds[1];

                // Store the Jcrop API in the jcrop_api variable
                jcrop_api = this;
            });
        };
    };
    oReader.readAsDataURL(oFile);
    $('.btn-save-upload-4').show();
}


