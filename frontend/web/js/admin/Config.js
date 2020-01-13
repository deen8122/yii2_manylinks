var Config = {

    selectBackgroundColor: function (_this) {
        var c = _this.getAttribute('data-class');
        var img = _this.getAttribute('data-img')||false;
        var elements = document.getElementsByClassName('block-gradient');
        for (var i = 0; i < elements.length; i++) {
            elements[i].classList.remove('active');
        }
 console.log('selectBackgroundColor');
        console.log(img);
        _this.classList.add("active");
        console.log(c);
        doRequest("/extentions/bgimage/update", {bgClass: c, img: img}, function (data) {
            console.log(data);
            debuggerUpdate();
        });
    }
}

