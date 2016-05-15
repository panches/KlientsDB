/** Created on 15.05.2016. */
function selectEquip(){
    var sel = $("#equip option:selected");
    $("#d1").attr("value", sel.html());
    $("#d2").attr("value", sel.val());
    console.log(sel.val());
};
function selectLocat(){
    var sel = $("#locat option:selected");
    if(sel.val() == 0){
        $("#varnode").show();
        $("#varoffice").hide();
        $("#e1").attr("value", sel.html());
        $("#e2").attr("value", sel.val());
    };
    if(sel.val() == 1){
        $("#varnode").hide();
        $("#varoffice").show();
        $("#e1").attr("value", sel.html());
        $("#e2").attr("value", sel.val());
    };
    $("#f1").attr("value","");
    $("#f2").attr("value","");
    console.log(sel.val());
};
function selectNet(){
    var sel = $("#nets option:selected");
    $("#a1").attr("value", sel.html());
    $("#a2").attr("value", sel.val());
    console.log(sel.val());
};
function selectStatus(){
    var sel = $("#status_equip option:selected");
    $("#m1").attr("value", sel.html());
    $("#m2").attr("value", sel.val());
    console.log(sel.val());
};
// формирование закладок (Визарда)
$('#rootwizard').bootstrapWizard();
// признак Узла/Офиса из MySQL
var linkage = "<?php echo $equip['linkage'] ?>";

$(document).ready(function() {
    // таблица Узлов
    var nTable = $("#node").dataTable({
        "scrollCollapse": true,
        "processing": true,
        "ajax": "../../includes/findNode.ajax.php",
        "columns": [
            {"title": "№"},
            {"title": "Название"},
            {"title": "Страна"},
            {"title": "Область"},
            {"title": "Город"},
            {"title": "Адрес"}
        ]
    });
    // select entery row
    $('#node tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            nTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        };
        // отбор позиции строки и значение столбца
        var aPos = nTable.fnGetPosition( this );
        var aData = nTable.fnGetData( aPos );
        $("#node_show").html('<font color="red">' + aData[4] + ', ' + aData[5] + '</font>');
        $("#f1").attr("value",aData[4] + ', ' + aData[5]);
        $("#f2").attr("value",aData[0]);
    });
    // таблица Офисов
    var oTable = $("#office").dataTable({
        "scrollCollapse": true,
        "processing": true,
        "ajax": "../../includes/findOK.ajax.php",
        "columns": [
            {"title": "№"},
            {"title": "Клиент"},
            {"title": "Город"},
            {"title": "Улица"},
            {"title": "Название в NMS"},
            {"title": "Порт"},
            {"title": "ПМ"},
            {"title": "Страна"},
            {"title": "Область"}
        ]
    });
    // select entery row
    $('#office tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            oTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        };
        // отбор позиции строки и значение столбца
        var aPos = oTable.fnGetPosition( this );
        var aData = oTable.fnGetData( aPos );
        $("#office_show").html('<font color="red">' + aData[1] + ', ' + aData[2] + ', ' + aData[3] + '</font>');
        $("#f1").attr("value",aData[1] + ', ' + aData[2] + ', ' + aData[3]);
        $("#f2").attr("value",aData[0]);
    });
    // скрыть таблицу
    if(linkage == 0){
        $("#varoffice").hide();
    } else {
        $("#varnode").hide();
    }
    // валидация формы
    $("#formadd").validate({
        rules: {
            type_net: {
                required: true
            },
            ipaddr: {
                required: true
            },
            nms: {
                required: true
            },
            fromlist: {
                required: true
            },
            attach: {
                required: true
            },
            date_in: {
                required: true
            },
            status: {
                required: true
            }
        },
        messages: {
            type_net: {
                required: "Вернитесь на вторую закладку и сделайте выбор"
            },
            ipaddr: {
                required: "Это поле обязательно для заполнения"
            },
            nms: {
                required: "Это поле обязательно для заполнения"
            },
            fromlist: {
                required: "Вернитесь на первую закладку и сделайте выбор"
            },
            attach: {
                required: "Вернитесь на первую закладку и сделайте выбор"
            },
            date_in: {
                required: "Это поле обязательно для заполнения"
            },
            status: {
                required: "Вернитесь на вторую закладку и сделайте выбор"
            }
        }
    });
});