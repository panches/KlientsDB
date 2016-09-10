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
    <title>Добавить CCy</title>
    <link rel="stylesheet" href="../../css/jquery.dataTables.min.css" />
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
                <li><a href="#tab1" data-toggle="tab">1.Точка А</a></li>
                <li><a href="#tab2" data-toggle="tab">2.Точка Б</a></li>
                <li><a href="#tab3" data-toggle="tab">3.Оператор</a></li>
                <li><a href="#tab4" data-toggle="tab">4.Подвязать</a></li>
                <li><a href="#tab5" data-toggle="tab">5.Клиент</a></li>
                <li><a href="#tab6" data-toggle="tab">6.Все поля</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="tab-content">
<div class="tab-pane" id="tab1">
    <div  class="container">
        <div class="form-group">
            <label class="col-sm-2 control-label">Страна:</label>
            <div class="col-sm-10">
                <select name="countryA" id="countryA" class="form-control" onchange="javascript:selectRegionA();">
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
                <div  name="selectDataRegionA">
                    <select name="areaA" id="areaA" class="form-control" onchange="javascript:selectCityA();" ></select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Город:</label>
            <div class="col-sm-10">
                <div  name="selectDataCityA">
                    <select name="townA" id="townA" class="form-control" onchange="javascript:selectTownA();" ></select>
                </div>
            </div>
        </div>
        <label class="col-sm-2 control-label">Улица:</label>
        <div class="col-sm-10">
            <input type="text" name="streetA" id="streetA" class="form-control" value="" onchange="javascript:changeStreetA();" />
        </div>
        <label class="col-sm-2 control-label">Дом:</label>
        <div class="col-sm-10">
            <input type="text" name="numA" id="numA" class="form-control" value="" onchange="javascript:changeNumA();" />
        </div>
    </div>
</div>
<div class="tab-pane" id="tab2">
    <div  class="container">
        <div class="form-group">
            <label class="col-sm-2 control-label">Страна:</label>
            <div class="col-sm-10">
                <select name="countryB" id="countryB" class="form-control" onchange="javascript:selectRegionB();">
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
                <div  name="selectDataRegionB">
                    <select name="areaB" id="areaB" class="form-control" onchange="javascript:selectCityB();" ></select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Город:</label>
            <div class="col-sm-10">
                <div  name="selectDataCityB">
                    <select name="townB" id="townB" class="form-control" onchange="javascript:selectTownB();"></select>
                </div>
            </div>
        </div>
        <label class="col-sm-2 control-label">Улица:</label>
        <div class="col-sm-10">
            <input type="text" name="streetB" id="streetB" class="form-control" value="" onchange="javascript:changeStreetB();" />
        </div>
        <label class="col-sm-2 control-label">Дом:</label>
        <div class="col-sm-10">
            <input type="text" name="numB" id="numB" class="form-control" value="" onchange="javascript:changeNumB();" />
        </div>
    </div>
</div>
<div class="tab-pane" id="tab3">
    <div  class="container">
        <div class="form-group">
            <label class="col-sm-2 control-label">Оператор:</label>
            <div class="col-sm-10">
                <select name="oper" id="oper" class="form-control" onchange="javascript:selectOper();" >
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
    </div>
</div>
<div class="tab-pane" id="tab4">
    <div  class="container">
        <div class="form-group">
            <label class="col-sm-2 control-label">База:</label>
            <div class="col-sm-10">
                <select name="locat" id="locat" onchange="javascript:selectLocat();" class="form-control">
                    <?php
                    echo '<option value="5">СС</option>';
                    echo '<option value="6">ОК</option>';
                    echo '<option value="7">СК</option>';
                    ?>
                </select>
            </div>
        </div>
        <!-- соеддинение -->
        <div id="varlink">
            <label for="link">Название:</label>
            <table id="link" class="display cell-border compact" cellspacing="0" width="100%"></table>
            <div id="link_show"><font color="red"></font></div><br>
        </div>
        <!-- офис -->
        <div id="varoffice">
            <label for="office">Название:</label>
            <table id="office" class="display cell-border compact" cellspacing="0" width="100%"></table>
            <div id="office_show"><font color="red"></font></div>
        </div>
        <!-- сервис -->
        <div id="varservice">
            <label for="service">Название:</label>
            <table id="service" class="display cell-border compact" cellspacing="0" width="100%"></table>
            <div id="service_show"><font color="red"></font></div>
        </div>
    </div>
</div>
<div class="tab-pane" id="tab5">
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
            <label class="col-sm-2 control-label">Подразделение:</label>
            <div class="col-sm-10">
                <select name="subunit" id="subunit" class="form-control" onchange="javascript:selectSubunit();" >
                    <?php
                    $sql = 'SELECT id,name_p FROM tab_catal_podrazd ORDER BY id';
                    $res = mysqli_query($mysqli, $sql);
                    echo '<option value="0"></option>';
                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                        echo '<option value="'.$row['id'].'">'.$row['name_p'].'</option>';
                    };
                    ?>
                </select>
            </div>
            <label class="col-sm-2 control-label">Признак:</label>
            <div class="col-sm-10">
                <select name="sign" id="sign" class="form-control" onchange="javascript:selectSign();" >
                    <?php
                    $sql = 'SELECT id,namedepartment FROM tab_catal_comm_dep ORDER BY id';
                    $res = mysqli_query($mysqli, $sql);
                    echo '<option value="0"></option>';
                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                        echo '<option value="'.$row['id'].'">'.$row['namedepartment'].'</option>';
                    };
                    ?>
                </select>
            </div>
            <label class="col-sm-2 control-label">Тип услуги:</label>
            <div class="col-sm-10">
                <select name="service_type" id="service_type" class="form-control" onchange="javascript:selectService();" >
                    <?php
                    $sql = 'SELECT id,name FROM tab_katal_sk_type ORDER BY id';
                    $res = mysqli_query($mysqli, $sql);
                    echo '<option value="0"></option>';
                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                    };
                    ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane" id="tab6">
    <div  class="container">
        <!-- Форма Все поля -->
        <form id="formadd" method="post" action="ssy.main.add.sql.php">
            <div class="form-group">
                <legend>Точка А</legend>
                <label class="col-sm-3 control-label">Город:</label>
                <div class="col-sm-9">
                    <input type="text" name="townA1" id="aa1" class="form-control" value="" readonly />
                    <input type="hidden" name="townA2" id="aa2" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Улица:</label>
                <div class="col-sm-9">
                    <input type="text" name="areaA1" id="ab1" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Дом:</label>
                <div class="col-sm-9">
                    <input type="text" name="numA1" id="ac1" class="form-control" value="" />
                </div>
                <legend>Точка Б</legend>
                <label class="col-sm-3 control-label">Город:</label>
                <div class="col-sm-9">
                    <input type="text" name="townB1" id="ba1" class="form-control" value="" readonly />
                    <input type="hidden" name="townB2" id="ba2" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Улица:</label>
                <div class="col-sm-9">
                    <input type="text" name="areaB1" id="bb1" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Дом:</label>
                <div class="col-sm-9">
                    <input type="text" name="numB1" id="bc1" class="form-control" value="" />
                </div>
                <legend>Оператор</legend>
                <label class="col-sm-3 control-label">Оператор:</label>
                <div class="col-sm-9">
                    <input type="text" name="oper1" id="с1" class="form-control" value="" readonly />
                    <input type="hidden" name="oper2" id="с2" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Скорость:</label>
                <div class="col-sm-9">
                    <input type="text" name="speed" id="c3" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Договор:</label>
                <div class="col-sm-9">
                    <div  name="dogovor">
                        <select name="dogov" id="dogov" class="form-control" onchange="javascript:selectDogov();" ></select>
                    </div>
                    <input type="hidden" name="dogov2" id="сa2" class="form-control" value="0" />
                </div>
                <label class="col-sm-3 control-label">Доп.Договор:</label>
                <div class="col-sm-9">
                    <div  name="dopdogovor">
                        <select name="dopdogov" id="dopdogov" class="form-control" onchange="javascript:selectDopdogov();" ></select>
                    </div>
                    <input type="hidden" name="dopdogov2" id="сb2" class="form-control" value="0" />
                </div>
                <label class="col-sm-3 control-label">Договор оформлен на:</label>
                <div class="col-sm-9">
                    <select name="DogovIn1" id="cc1" onchange="javascript:selectDogovIn();" class="form-control">
                        <?php
                        $sql = 'SELECT id_our,name_our FROM tab_catal_our_company ORDER BY name_our';
                        $res = mysqli_query($mysqli, $sql);
                        echo '<option value="0"></option>';
                        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                            echo '<option ';
                            if($row['id_our'] == 1) echo " selected='selected' ";
                            echo 'value='.$row['id_our'].'>'.$row['name_our'].'</option>';
                        };
                        ?>
                    </select>
                    <input type="hidden" name="DogovIn2" id="cc2" class="form-control" value="1" />
                </div>
                <legend>Подвязать</legend>
                <label class="col-sm-3 control-label">База:</label>
                <div class="col-sm-9">
                    <input type="text" name="base1" id="d1" class="form-control" value="СС" readonly />
                    <input type="hidden" name="base2" id="d2" class="form-control" value="5" />
                </div>
                <label class="col-sm-3 control-label">Название:</label>
                <div class="col-sm-9">
                    <input type="text" name="title1" id="e1" class="form-control" value="" readonly />
                    <input type="hidden" name="title2" id="e2" class="form-control" value="" />
                </div>
                <legend>Клиент</legend>
                <label class="col-sm-3 control-label">Название клиента:</label>
                <div class="col-sm-9">
                    <input type="text" name="kli1" id="f1" class="form-control" value="" readonly />
                    <input type="hidden" name="kli2" id="f2" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Дата включения:</label>
                <div class="col-sm-9">
                    <input type="date" name="date_in" id="g" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Дата подачи услуги:</label>
                <div class="col-sm-9">
                    <input type="date" name="date_in_work" id="h" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">№ канала:</label>
                <div class="col-sm-9">
                    <input type="text" name="chanel" id="i" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Стоимость:</label>
                <div class="col-sm-9">
                    <input type="text" name="cost" id="j" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Статус:</label>
                <div class="col-sm-9">
                    <input type="text" name="status1" id="t1" class="form-control" value="в эксплуатации" readonly />
                    <input type="hidden" name="status2" id="t2" class="form-control" value="2" />
                </div>
                <label class="col-sm-3 control-label">ID в планере:</label>
                <div class="col-sm-9">
                    <input type="text" name="planer" id="k" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Дата постановки задачи:</label>
                <div class="col-sm-9">
                    <input type="date" name="date_in_task" id="l" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Подразделение:</label>
                <div class="col-sm-9">
                    <input type="text" name="subunit1" id="m1" class="form-control" value="" readonly />
                    <input type="hidden" name="subunit2" id="m2" class="form-control" value="0" />
                </div>
                <label class="col-sm-3 control-label">Признак:</label>
                <div class="col-sm-9">
                    <input type="text" name="sign1" id="n1" class="form-control" value="" readonly />
                    <input type="hidden" name="sign2" id="n2" class="form-control" value="0" />
                </div>
                <label class="col-sm-3 control-label">Стоимость включения:</label>
                <div class="col-sm-9">
                    <input type="text" name="cost_in" id="o" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Тип услуги:</label>
                <div class="col-sm-9">
                    <input type="text" name="service_type1" id="p1" class="form-control" value="" readonly />
                    <input type="hidden" name="service_type2" id="p2" class="form-control" value="0" />
                </div>
                <label class="col-sm-3 control-label">Дата отключения:</label>
                <div class="col-sm-9">
                    <input type="date" name="date_out" id="q" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Налоговая накладная:</label>
                <div class="col-sm-9">
                    <input type="text" name="tax_bill" id="r" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Аренда услуги:</label>
                <div class="col-sm-9">
                    <select name="rent_service1" id="s1" onchange="javascript:selectRent();" class="form-control">
                        <?php
                        $sql = 'SELECT id,name_sredi FROM tab_catal_sreda_peredachi ORDER BY id';
                        $res = mysqli_query($mysqli, $sql);
                        echo '<option value="0"></option>';
                        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                            echo '<option value="'.$row['id'].'">'.$row['name_sredi'].'</option>';
                        };
                        ?>
                    </select>
                    <input type="hidden" name="rent_service2" id="s2" class="form-control" value="0" />
                </div>
                <label class="col-sm-3 control-label">Акт выполненных работ:</label>
                <div class="col-sm-9">
                    <input type="text" name="act" id="u" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Номер счета:</label>
                <div class="col-sm-9">
                    <input type="text" name="bill" id="v" class="form-control" value="" />
                </div>
                <label class="col-sm-3 control-label">Примечание:</label>
                <div class="col-sm-9">
                    <input type="text" name="note" id="w" class="form-control" value="" />
                </div>
            <legend></legend>
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
<script src="../../js/jquery-1.12.4.min.js"></script>
<script src="../../js/jquery.dataTables.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/jquery.bootstrap.wizard.min.js"></script>
<script src="../../js/dataTables.bootstrap.min.js"></script>
<script src="../../js/jquery.bootstrap.wizard.min.js"></script>
<script src="../../js/jquery.validate.min.js"></script>
<!-- MyScript -->
<script src="ssy.main.add.js"></script>
<?php }; ?>
</body>
</html>