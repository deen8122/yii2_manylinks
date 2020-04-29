'use strict';
let SiteBlock2 = class {
    constructor() {
        this.$blockNme;
        this.action = {blocknameedit: []};
    }

    rename(_this, id) {
        this.$blockNme = $(_this);
        if (!this.action.blocknameedit[id]) {
            siteBlock.action.blocknameedit[id] = true;
            this.$blockNme.html(
                    "<input type='text' value='" + this.$blockNme.text() + "' style='padding: 0px;height: 24px;'>" +
                    "<div class='block-name-btns-cont'>" +
                    "<button onclick='siteBlock.save(" + id + ")' class='block-name-btn'>сохранить</button>" +
                    "<button onclick='SiteBlock.prototype.cancel(" + id + ")' class='block-name-btn'>отмена</button>" +
                    "</div>");
        }
    }
}
var siteBlock = new SiteBlock();
function SiteBlock() {
    this.$blockNme;
    this.action = {blocknameedit: []};
}
SiteBlock.prototype.siteBlockRename = function (_this, id) {
    this.$blockNme = $(_this);
    if (!this.action.blocknameedit[id]) {
        this.action.blocknameedit[id] = true;
        this.$blockNme.html(
                "<input type='text' value='" + this.$blockNme.text() + "' style='padding: 0px;height: 24px;'>" +
                "<div class='block-name-btns-cont'>" +
                "<button onclick='siteBlock.save(" + id + ")' class='block-name-btn'>сохранить</button>" +
                "<button onclick='siteBlock.cancel(" + id + ")' class='block-name-btn'>отмена</button>" +
                "</div>");
    }

}
SiteBlock.prototype.save = function (id) {
    console.log('updateName >' + id);
    var $obj = $('#block-' + id).find('.block-name');
    var blockname = $obj.find('input').val();
    $obj.html(blockname);
   setTimeout(function(){ siteBlock.action.blocknameedit[id] = false;},100)
    doRequest("update/", {id: id, blockname: blockname}, function (data) {
    });
}
SiteBlock.prototype.cancel = function (id) {
    var $obj = $('#block-' + id).find('.block-name');
    var t = $obj.find('input').val();
    $obj.text(t);
    setTimeout(function(){ siteBlock.action.blocknameedit[id] = false;},100)
   

}