<?php
    // проверка на существование открытой сессии (вставлять во все новые файлы)
    session_start();
    if(!isset($_SESSION["session_username"])) {
        header("location: ../../index.html");
    } else {
        ini_set('default_charset',"UTF-8");
        require "../../includes/constants.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Добавить Сетевое Устройство</title>
    <link rel="stylesheet" href="../../css/jquery.dataTables.css" />
    <link rel="stylesheet" href="../../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../css/dataTables.bootstrap.min.css" />
    <!-- style for validate: -->
    <style>  .error{ color: red; }  </style>
</head>
<body>
    <?php
    //Open database connection
    $mysqli = mysqli_connect($host,$user,$password,$db)
    or die("Ошибка " . mysqli_error($mysqli));
    ?>

    <div id="rootwizard">
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <ul>
                        <li><a href="#tab1" data-toggle="tab">1.Клиент</a></li>
                        <li><a href="#tab2" data-toggle="tab">2.Все поля</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane" id="tab1">
                <div  class="container">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Клиент:</label>
                        <div class="col-sm-10">
                            <select name="kli" id="kli" onchange="javascript:selectKli();" class="form-control">
                                <?php
                                $sql = 'SELECT id,client FROM tab_klients ORDER BY client';
                                $res = mysqli_query($mysqli, $sql);
                                echo '<option value="0"></option>';
                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                    echo '<option value="'.$row['id'].'">'.$row['client'].'</option>';
                                };
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Страна:</label>
                        <div class="col-sm-10">
                            <select name="country" id="country" class="form-control" onchange="javascript:selectRegion();">
                                <?php
                                $sql = 'SELECT id,country FROM tab_country ORDER BY id';
                                $res = mysqli_query($mysqli, $sql);
                                echo '<option value="0"></option>';
                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                    echo '<option value="'.$row['id'].'">'.$row['country'].'</option>';
                                };
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Область:</label>
                        <div class="col-sm-10">
                            <div  name="selectDataRegion">
                                <select name="area" id="area" class="form-control" onchange="javascript:selectCity();" ></select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Город:</label>
                        <div class="col-sm-10">
                            <div  name="selectDataCity">
                                <select name="town" id="town" class="form-control" onchange="javascript:selectTown();"></select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Статус:</label>
                        <div class="col-sm-10">
                            <select name="status" id="status" class="form-control" onchange="javascript:selectStatus();">
                                <?php
                                $sql = 'SELECT id,name FROM tab_status ORDER BY id';
                                $res = mysqli_query($mysqli, $sql);
                                echo '<option value="0"></option>';
                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                };
                                ?>
                            </select>
                        </div>
                    </div>
                    <br><!-- сетевое устройство -->
                    <label for="office">Подвязать к СУ:</label>
                    <table id="equip" class="display cell-border compact" cellspacing="0" width="100%"></table>
                    <div id="eq_show"><font color="red"></font></div>
                </div>
            </div>
            <div class="tab-pane" id="tab2">
                <div  class="container">

                </div>
            </div>
            <ul class="pager wizard">
                <li class="previous first" style="display:none;"><a href="#">First</a></li>
                <li class="previous"><a href="#">Previous</a></li>
                <li class="next last" style="display:none;"><a href="#">Last</a></li>
                <li class="next"><a href="#">Next</a></li>
            </ul>
        </div>
    </div>


    <!-- Close connection database -->
    <?php mysqli_close($mysqli); ?>
    <!-- Скрипты -->
    <script src="../../js/jquery-1.11.3.min.js"></script>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.bootstrap.wizard.min.js"></script>
    <script src="../../js/dataTables.bootstrap.min.js"></script>
    <script src="../../js/jquery.bootstrap.wizard.min.js"></script>
    <script src="../../js/jquery.validate.min.js"></script>
    <!-- MyScript -->
    <script>
        // формирование закладок (Визарда)
        $('#rootwizard').bootstrapWizard();
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
            //    var sel = $("#country :selected");
            //    $("#b1").attr("value", sel.html());
            //    $("#b2").attr("value", sel.val());
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
        //    var sel = $("#area option:selected");
        //    $("#c1").attr("value", sel.html());
        //    $("#c2").attr("value", sel.val());
            //console.log( sel.html() );
        };
        function selectTown(){
            // перенести значения Город в Форму
        //    var sel = $("#town :selected");
        //    $("#d1").attr("value", sel.html());
        //    $("#d2").attr("value", sel.val());
            //console.log(sel.html());
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
            //    $("#c1").attr("value",eData[3]);
            //    $("#c2").attr("value",eData[0]);
            });
        });
    </script>
    <?php }; ?>
</body>
</html>