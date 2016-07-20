// формирование закладок (Визарда)
$('#rootwizard').bootstrapWizard();
// заполнение полей формы
function selectKli(){
    // перенести значения Клиент в Форму
    var sel = $("#kli option:selected");
    $("#a1").attr("value", sel.html());
    $("#a2").attr("value", sel.val());
    console.log(sel.html());
};
function selectTypeServ(){
    // перенести значение Тип Сервиса в скрытую строку
    var sel = $("select[name='type_serv1'] option:selected");
    $("#d2").attr("value", sel.val());
    //console.log(sel.val());
};
function selectPriority(){
    // перенести значение Приоритет в скрытую строку
    var sel = $("select[name='priority1'] option:selected");
    $("#i2").attr("value", sel.val());
    //console.log(sel.val());
};
function selectStatus(){
    // перенести значения Статус Клиента в Форму
    var sel = $("#status option:selected");
    $("#n1").attr("value", sel.html());
    $("#n2").attr("value", sel.val());
    //console.log(sel.val());
};
function selectRetail(){
    // перенести значения Retail в Форму
    var sel = $("select[name='retail1'] option:selected");
    $("#02").attr("value", sel.val());
};
function selectSLA(){
    // перенести значение SLA в скрытую строку
    var sel = $("select[name='sla1'] option:selected");
    $("#p2").attr("value", sel.val());

};

$(document).ready(function() {
// таблица Офисов A
    var aTable = $("#officeA").dataTable({
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
    $('#officeA tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            aTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        };
        // отбор позиции строки и значение столбца
        var aPos = aTable.fnGetPosition( this );
        var aData = aTable.fnGetData( aPos );
        $("#officeA_show").html('Офис А: <font color="red">' + aData[1] + ', ' + aData[2] + ', ' + aData[3] + '</font>');
        $("#b1").attr("value",aData[1] + ', ' + aData[2] + ', ' + aData[3]);
        $("#b2").attr("value",aData[0]);
    });
// таблица Офисов B
    var bTable = $("#officeB").dataTable({
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
    $('#officeB tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            bTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        };
        // отбор позиции строки и значение столбца
        var aPos = bTable.fnGetPosition( this );
        var aData = bTable.fnGetData( aPos );
        $("#officeB_show").html('Офис Б: <font color="red">' + aData[1] + ', ' + aData[2] + ', ' + aData[3] + '</font>');
        $("#c1").attr("value",aData[1] + ', ' + aData[2] + ', ' + aData[3]);
        $("#c2").attr("value",aData[0]);
    });
    // валидация формы
    $("#formadd").validate({
        rules: {
            kli1: {
                required: true,
                remote: {url: "check.php?f=2", type:"post"}
            },
            officeA1: {
                required: true
            },
            speed: {
                required: true,
                remote: {url: "check.php?f=1", type:"post"}
            },
            officeB1: {
                required: true
            },
            status1: {
                required: true
            }
        },
        messages: {
            kli1: {
                required: "Вернитесь на первую закладку и сделайте выбор",
                remote: "Такого клиента нет, вернитесь на первую закладку и сделайте выбор"
            },
            officeA1: {
                required: "Вернитесь на вторую закладку и сделайте выбор"
            },
            officeB1: {
                required: "Вернитесь на вторую закладку и сделайте выбор"
            },
            speed: {
                required: "Поле необходимо заполнить",
                remote: "Значение должно быть числом."
            },
            status1: {
                required: "Вернитесь на первую закладку и сделайте выбор"
            }
        }
    });
});