var Config = {

    selectBackgroundColor: function (_this) {
        var c = _this.getAttribute('data-color');
        _this.classList.add("active");
        console.log(c);
        doRequest("/extentions/bgimage/update", {bgClass:c}, function (data) {
            console.log(data);
            debuggerUpdate();
        });
    }
}

