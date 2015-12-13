<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location: ../index.html");
};
ini_set('default_charset',"UTF-8");
require "../includes/constants.php"; //Open database connection
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>Добавить Сетевое Соединение</title>
    <link rel="stylesheet" href="../css/jquery.dataTables.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/dataTables.bootstrap.min.css" />
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
                    <li><a href="#tab1" data-toggle="tab">Выбор устройств</a></li>
                    <li><a href="#tab2" data-toggle="tab">Остальные данные</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
            <div class="tab-pane" id="tab1">
                <div  class="container">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Тип сети:</label>
                        <div class="col-sm-10">
                            <select name="nets" id="nets" onchange="javascript:selectNet();" class="form-control" required>
                                <?php
                                $sql = 'SELECT id,net FROM tab_nets ORDER BY id';
                                $res = mysqli_query($mysqli, $sql);
                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                    echo '<option value="'.$row['id'].'">'.$row['net'].'</option>';
                                };
                                ?>
                            </select>
                        </div>
                    </div>  <br>
                    <!-- Устройство А -->
                    <label for="equipA">Устройство А:</label>
                    <table id="equipA" class="display cell-border compact" cellspacing="0" width="100%"></table>
                    <div id="eqa_show"><font color="red"></font></div><br>
                    <!-- Устройство Б -->
                    <label for="equipB">Устройство Б:</label>
                    <table id="equipB" class="display cell-border compact" cellspacing="0" width="100%"></table>
                    <div id="eqb_show"><font color="red"></font></div>
                </div>
            </div>
            <div class="tab-pane" id="tab2">
                <div  class="container">
                    <!-- Форма Остальные данные -->
                    <form method="post" action="ss.main.add.sql.php">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Тип сети:</label>
                            <div class="col-sm-9">
                                <input type="text" name="type_net" id="a1" class="form-control" value="" required />
                                <input type="hidden" name="type_net2" id="a2" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Устройство А:</label>
                            <div class="col-sm-9">
                                <input type="text" name="equip_a" id="b1" class="form-control" value="" required />
                                <input type="hidden" name="equip_a2" id="b2" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Порт А:</label>
                            <div class="col-sm-9">
                                <input type="text" name="port_a" id="c" class="form-control" value="" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Устройство Б:</label>
                            <div class="col-sm-9">
                                <input type="text" name="equip_b" id="d1" class="form-control" value="" required />
                                <input type="hidden" name="equip_b2" id="d2" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Порт Б:</label>
                            <div class="col-sm-9">
                                <input type="text" name="port_b" id="e" class="form-control" value="" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Пропускная способность (Мбит/с):</label>
                            <div class="col-sm-9">
                                <input type="text" name="speed" id="f" class="form-control" value="" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Схема:</label>
                            <div class="col-sm-9">
                                <textarea  rows="3" name="scheme" id="g" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Принят в эксплуатацию:</label>
                            <div class="col-sm-9">
                                <input type="date" name="date_in" id="i" class="form-control" value="" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Выведен из эксплуатации:</label>
                            <div class="col-sm-9">
                                <input type="text" name="date_out" id="j" class="form-control" value="" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Особенности приема:</label>
                            <div class="col-sm-9">
                                <input type="text" name="in_out" id="l" class="form-control" value="" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Статус соединения:</label>
                            <div class="col-sm-9">
                                <select name="status" id="m1" onchange="javascript:selectStatus();" class="form-control" required >
                                    <option value="-1"></option>
                                    <?php
                                    $sql = 'SELECT id,name FROM tab_status ORDER BY id';
                                    $res = mysqli_query($mysqli, $sql);
                                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                    };
                                    ?>
                                </select>
                                <input type="hidden" name="status2" id="m2" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Признак соединения:</label>
                            <div class="col-sm-9">
                                <select name="sign" id="n1" onchange="javascript:selectSign();" class="form-control" required >
                                    <option value="0">сетевое</option>
                                    <option value="2">межсетевое</option>
                                    <option value="3">сервис провайдера</option>
                                </select>
                                <input type="hidden" name="sign2" id="n2" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">№ в планере:</label>
                            <div class="col-sm-9">
                                <input type="text" name="planer" id="o" class="form-control" value="" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Примечание:</label>
                            <div class="col-sm-9">
                                <textarea  rows="3" name="note" id="h" class="form-control"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-sm-13 col-sm-offset-11">
                                <button name="btnOk" id="btnOk" class="btn"><img src="../img/ok.png"> Ok</button>
                            </div>
                        </div>
                    </form>
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

<?php mysqli_close($mysqli); ?>

<!-- JS -->
<script src="../js/jquery-1.11.3.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.bootstrap.wizard.min.js"></script>
<script src="../js/dataTables.bootstrap.min.js"></script>
<script> // wizard
    // Type nets, Status, Sign :
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
        var sel = $("#m1 :selected");
       // перенести значения Статуса в Форму
        $("#m2").attr("value", sel.val());
    };
    function selectSign() {
        var sel = $("#n1 :selected");
       // перенести значения Признака в Форму
        $("#n2").attr("value", sel.val());
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
    });
</script>
</body>
</html>    