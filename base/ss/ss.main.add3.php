<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location: ../../index.html");
};
ini_set('default_charset',"UTF-8");
require "../../includes/constants.php"; //Open database connection
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>Добавить Сетевое Соединение</title>
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
                    <li><a href="#tab1" data-toggle="tab">1.Выбор устройств</a></li>
                    <li><a href="#tab2" data-toggle="tab">2.Выбор партнера</a></li>
                    <li><a href="#tab3" data-toggle="tab">3.Выбор SLA</a></li>
                    <li><a href="#tab4" data-toggle="tab">4.Статус соединения</a></li>
                    <li><a href="#tab5" data-toggle="tab">5.Все данные</a></li>
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
                            <select name="nets" id="nets" onchange="javascript:selectNet();" class="form-control">
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
                </div>
            </div>
            <div class="tab-pane" id="tab2">
                <div  class="container">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Партнер:</label>
                        <div class="col-sm-10">
                            <select name="kli" id="kli" onchange="javascript:selectKli();" class="form-control">
                                <option value="-1"></option>
                                <?php
                                $sql = 'SELECT id,client FROM tab_klients ORDER BY client';
                                $res = mysqli_query($mysqli, $sql);
                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                    echo '<option value="'.$row['id'].'">'.$row['client'].'</option>';
                                };
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab3">
                <div  class="container">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">SLA:</label>
                        <div class="col-sm-10">
                            <select name="sla_link" id="sla_link" onchange="javascript:selectSLA();" class="form-control">
                                <option value="-1"></option>
                                <?php
                                $sql = 'SELECT id,name FROM sla_rules ORDER BY id';
                                $res = mysqli_query($mysqli, $sql);
                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                };
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab4">
                <div  class="container">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Статус соединения:</label>
                        <div class="col-sm-10">
                            <select name="status_link" id="status_link" onchange="javascript:selectStatus();" class="form-control" >
                                <option value="-1"></option>
                                <?php
                                $sql = 'SELECT id,name FROM tab_status ORDER BY id';
                                $res = mysqli_query($mysqli, $sql);
                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                };
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab5">
                <div  class="container">
                    <!-- Форма Остальные данные -->
                    <form id="formadd" method="post" action="ss.main.add.sql.php">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Тип сети:</label>
                            <div class="col-sm-9">
                                <input type="text" name="type_net" id="aa1" class="form-control" value="" />
                                <input type="hidden" name="type_net2" id="aa2" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Устройство А:</label>
                            <div class="col-sm-9">
                                <input type="text" name="equip_a" id="b1" class="form-control" value="" />
                                <input type="hidden" name="equip_a2" id="b2" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Порт А:</label>
                            <div class="col-sm-9">
                                <input type="text" name="port_a" id="c" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Партнер:</label>
                            <div class="col-sm-9">
                                <input type="text" name="client" id="d1" class="form-control" value="" />
                                <input type="hidden" name="client2" id="d2" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">CID:</label>
                            <div class="col-sm-9">
                                <input type="text" name="cid" id="e" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">SLA:</label>
                            <div class="col-sm-9">
                                <input type="text" name="sla" id="ea1" class="form-control" value="" />
                                <input type="hidden" name="sla2" id="ea2" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Пропускная способность (Мбит/с):</label>
                            <div class="col-sm-9">
                                <input type="text" name="speed" id="f" class="form-control" value="" />
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
                                <input type="date" name="date_in" id="i" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Выведен из эксплуатации:</label>
                            <div class="col-sm-9">
                                <input type="text" name="date_out" id="j" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Особенности приема:</label>
                            <div class="col-sm-9">
                                <input type="text" name="in_out" id="l" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Статус соединения:</label>
                            <div class="col-sm-9">
                                <input type="text" name="status" id="m1" class="form-control" value="" />
                                <input type="hidden" name="status2" id="m2" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Признак соединения:</label>
                            <div class="col-sm-9">
                                <input type="text" name="sign" id="n" class="form-control" value="сервис провайдера" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">№ в планере:</label>
                            <div class="col-sm-9">
                                <input type="text" name="planer" id="o" class="form-control" value="" />
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
                                <button name="btnOk" id="btnOk" class="btn"><img src="../../img/ok.png"> Ok</button>
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
<script src="../../js/jquery-1.11.3.min.js"></script>
<script src="../../js/jquery.dataTables.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/jquery.bootstrap.wizard.min.js"></script>
<script src="../../js/dataTables.bootstrap.min.js"></script>
<script src="../../js/jquery.bootstrap.wizard.min.js"></script>
<script src="../../js/jquery.validate.min.js"></script>
<!-- MyScript -->
<script src="ss.main.add3.js"></script>
</body>
</html>    