/** Created on 22.12.2015. */
    // Type nets, Status :
function selectNet() {
    var sel = $("#nets :selected");
    // найти все записи в таблицах, которые содержат выбранный тип сети
    $("#equipA").dataTable().api().search( sel.html() ).draw();
    $("#equipB").dataTable().api().search( sel.html() ).draw();
    // перенести значения Тип Сети в Форму
    $("#a1").attr("value", sel.html());
    $("#a2").attr("value", sel.val());
};
function selectStatus() {
    var sel = $("#status_link :selected");
    // перенести значения Статуса в Форму
    $("#m1").attr("value", sel.html());
    $("#m2").attr("value", sel.val());
};

$(document).ready(function(){
    // wizard
    $('#rootwizard').bootstrapWizard();
    // Сетевые Устройства A
    var aTable = $("#equipA").dataTable({
        "scrollY":        "300px",
        "scrollCollapse": true,
        "processing": true,
        "ajax": "../includes/findEq.ajax.php",
        "columns": [
            {"title": "№"},
            {"title": "Тип сети"},
            {"title": "IP-адрес"},
            {"title": "Название в NMS"},
            {"title": "Адрес расположения"},
            {"title": "Производитель"},
            {"title": "Модель"}
        ]
    });
    // select entery row
    $('#equipA tbody').on( 'click', 'tr', function () {
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
        $("#eqa_show").html('<font color="red">' + aData[3] + '</font');
        $("#b1").attr("value",aData[3]);
        $("#b2").attr("value",aData[0]);
    });
    // Сетевые Устройства Б
    var bTable = $("#equipB").dataTable({
        "scrollY":        "300px",
        "scrollCollapse": true,
        "processing": true,
        "ajax": "../includes/findEq.ajax.php",
        "columns": [
            {"title": "№"},
            {"title": "Тип сети"},
            {"title": "IP-адрес"},
            {"title": "Название в NMS"},
            {"title": "Адрес расположения"},
            {"title": "Производитель"},
            {"title": "Модель"}
        ]
    });
    // select entery row
    $('#equipB tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            bTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        };
        // отбор позиции строки и значение столбца
        var bPos = bTable.fnGetPosition( this );
        var bData = bTable.fnGetData( bPos );
        $("#eqb_show").html('<font color="red">' + bData[3] + '</font');
        $("#d1").attr("value",bData[3]);
        $("#d2").attr("value",bData[0]);
    });

    $("#formadd").validate({
        rules:{
            type_net:{
                required: true
            },
            equip_a:{
                required: true
            },
            port_a:{
                required: true
            },
            equip_b:{
                required: true
            },
            port_b:{
                required: true
            },
            speed:{
                required: true
            },
            date_in:{
                required: true
            },
            status:{
                required: true
            },
            planer:{
                required: true
            }
        },
        messages:{
            type_net:{
                required: "Вернитесь на первую закладку и сделайте выбор"
            },
            equip_a:{
                required: "Вернитесь на первую закладку и сделайте выбор"
            },
            port_a:{
                required: "Это поле обязательно для заполнения"
            },
            equip_b:{
                required: "Вернитесь на первую закладку и сделайте выбор"
            },
            port_b:{
                required: "Это поле обязательно для заполнения"
            },
            speed:{
                required: "Это поле обязательно для заполнения"
            },
            date_in:{
                required: "Это поле обязательно для заполнения"
            },
            status:{
                required: "Вернитесь на вторую закладку и сделайте выбор"
            },
            planer:{
                required: "Это поле обязательно для заполнения"
            }
        }
    });
});