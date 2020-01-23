var app = new App();
function App() {

}


App.prototype.popupModule = function (nameModule) {
    
    console.log('nameModule init... ')
    $openedPopup = $('#popup-form');
    $openedPopup.fadeIn(100);
    $openedPopup.css('top', '100px');
    $('.popup-bg').fadeIn(100);
    var width = $openedPopup.width();
     console.log('width='+width)
      $openedPopup.css('margin-left', '-'+(width/2)+'px');
    var $content = $openedPopup.find(".content-p");
    $content.html('<center><img src="/img/loading.gif"></center>');
    doRequest("/extentions/" + nameModule, {}, function (data) {
        $content.html(data.html)
    });
}
App.prototype.addScript = function (src) {
    var script = document.createElement('script');
    script.src = src;
    script.async = false; // чтобы гарантировать порядок
    document.head.appendChild(script);
}
App.prototype.setParam = function (name, value) {
   // console.log("-----------setParam--------------");
 //   console.log(name);
   // console.log(value);
     setCookie(name, JSON.stringify(value));

    //$.cookie(name, JSON.stringify(value));
};

App.prototype.getParam = function (name, defaultValue) {
    var data = getCookie(name);
    if (defaultValue === undefined) {
        defaultValue = false;
    }
    //console.log(data);
    if (data !== undefined) {
        data = JSON.parse(data);
    } else {
        data = defaultValue;
    }
    return data;
};


App.prototype.setConfigParam = function (name, defaultValue) {
    var data = getCookie(name);
    if (defaultValue === undefined) {
        defaultValue = false;
    }
    console.log(data);
    if (data !== undefined) {
        data = JSON.parse(data);
    } else {
        data = defaultValue;
    }
    return data;
};



// возвращает cookie с именем name, если есть, если нет, то undefined
function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}


function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);
     options.path="/";
    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}







function debuggerUpdate() {
    try {
        document.getElementById('iframe').contentWindow.location.reload(true);
    } catch (e) {
        console.log(e)
    }
}
function debuggerClose() {
    $('.iframe-phone').hide();
    app.setParam("debuggerActive", 0);
}
function debuggerOpen() {
    $('.iframe-phone').show();
    app.setParam("debuggerActive", 1);
}