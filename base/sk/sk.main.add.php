<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location: ../../index.html");
} else {
    ini_set('default_charset',"UTF-8");
    require "../../includes/constants.php";
    //Open database connection
    $mysqli = mysqli_connect($host,$user,$password,$db)
                or die("Ошибка " . mysqli_error($mysqli));
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Добавить Сервис Клиента</title>
    <link rel="stylesheet" href="../../css/jquery.dataTables.css" />
    <link rel="stylesheet" href="../../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../css/dataTables.bootstrap.min.css" />
    <!-- style for validate: -->
    <style>  .error{ color: red; }  </style>
</head>
<body>
    <div id="rootwizard">
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <ul>
                        <li><a href="#tab1" data-toggle="tab">1.Клиент</a></li>
                        <li><a href="#tab2" data-toggle="tab">2.Офисы</a></li>
                        <li><a href="#tab3" data-toggle="tab">3.Все поля</a></li>
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
                            <select name="kli" id="kli" class="form-control" onchange="javascript:selectKli();" >
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
                        <label class="col-sm-2 control-label">Статус:</label>
                        <div class="col-sm-10">
                            <select name="status" id="status" class="form-control" onchange="javascript:selectStatus();">
                                <?php
                                $sql = 'SELECT id,name FROM tab_status ORDER BY id';
                                $res = mysqli_query($mysqli, $sql);
                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                    echo '<option ';
                                    if($row['id'] == 2) echo " selected='selected' ";
                                    echo 'value='.$row['id'].'>'.$row['name'].'</option>';
                                };
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab2">
                <div  class="container">
                    <div class="form-group">
                        <!-- офис A -->
                        <label for="officeA" id="officeA_show">Офис А:</label>
                        <table id="officeA" class="display cell-border compact" cellspacing="0" width="100%"></table>
                        <!-- офис B -->
                        <label for="officeB" id="officeB_show">Офис Б:</label>
                        <table id="officeB" class="display cell-border compact" cellspacing="0" width="100%"></table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab3">
                <div  class="container">
                    <!-- Форма Все поля -->
                    <form id="formadd" method="post" action="sk.main.add.sql.php">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Клиент:</label>
                            <div class="col-sm-9">
                                <input type="text" name="kli1" id="a1" class="form-control" value="" />
                                <input type="hidden" name="kli2" id="a2" class="form-control" value="" />
                            </div>
                            <label class="col-sm-3 control-label">Офис А:</label>
                            <div class="col-sm-9">
                                <input type="text" name="officeA1" id="b1" class="form-control" value="" />
                                <input type="hidden" name="officeA2" id="b2" class="form-control" value="" />
                            </div>
                            <label class="col-sm-3 control-label">Офис Б:</label>
                            <div class="col-sm-9">
                                <input type="text" name="officeB1" id="c1" class="form-control" value="" />
                                <input type="hidden" name="officeB2" id="c2" class="form-control" value="" />
                            </div>
                            <label class="col-sm-3 control-label">Тип сервиса:</label>
                            <div class="col-sm-9">
                                <select name="type_serv1" id="d1" onchange="javascript:selectTypeServ();" class="form-control">
                                    <?php
                                    $sql = 'SELECT id,name FROM tab_katal_sk_type ORDER BY id';
                                    $res = mysqli_query($mysqli, $sql);
                                    echo '<option value="0"></option>';
                                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                    };
                                    ?>
                                </select>
                                <input type="hidden" name="type_serv2" id="d2" class="form-control" value="0" />
                            </div>
                            <label class="col-sm-3 control-label">Емкость (Mbps):</label>
                            <div class="col-sm-9">
                                <input type="text" name="speed" id="e" class="form-control" value="" />
                            </div>
                            <label class="col-sm-3 control-label">CID канала:</label>
                            <div class="col-sm-9">
                                <input type="text" name="cid" id="f" class="form-control" value="" />
                            </div>
                            <label class="col-sm-3 control-label">Трасса для расчета схемы:</label>
                            <div class="col-sm-9">
                                <input type="text" name="rasch_track" id="g" class="form-control" value="" />
                            </div>
                            <label class="col-sm-3 control-label">Трасс по сети:</label>
                            <div class="col-sm-9">
                                <textarea  rows="3" name="track" id="h" class="form-control"></textarea>
                            </div>
                            <label class="col-sm-3 control-label">Приоритет:</label>
                            <div class="col-sm-9">
                                <select name="priority1" id="i1" onchange="javascript:selectPriority();" class="form-control">
                                    <?php
                                    echo '<option value="0">0</option>';
                                    echo '<option value="1" selected>1</option>';
                                    echo '<option value="2">2</option>';
                                    ?>
                                </select>
                                <input type="hidden" name="priority2" id="i2" class="form-control" value="1" />
                            </div>
                            <label class="col-sm-3 control-label">ID в планере:</label>
                            <div class="col-sm-9">
                                <input type="text" name="planer" id="j" class="form-control" value="0" />
                            </div>
                            <label class="col-sm-3 control-label">Принят в эксплуатацию:</label>
                            <div class="col-sm-9">
                                <input type="date" name="date_in" id="k" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
                            </div>
                            <label class="col-sm-3 control-label">Выведен из эксплуатации:</label>
                            <div class="col-sm-9">
                                <input type="text" name="date_out" id="l" class="form-control" value="" />
                            </div>
                            <label class="col-sm-3 control-label">Особенности приема:</label>
                            <div class="col-sm-9">
                                <input type="text" name="in_out" id="m" class="form-control" value="" />
                            </div>
                            <label class="col-sm-3 control-label">Статус клиента:</label>
                            <div class="col-sm-9">
                                <input type="text" name="status1" id="n1" class="form-control" value="в эксплуатации" />
                                <input type="hidden" name="status2" id="n2" class="form-control" value="2" />
                            </div>
                            <label class="col-sm-3 control-label">Retail-клиент:</label>
                            <div class="col-sm-9">
                                <select name="retail1" id="o1" onchange="javascript:selectRetail();" class="form-control">
                                    <?php
                                    echo '<option value="0">НЕТ</option>';
                                    echo '<option value="1">ДА</option>';
                                    ?>
                                </select>
                                <input type="hidden" name="retail2" id="o2" class="form-control" value="0" />
                            </div>
                            <label class="col-sm-3 control-label">SLA:</label>
                            <div class="col-sm-9">
                                <select name="sla1" id="p1" onchange="javascript:selectSLA();" class="form-control">
                                    <?php
                                    $sql = 'SELECT CONCAT(name," (",lbl,")") AS slnm, id FROM tab_sla_net_data ORDER BY id';
                                    $res = mysqli_query($mysqli, $sql);
                                    echo '<option value="0"></option>';
                                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                        echo '<option value="'.$row['id'].'">'.$row['slnm'].'</option>';
                                    };
                                    ?>
                                </select>
                                <input type="hidden" name="sla2" id="p2" class="form-control" value="0" />
                            </div>
                            <label class="col-sm-3 control-label">Примечание:</label>
                            <div class="col-sm-9">
                                <input type="text" name="note" id="r" class="form-control" value="" />
                            </div>
                        </div>
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
    <script src="sk.main.add.js"></script>
<?php }; ?>
</body>
</html>