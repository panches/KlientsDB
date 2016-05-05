/** Created on 11.01.2016. */
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
        var sel = $("#country :selected");
        $("#b1").attr("value", sel.html());
        $("#b2").attr("value", sel.val());
        console.log(sel.html());
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
    var sel = $("#town :selected");
    $("#d1").attr("value", sel.html());
    $("#d2").attr("value", sel.val());
    //console.log(sel.html());
};
function selectLease(){
    // перенести значения Категория аренды в Форму
    var sel = $("#lease option:selected");
    $("#f1").attr("value", sel.html());
    $("#f2").attr("value", sel.val());
    //console.log(sel.html());
};
function selectStatus(){
    // перенести значения Статус в Форму
    var sel = $("#status :selected");
    $("#g1").attr("value", sel.html());
    $("#g2").attr("value", sel.val());
    //console.log(sel.html());
};
function selectAccess(){
    // перенести значения ... в Форму
    var sel = $("select[name='access1'] option:selected");
    $("#j2").attr("value", sel.val());
    console.log(sel.val());
};
function selectSystem(){
    // перенести значения ... в Форму
    var sel = $("select[name='system1'] option:selected");
    $("#s2").attr("value", sel.val());
    console.log(sel.val());
};
function selectProprietor(){
    // перенести значения ... в Форму
    var sel = $("select[name='proprietor1'] option:selected");
    $("#t2").attr("value", sel.val());
    console.log(sel.val());
};
function selectPower( valSign ){
    // перенести значения ... в Форму
    switch ( valSign ) {
        case 'l1':
            sel = $("select[name='grounding1'] option:selected");
            $("#l2").attr("value", sel.val());
            break;
        case 'm1':
            sel = $("select[name='generator1'] option:selected");
            $("#m2").attr("value", sel.val());
            break;
        case 'n1':
            sel = $("select[name='battery1'] option:selected");
            $("#n2").attr("value", sel.val());
            break;
    };
    console.log(sel.val());
};
function selectControl( valSign ){
    switch ( valSign ) {
        case 'outpower':
            sel = $("select[name='outpower'] option:selected");
            $("#outpower2").attr("value", sel.val());
            break;
        case 'doors':
            sel = $("select[name='doors'] option:selected");
            $("#doors2").attr("value", sel.val());
            break;
        case 'temr':
            sel = $("select[name='temr'] option:selected");
            $("#temr2").attr("value", sel.val());
            break;
        case 'humidity':
            sel = $("select[name='humidity'] option:selected");
            $("#humidity2").attr("value", sel.val());
            break;
        case 'smoke':
            sel = $("select[name='smoke'] option:selected");
            $("#smoke2").attr("value", sel.val());
            break;
        case 'water':
            sel = $("select[name='water'] option:selected");
            $("#water2").attr("value", sel.val());
            break;
    };
    console.log(sel.val());
};
// wizard
$('#rootwizard').bootstrapWizard();
// validation form
$("#formadd").validate({
    rules:{
        name1:{
            required: true
        },
        country1:{
            required: true
        },
        area1:{
            required: true
        },
        town1:{
            required: true
        },
        address1:{
            required: true
        },
        lease1:{
            required: true
        },
        status1:{
            required: true
        },
        planner1:{
            required: true,
            number: true
        },
        power1:{
            required: true,
            number: true
        },
        autonomy1:{
            required: true,
            number: true
        }
    },
    messages:{
        name1:{
            required: "Это поле обязательно для заполнения"
        },
        country1:{
            required: "Вернитесь на первую закладку и сделайте выбор"
        },
        area1:{
            required: "Вернитесь на первую закладку и сделайте выбор"
        },
        town1:{
            required: "Вернитесь на первую закладку и сделайте выбор"
        },
        address1:{
            required: "Это поле обязательно для заполнения"
        },
        lease1:{
            required: "Вернитесь на первую закладку и сделайте выбор"
        },
        status1:{
            required: "Вернитесь на первую закладку и сделайте выбор"
        },
        planner1:{
            required: "Поле принимает только числа!"
        },
        power1:{
            required: "Поле принимает только числа!"
        },
        autonomy1:{
            required: "Поле принимает только числа!"
        }
    }
});
