var yii = new Yii();
function Yii() {

}
Yii.prototype.addScript = function (src) {
    var script = document.createElement('script');
    script.src = src;
    script.async = false; // чтобы гарантировать порядок
    document.head.appendChild(script);
}
Yii.prototype.setParam = function (name, value) {
    console.log("-----------setParam--------------");
    console.log(name);
    console.log(value);
   // setCookie(name, JSON.stringify(value));

   $.cookie(name, JSON.stringify(value)); 
};

Yii.prototype.getParam = function (name, defaultValue) {
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


Yii.prototype.setConfigParam = function (name, defaultValue) {
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