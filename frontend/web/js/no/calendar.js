
var clndr = new ServiceAdd();
document.addEventListener('DOMContentLoaded', function () {
    clndr.reservation = reservation;
    clndr.site_id = site_id;
    clndr.dateCurrent = dateCurrent;
    clndr.drawEvents();


});
function ServiceAdd() {
    var reservation = [];
    var kLeft = 0;
    var firstTime = null;
    this.selectServices = 0;
    this.site_id = 0;
    this.dateCurrent = null;
    this.leftOffset = [];
    console.log('ServiceAdd');


}

ServiceAdd.prototype.setDate = function () {
    var date = $('#input-date').val();
    console.log(date);
    $('.dhx_cal_event_line').remove();
    var tblBulider = new TabelBuilder();
    tblBulider.date_current = date;
    tblBulider.createWorkTime();
    $.ajax({
        type: "GET",
        data: {date: date},
        success: function (data) {
            console.log(data);
            var jsonData = JSON.parse(data);
            if (jsonData.status === 0) {

            } else {
                clndr.reservation = jsonData.reservation;
                console.log(clndr.reservation);
                clndr.drawEvents();
            }
        }
    });
};

ServiceAdd.prototype.send = function () {
    console.log('------------send-------------');
     console.log('------------send-------------');
    if(this.selectServices == 0){
        alert('Выберите услугу!');
        return false;
    }
    var data = {
        date: $('#input-date').val() + ' ' + $('#select-time').val(),
        service: this.selectServices,
        user: $('#select-user').val(),
        _csrf: $('meta[name="csrf-token"]').attr("content")
    };
    console.log(data);
    $.ajax({
        type: "POST",
        url: '/org/' + clndr.site_id + '/add',
        data: data, // serializes the form's elements.
        success: function (data) {
            console.log(data);
            var jsonData = JSON.parse(data);
            if (jsonData.status === 0) {
                if (jsonData.code === 'isGuest') {
                    alert("Для бронирования нужно авторизоваться!!!");
                }

            } else {
                clndr.reservation = jsonData.reservation;
                console.log(jsonData.reservation);
                clndr.drawEvents();
            }
        }
    });
};

ServiceAdd.prototype.init = function () {
    var tBars = $('.dhx_scale_bar');

    var fisrs = tBars.first();
    var last = tBars.last();
    var timeFirst = fisrs.data('time');
    var timeLast = last.data('time');
    var timeDelta = timeLast - timeFirst;
    var leftFirst = fisrs.position().left;
    var leftLast = last.position().left;
    this.firstTime = timeFirst;
    var leftDelta = leftLast - leftFirst;
    this.kLeft = leftDelta / timeDelta;
};
ServiceAdd.prototype.add = function (id, hour) {

    console.log(id + ' | ' + hour);

};
ServiceAdd.prototype.addService = function (id) {
    this.selectServices = id;
    //  this.selectServices.push(id);
    //  console.log(this.selectServices);
    //  this.drawServiceSelectedList();
};
ServiceAdd.prototype.drawServiceSelectedList = function () {

    var t = '';
    for (var i = 0; i < this.selectServices.length; i++) {
        var service_id = this.selectServices[i];
        var obj = services[service_id];
        t += '<div class="" style="background:;">' + obj.title + '  ' + obj.price + '\n\
                 </div>';
    }
    $('.service-list').html(t);
};



ServiceAdd.prototype.updateTable = function () {
    $.ajax({
        type: "GET",
        url: '?act=onlytable',
        success: function (data) {
            console.log(data);
        }
    });
}

ServiceAdd.prototype.drawEvents = function () {
    this.init();
    for (var i = 0; i < this.reservation.length; i++) {
        var left = (this.reservation[i].time_hour_min - this.firstTime) * this.kLeft;
        var width = this.reservation[i].longtime * 100 / 60;
        var t = '<div class="dhx_cal_event_line " \n\
                      style="background:' + this.reservation[i].service_color + ';position:absolute; top:2px; height: 88px; left:' + left + 'px; width:' + width + 'px;">\n\
                       ' + this.reservation[i].service_name + ' \n\
                 </div>';
        $('.userline-' + this.reservation[i].user_id).append(t);
    }

};

ServiceAdd.prototype.changeService = function (_this) {
    console.log('cangeService');
    console.log(_this.value);
    this.createUserSelect(_this.value);
};
ServiceAdd.prototype.createUserSelect = function (idService) {
    var users = [];
    for (var i = 0; i < serviceAdddata.length; i++) {
        if (serviceAdddata[i].id == idService) {
            users = users.concat(serviceAdddata[i].users);
        }
    }
    console.log(users);
    var t = '';
    for (var i = 0; i < users.length; i++) {
        t += '<option value="' + users[i].id + '">' + users[i].fullname + '</option>';
    }
    console.log(this.userSelect);
    // this.userSelect = document.getElementById('user-select');
    this.userSelect.innerHTML = (t);
};

function TabelBuilder() {
    this.date_current = '';
}
TabelBuilder.prototype.createWorkTime = function () {
    var hour = 8;
    var min = 0;
    var offset = 200;
    var minInt = 900;
    var t = '';
    var mimInt = 0;
    for (var i = 0; i <= 16; i++) {
        if (min == 0) {
            min = 1;
            hour++;
            mimInt = 0;
            minText = '00';
        } else {
            min = 0;
            minText = '30';
            mimInt = 40;
        }
        date = this.date_current + ' ' + hour + ':' + minText;
        var mSec = hour * 3600 * 100 + mimInt * 6000;
        console.log(mSec);
        t += '<div class="dhx_scale_bar " ' +
                'data-time="' + mSec + '" ' +
                'style="width: 50px; height: 18px; left:' + offset + 'px; ">' + hour + ':' + minText +
                '</div>';
        offset += 50;
        minInt += 50;
    }
    $('#work-times').html(t);
};