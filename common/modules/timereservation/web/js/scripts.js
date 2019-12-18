//alert('1');
var serviceAdd = null;
document.addEventListener('DOMContentLoaded', function(){ 
 serviceAdd = new ServiceAdd();
});
function ServiceAdd() {
    console.log('ServiceAdd');
    console.log(serviceAdddata);
    this.userSelect = document.getElementById('user-select');
}
ServiceAdd.prototype.changeService = function (_this) {
    console.log('cangeService');
    console.log(_this.value);
    this.createUserSelect(_this.value);
};
ServiceAdd.prototype.createUserSelect = function (idService) {
    var users = [];
    for(var i = 0; i<serviceAdddata.length; i++){
        if(serviceAdddata[i].id==idService){
            users = users.concat(serviceAdddata[i].users);
        }
    }
        console.log(users);
        var t = '';
        for(var i = 0; i<users.length; i++){
     t+='<option value="'+users[i].id+'">'+users[i].fullname+'</option>';  
    }
     console.log(this.userSelect);
    // this.userSelect = document.getElementById('user-select');
    this.userSelect.innerHTML =(t);
};