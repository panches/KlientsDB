/** Created on 15.05.2016. */
/** Created on 12.05.2016. */
// формирование закладок (Визарда)
$('#rootwizard').bootstrapWizard();
// заполнение полей формы
function selectKli(){
    // перенести значения Клиент в Форму
    var sel = $("#kli option:selected");
    $("#a1").attr("value", sel.html());
    $("#a2").attr("value", sel.val());
    //console.log(sel.html());
};
// каскад Страна - Область - Город
function selectRegion(){
    var id_country = $('select[name="country"]').val();
    if(!id_country){
        $('div[name="selectDataRegion"]').html('<select name="area" id="area" class="form-control"></select>');
        $('div[name="selectDataCity"]').html('<select name="town" id="town" class="form-control"></select>');
    }else{
        $.ajax({
            type: "POST",
            url: "../../includes/RegAreaTown.combo.ajax.php",
            data: { action: 'showRegionForInsert', id_country: id_country },
            cache: false,
            success: function(responce){ $('div[name="selectDataRegion"]').html(responce); }
        });
        $('div[name="selectDataCity"]').html('<select name="town" id="town" class="form-control" onchange="javascript:selectTown();"></select>');
        // перенести значения Страна в Форму
        var sel = $("#country option:selected");
        $("#b1").attr("value", sel.html());
        $("#b2").attr("value", sel.val());
        //    console.log(sel.html());
    };
};
function selectCity(){
    var id_region = $('select[name="area"]').val();
    var id_country = $('select[name="country"]').val();
    $.ajax({
        type: "POST",
        url: "../../includes/RegAreaTown.combo.ajax.php",
        data: { action: 'showCityForInsert', id_country: id_country, id_region: id_region },
        cache: false,
        success: function(responce){ $('div[name="selectDataCity"]').html(responce); }
    });
    // перенести значения Область в Форму
    var sel = $("#area option:selected");
    $("#c1").attr("value", sel.html());
    $("#c2").attr("value", sel.val());
    //console.log( sel.html() );
};
function selectTown(){
    // перенести значения Город в Форму
    var sel = $("#town option:selected");
    $("#d1").attr("value", sel.html());
    $("#d2").attr("value", sel.val());
    //console.log(sel.html());
};
function selectRetail(){
    // перенести значения Retail в Форму
    var sel = $("select[name='retail1'] option:selected");
    $("#j2").attr("value", sel.val());
};
function selectMile(){
    // перенести значения "Последняя миля" в Форму
    var sel = $("select[name='mile1'] option:selected");
    $("#l2").attr("value", sel.val());
};
function selectDevice(){
    // перенести значения ... в Форму
    var sel = $("select[name='device1'] option:selected");
    $("#n2").attr("value", sel.val());
};
function selectStatOffice(){
    // перенести значения Статус Офиса в Форму
    var sel = $("select[name='status_office1'] option:selected");
    $("#r2").attr("value", sel.val());
};
function selectStatus(){
    // перенести значения Статус Клиента в Форму
    var sel = $("#status option:selected");
    $("#t1").attr("value", sel.html());
    $("#t2").attr("value", sel.val());
};
$(document).ready(function(){
    // Сетевые Устройства
    var eTable = $("#equip").dataTable({
        "scrollY":        "300px",
        "scrollCollapse": true,
        "processing": true,
        "ajax": "../../includes/findEq.ajax.php",
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
    $('#equip tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            eTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        };
        // отбор позиции строки и значение столбца
        var ePos = eTable.fnGetPosition( this );
        var eData = eTable.fnGetData( ePos );
        $("#eq_show").html('<font color="red">' + eData[3] + '</font>');
        $("#h1").attr("value",eData[3]);
        $("#h2").attr("value",eData[0]);
    });
    // валидация формы
    $("#formadd").validate({
        rules: {
            kli1: {
                required: true
            },
            country1: {
                required: true
            },
            area1: {
                required: true
            },
            town1: {
                required: true
            },
            office1: {
                required: true
            },
            status1: {
                required: true
            }
        },
        messages: {
            kli1: {
                required: "Вернитесь на первую закладку и сделайте выбор"
            },
            country1: {
                required: "Вернитесь на первую закладку и сделайте выбор"
            },
            area1: {
                required: "Вернитесь на первую закладку и сделайте выбор"
            },
            town1: {
                required: "Вернитесь на первую закладку и сделайте выбор"
            },
            office1: {
                required: "Вернитесь на первую закладку и сделайте выбор"
            },
            status1: {
                required: "Вернитесь на первую закладку и сделайте выбор"
            }
        }
    });
});