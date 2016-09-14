/*** Created on 25.08.2016. */
// формирование закладок (Визарда)
$('#rootwizard').bootstrapWizard();

// заполнение полей формы
// каскад Страна - Область - Город
function selectRegionA(){
    var id_country = $('select[name="countryA"]').val();
    if(!id_country){
        $('div[name="selectDataRegionA"]').html('<select name="areaA" id="areaA" class="form-control"></select>');
        $('div[name="selectDataCityA"]').html('<select name="townA" id="townA" class="form-control"></select>');
    }else{
        $.ajax({
            type: "POST",
            url: "../../includes/RegAreaTown.combo.ajax.php",
            data: { action: 'showRegionForInsert', id_country: id_country, flg: 'A' },
            cache: false,
            success: function(responce){ $('div[name="selectDataRegionA"]').html(responce); }
        });
        $('div[name="selectDataCityA"]').html('<select name="townA" id="townA" class="form-control" onchange="javascript:selectTownA();"></select>');
        //    console.log(sel.html());
    };
};
function selectCityA(){
    var id_region = $('select[name="areaA"]').val();
    var id_country = $('select[name="countryA"]').val();
    $.ajax({
        type: "POST",
        url: "../../includes/RegAreaTown.combo.ajax.php",
        data: { action: 'showCityForInsert', id_country: id_country, id_region: id_region, flg: 'A' },
        cache: false,
        success: function(responce){ $('div[name="selectDataCityA"]').html(responce); }
    });
    //console.log( sel.html() );
};
function selectTownA(){
    // перенести значения Город в Форму
    var area = $("#areaA option:selected");
    var town = $("#townA option:selected");
    var txt = area.html()+', '+town.html();
    $("#aa1").attr("value", txt);
    $("#aa2").attr("value", town.val());
    //console.log(sel.html());
};
function changeStreetA(){
    var sel = $("#streetA");
    $("#ab1").attr("value", sel.val());
};
function changeNumA(){
    var sel = $("#numA");
    $("#ac1").attr("value", sel.val());
};
function selectRegionB(){
    var id_country = $('select[name="countryB"]').val();
    if(!id_country){
        $('div[name="selectDataRegionB"]').html('<select name="areaB" id="areaB" class="form-control"></select>');
        $('div[name="selectDataCityB"]').html('<select name="townB" id="townB" class="form-control"></select>');
    }else{
        $.ajax({
            type: "POST",
            url: "../../includes/RegAreaTown.combo.ajax.php",
            data: { action: 'showRegionForInsert', id_country: id_country, flg: 'B' },
            cache: false,
            success: function(responce){ $('div[name="selectDataRegionB"]').html(responce); }
        });
        $('div[name="selectDataCityB"]').html('<select name="townB" id="townB" class="form-control" onchange="javascript:selectTownA();"></select>');
        //    console.log(sel.html());
    };
};
function selectCityB(){
    var id_region = $('select[name="areaB"]').val();
    var id_country = $('select[name="countryB"]').val();
    $.ajax({
        type: "POST",
        url: "../../includes/RegAreaTown.combo.ajax.php",
        data: { action: 'showCityForInsert', id_country: id_country, id_region: id_region, flg: 'B' },
        cache: false,
        success: function(responce){ $('div[name="selectDataCityB"]').html(responce); }
    });
    //console.log( sel.html() );
};
function selectTownB(){
    // перенести значения Город в Форму
    var area = $("#areaB option:selected");
    var town = $("#townB option:selected");
    var txt = area.html()+', '+town.html();
    $("#ba1").attr("value", txt);
    $("#ba2").attr("value", town.val());
    //console.log(sel.html());
};
function changeStreetB(){
    var sel = $("#streetB");
    $("#bb1").attr("value", sel.val());
};
function changeNumB(){
    var sel = $("#numB");
    $("#bc1").attr("value", sel.val());
};
function selectOper(){
    // перенести значения Клиент в Форму
    var sel = $("#oper option:selected");
    var id = sel.val();
    //console.log(id);
    $.ajax({
        type: "POST",
        url: "../../includes/Dogovors.combo.ajax.php",
        data: { action: 'dogovor', kli: id },
        cache: false,
        success: function(responce){
            //console.log(responce);
            $('div[name="dogovor"]').html(responce);
        }
    });
    $("#с1").attr("value", sel.html());
    $("#с2").attr("value", sel.val());
    //console.log(sel.html());
};
function selectDogov(){
    // перенести значения Клиент в Форму
    var sel = $("#dogov option:selected");
    var id = sel.val();
    $.ajax({
        type: "POST",
        url: "../../includes/Dogovors.combo.ajax.php",
        data: { action: 'dopdogovor', dogov: id },
        cache: false,
        success: function(responce){
            //console.log(responce);
            $('div[name="dopdogovor"]').html(responce);
        }
    });
    $("#сa2").attr("value", sel.val());
    //console.log(sel.html());
};
function selectDopdogov(){
    // перенести значения Клиент в Форму
    var sel = $("#dopdogov option:selected");
    $("#сb2").attr("value", sel.val());
    //console.log(sel.html());
};
function selectLocat(){
    var sel = $("#locat option:selected");
    if(sel.val() == 5){
        $("#varlink").show();
        $("#varoffice").hide();
        $("#varservice").hide();
        $("#d1").attr("value", sel.html());
        $("#d2").attr("value", sel.val());
    };
    if(sel.val() == 6){
        $("#varlink").hide();
        $("#varoffice").show();
        $("#varservice").hide();
        $("#d1").attr("value", sel.html());
        $("#d2").attr("value", sel.val());
    };
    if(sel.val() == 7){
        $("#varlink").hide();
        $("#varoffice").hide();
        $("#varservice").show();
        $("#d1").attr("value", sel.html());
        $("#d2").attr("value", sel.val());
    };
    $("#e1").attr("value","");
    $("#e2").attr("value","");
    //console.log(sel.val());
};
function showTab4(){
    var sel = $("#locat option:selected");
    if(sel.val() == 5){
        $("#varlink").show();
        $("#varoffice").hide();
        $("#varservice").hide();
    };
    if(sel.val() == 6){
        $("#varlink").hide();
        $("#varoffice").show();
        $("#varservice").hide();
    };
    if(sel.val() == 7){
        $("#varlink").hide();
        $("#varoffice").hide();
        $("#varservice").show();
    };
};
showTab4();
function selectDogovIn(){
    var sel = $("select[name='DogovIn1'] option:selected");
    $("#cc2").attr("value", sel.val());
    console.log(sel.val());
};
function selectKli(){
    // перенести значения Клиент в Форму
    var sel = $("#kli option:selected");
    $("#f1").attr("value", sel.html());
    $("#f2").attr("value", sel.val());
    //console.log(sel.html());
};
function selectSubunit(){
    // перенести значения ... в Форму
    var sel = $("select[name='subunit'] option:selected");
    $("#m1").attr("value", sel.html());
    $("#m2").attr("value", sel.val());
};
function selectSign(){
    // перенести значения ... в Форму
    var sel = $("select[name='sign'] option:selected");
    $("#n1").attr("value", sel.html());
    $("#n2").attr("value", sel.val());
};
function selectService(){
    // перенести значения ... в Форму
    var sel = $("select[name='service_type'] option:selected");
    $("#p1").attr("value", sel.html());
    $("#p2").attr("value", sel.val());
};
function selectStatus(){
    // перенести значения Статус Клиента в Форму
    var sel = $("#status option:selected");
    $("#t1").attr("value", sel.html());
    $("#t2").attr("value", sel.val());
};
function selectRent(){
    // перенести значения ... в Форму
    var sel = $("select[name='rent_service1'] option:selected");
    $("#s2").attr("value", sel.val());
};
// calendar for "date_in"
$("#g").datepicker({
    language: 'ru',
    format: "dd.mm.yyyy"
});
// calendar for "date_in_work"
$("#h").datepicker({
    language: 'ru',
    format: "dd.mm.yyyy"
});
// calendar for "date_in_task"
$("#l").datepicker({
    language: 'ru',
    format: "dd.mm.yyyy"
});
// calendar for "date_out"
$("#q").datepicker({
    language: 'ru',
    format: "dd.mm.yyyy"
});

$(document).ready(function(){
    // Сервисы Субпровайдеров
    var eTable = $("#equip").dataTable({
        "scrollY": "300px",
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
    // таблица Соедиений
    var ccTable = $('#link').dataTable({
        "processing": true,
        "pagingType": "full_numbers",
        "iDisplayLength": 10,
        "ajax": "../../includes/findCC.ajax.php",
        "columns": [
            {"title": "№"},
            {"title": "Тип сети"},
            {"title": "Link / Соединение"},
            {"title": "Соединение"}
        ]
    });
    // select pressed row
    $('#link tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        } else {
            ccTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        };
        // отбор позиции строки и значение столбца
        var aPos = ccTable.fnGetPosition( this );
        var aData = ccTable.fnGetData( aPos );
        $("#link_show").html('<font color="red">' + aData[2] + '</font>');
        $("#e1").attr("value", aData[2]);
        $("#e2").attr("value", aData[0]);
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
        $("#e1").attr("value", aData[1] + ', ' + aData[2] + ', ' + aData[3]);
        $("#e2").attr("value", aData[0]);
    });
    // скрыть таблицу Офисав
    //$("#varoffice").hide();
    // таблица Сервисов
    var skTable = $('#service').dataTable({
        "processing": true,
        "pagingType": "full_numbers",
        "iDisplayLength": 10,
        "ajax": "../../includes/findSK.ajax.php",
        "columns": [
            {"title": "№"},
            {"title": "Клиент"},
            {"title": "Тип сервиса"},
            {"title": "Емкость"},
            {"title": "Офис А"},
            {"title": "Офис Б"},
            {"title": "Статус"}]
    });
    // select pressed row
    $('#service tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            skTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        };
        // отбор позиции строки и значение столбца
        var aPos = skTable.fnGetPosition( this );
        var aData = skTable.fnGetData( aPos );
        $("#service_show").html('<font color="red">' + aData[4] + ' - ' + aData[5] + '</font>');
        $("#e1").attr("value", aData[4] + ' - ' + aData[5]);
        $("#e2").attr("value", aData[0]);
    });
    // скрыть таблицу Сервисов
    //$("#varservice").hide();
    // валидация формы
    $("#formadd").validate({
        rules: {
            countryA1: {
                required: true
            },
            areaA1: {
                required: true
            },
            countryB1: {
                required: true
            },
            areaB1: {
                required: true
            },
            oper1: {
                required: true
            },
            kli1: {
                required: true
            },
            cost: {
                required: true,
                number: true
            },
            status1: {
                required: true
            },
            planer: {
                required: true,
                number: true
            },
            date_in_task: {
                required: true
            },
            subunit1: {
                required: true
            },
            sign1: {
                required: true
            },
            cost_in: {
                required: true,
                number: true
            },
            service_type1: {
                required: true
            }
        },
        messages: {
            countryA1: {
                required: "Вернитесь на закладку №1 и сделайте выбор"
            },
            areaA1: {
                required: "Это поле обязательно для заполнения"
            },
            countryB1: {
                required: "Вернитесь на закладку №2 и сделайте выбор"
            },
            areaB1: {
                required: "Это поле обязательно для заполнения"
            },
            oper1: {
                required: "Вернитесь на закладку №3 и сделайте выбор"
            },
            kli1: {
                required: "Вернитесь на закладку №5 и сделайте выбор"
            },
            cost: {
                required: "Это поле обязательно для заполнения"
            },
            status1: {
                required: "Вернитесь на закладку №5 и сделайте выбор"
            },
            planer: {
                required: "Это поле обязательно для заполнения"
            },
            date_in_task: {
                required: "Это поле обязательно для заполнения"
            },
            subunit1: {
                required: "Вернитесь на закладку №5 и сделайте выбор"
            },
            sign1: {
                required: "Вернитесь на закладку №5 и сделайте выбор"
            },
            cost_in: {
                required: "Это поле обязательно для заполнения"
            },
            service_type1: {
                required: "Вернитесь на закладку №5 и сделайте выбор"
            }
        }
    });
});

