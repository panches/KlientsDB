<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location: ../../index.html");
} else {
    ini_set('default_charset',"UTF-8");
    if (!isset($_GET['ok_id'])) {
        header("location: ../../includes/info.error.php");
    } else {
        require "../../includes/constants.php";
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Редактировать Сетевое Устройство</title>
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
    //present data
    $sql = 'select o.id_kli, o.klient, o.country_id, o.area_id, o.town_id, o.street, o.kont_tel, o.kont_email, o.device, o.device_id, o.port, o.CID_1, o.CID_2, o.CID_3, o.CID_4, o.CID_5,
            o.chart_joint, o.chart_joint_nc, o.office, o.speed, o.equip, o.planerid, o.retail, o.inexp, o.status_d, o.note, o.in_exp, o.out_exp, k.client, k.key_word, k.class, t.town, c.country, a.region, s.name
            from office_kli o, tab_klients k, tab_town t, tab_country c, tab_area a, tab_status s
            where o.klient = k.id and t.id=o.town_id and o.country_id=c.id and o.area_id=a.id and o.status_d=s.id AND o.id_kli=' . $_GET['ok_id'];
    $res = mysqli_query($mysqli, $sql) or die("ERROR: " . mysql_error());
    $office = mysqli_fetch_assoc($res);
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
                        if($row['id'] == $office['klient']) {
                            echo '<option value="'.$row['id'].'" selected>'.$row['client'].'</option>';
                        } else {
                            echo '<option value="'.$row['id'].'">'.$row['client'].'</option>';
                        };
                    };
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Страна:</label>
            <div class="col-sm-10">
                <select name="countryA" id="countryA" class="form-control" onchange="javascript:selectRegionA();">
                    <?php
                    $sql = 'SELECT id,country FROM tab_country ORDER BY id';
                    $res = mysqli_query($mysqli, $sql);
                    echo '<option value="0"></option>';
                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                        if($row['id'] == $office['country_id']) {
                            echo '<option value="'.$row['id'].'" selected>'.$row['country'].'</option>';
                        } else {
                            echo '<option value="' . $row['id'] . '">' . $row['country'] . '</option>';
                        }
                    };
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Область:</label>
            <div class="col-sm-10">
                <div  name="selectDataRegionA">
                    <select name="areaA" id="areaA" class="form-control" onchange="javascript:selectCityA();" >
                        <?php
                        $sql = "SELECT id,region FROM tab_area WHERE country_id=" . $office['country_id'] . " order by region";
                        $res = mysqli_query($mysqli, $sql);
                        echo '<option value="0"></option>';
                        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                            if ($office['area_id'] == $row['id']) {
                                echo '<option value="' . $row['id'] . '" selected>' . $row['region'] . '</option>';
                            } else {
                                echo '<option value="' . $row['id'] . '">' . $row['region'] . '</option>';
                            };
                        };
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Город:</label>
            <div class="col-sm-10">
                <div  name="selectDataCityA">
                    <select name="townA" id="townA" class="form-control" onchange="javascript:selectTownA();">
                        <?php
                        $sql = "SELECT id,town FROM tab_town WHERE country_id=" . $office['country_id'] . " AND area_id=" . $office['area_id'] . " order by town";
                        $res = mysqli_query($mysqli, $sql);
                        echo '<option value="0"></option>';
                        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                            if ($office['town_id'] == $row['id']) {
                                echo '<option value="' . $row['id'] . '" selected>' . $row['town'] . '</option>';
                            } else {
                                echo '<option value="' . $row['id'] . '">' . $row['town'] . '</option>';
                            };
                        };
                        ?>
                    </select>
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
                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                        if ($office['status_d'] == $row['id']) {
                            echo '<option value="' . $row['id'] . '" selected>' . $row['name'] . '</option>';
                        } else {
                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                        }
                    };
                    ?>
                </select>
            </div>
        </div>
        <br><!-- сетевое устройство -->
        <label for="office">Подвязать к СУ:</label>
        <table id="equip" class="display cell-border compact" cellspacing="0" width="100%"></table>
        <div id="eq_show"><font color="red"><?php echo $office['device']; ?></font></div>
    </div>
</div>
<div class="tab-pane" id="tab2">
    <div  class="container">
        <!-- Форма Все поля -->
        <form id="formadd" method="post" action="ok.main.edit.sql.php">
            <div class="form-group">
                <label class="col-sm-3 control-label">Клиент:</label>
                <div class="col-sm-9">
                    <input type="text" name="kli1" id="a1" class="form-control" value="<?php echo $office['client']; ?>" readonly />
                    <input type="hidden" name="kli2" id="a2" class="form-control" value="<?php echo $office['klient']; ?>" />
                </div>
                <label class="col-sm-3 control-label">Страна:</label>
                <div class="col-sm-9">
                    <input type="text" name="country1" id="b1" class="form-control" value="<?php echo $office['country']; ?>" readonly />
                    <input type="hidden" name="country2" id="b2" class="form-control" value="<?php echo $office['country_id']; ?>" />
                </div>
                <label class="col-sm-3 control-label">Область:</label>
                <div class="col-sm-9">
                    <input type="text" name="area1" id="c1" class="form-control" value="<?php echo $office['region']; ?>" readonly />
                    <input type="hidden" name="area2" id="c2" class="form-control" value="<?php echo $office['area_id']; ?>" />
                </div>
                <label class="col-sm-3 control-label">Город:</label>
                <div class="col-sm-9">
                    <input type="text" name="town1" id="d1" class="form-control" value="<?php echo $office['town']; ?>" readonly />
                    <input type="hidden" name="town2" id="d2" class="form-control" value="<?php echo $office['town_id']; ?>" />
                </div>
                <label class="col-sm-3 control-label">Адрес:</label>
                <div class="col-sm-9">
                    <input type="text" name="addr" id="e" class="form-control" value="<?php echo $office['street']; ?>" />
                </div>
                <label class="col-sm-3 control-label">E-Mail:</label>
                <div class="col-sm-9">
                    <input type="text" name="email" id="f" class="form-control" value="<?php echo $office['kont_email']; ?>" />
                </div>
                <label class="col-sm-3 control-label">Контакт:</label>
                <div class="col-sm-9">
                    <input type="text" name="kontakt" id="g" class="form-control" value="<?php echo $office['kont_tel']; ?>" />
                </div>
                <label class="col-sm-3 control-label">Привязка к СУ на ТП:</label>
                <div class="col-sm-9">
                    <input type="text" name="office1" id="h1" class="form-control" value="<?php echo $office['device']; ?>" readonly />
                    <input type="hidden" name="office2" id="h2" class="form-control" value="<?php echo $office['device_id']; ?>" />
                </div>
                <label class="col-sm-3 control-label">Порт:</label>
                <div class="col-sm-9">
                    <input type="text" name="port" id="i" class="form-control" value="<?php echo $office['port']; ?>" />
                </div>
                <label class="col-sm-3 control-label">Retail-клиент:</label>
                <div class="col-sm-9">
                    <select name="retail1" id="j1" onchange="javascript:selectRetail();" class="form-control">
                        <?php
                        if($office['retail'] == 0){ $sel = ' selected'; } else { $sel = ''; };
                        echo '<option value="0" ' . $sel . '>НЕТ</option>';
                        if($office['retail'] == 1){ $sel = ' selected'; } else { $sel = ''; };
                        echo '<option value="1" ' . $sel . '>ДА</option>';
                        ?>
                    </select>
                    <input type="hidden" name="retail2" id="j2" class="form-control" value="<?php echo $office['retail']; ?>" />
                </div>
                <label class="col-sm-3 control-label">Техническая схема ПМ:</label>
                <div class="col-sm-9">
                    <textarea name="scheme_pm" id="k" class="form-control"><?php echo $office['chart_joint']; ?></textarea>
                </div>
                <label class="col-sm-3 control-label">"Последняя миля":</label>
                <div class="col-sm-9">
                    <select name="mile1" id="l1" onchange="javascript:selectMile();" class="form-control">
                        <?php
                        $sql = 'SELECT id,`last_mile` FROM tab_katal_last_mile ORDER BY `id`';
                        $res = mysqli_query($mysqli, $sql);
                        echo '<option value="0"></option>';
                        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                            if ($office['chart_joint_nc'] == $row['id']) {
                                echo '<option value="' . $row['id'] . '" selected>' . $row['last_mile'] . '</option>';
                            } else {
                                echo '<option value="' . $row['id'] . '">' . $row['last_mile'] . '</option>';
                            }
                        };
                        ?>
                    </select>
                    <input type="hidden" name="mile2" id="l2" class="form-control" value="<?php echo $office['chart_joint_nc']; ?>" />
                </div>
                <label class="col-sm-3 control-label">Скорость:</label>
                <div class="col-sm-9">
                    <input type="text" name="speed" id="m" class="form-control" value="<?php echo $office['speed']; ?>" />
                </div>
                <label class="col-sm-3 control-label">Оборудование у клиента:</label>
                <div class="col-sm-9">
                    <select name="device1" id="n1" onchange="javascript:selectDevice();" class="form-control">
                        <?php
                        $sql = 'SELECT id,nik FROM equipments2 ORDER BY nik';
                        $res = mysqli_query($mysqli, $sql);
                        echo '<option value="0"></option>';
                        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                            if ($office['equip'] == $row['id']) {
                                echo '<option value="' . $row['id'] . '" selected>' . $row['nik'] . '</option>';
                            } else {
                                echo '<option value="' . $row['id'] . '">' . $row['nik'] . '</option>';
                            }
                        };
                        ?>
                    </select>
                    <input type="hidden" name="device2" id="n2" class="form-control" value="<?php echo $office['equip']; ?>" />
                </div>
                <label class="col-sm-3 control-label">Принят в эксплуатацию:</label>
                <div class="col-sm-9">
                    <input type="date" name="date_in" id="o" class="form-control" value="<?php echo date("Y-m-d", strtotime($office['in_exp'])); ?>" />
                </div>
                <label class="col-sm-3 control-label">Выведен из эксплуатации:</label>
                <div class="col-sm-9">
                    <?php
                    if(date("Y-m-d", strtotime($office['out_exp'])) == '1970-01-01'){
                        echo '<input type="date" name="date_out" id="p" class="form-control" value="" />';
                    } else {
                        echo '<input type="date" name="date_out" id="p" class="form-control" value="'.date("Y-m-d", strtotime($office['out_exp'])).'" />';
                    };
                    ?>
                </div>
                <label class="col-sm-3 control-label">Особенности приема:</label>
                <div class="col-sm-9">
                    <input type="text" name="in_out" id="q" class="form-control" value="<?php echo $office['inexp']; ?>" />
                </div>
                <label class="col-sm-3 control-label">Статус офиса клиента:</label>
                <div class="col-sm-9">
                    <select name="status_office1" id="r1" onchange="javascript:selectStatOffice();" class="form-control">
                        <?php
                        $sql = 'SELECT id,name FROM tab_katal_office_status ORDER BY id';
                        $res = mysqli_query($mysqli, $sql);
                        echo '<option value="0"></option>';
                        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                            if ($office['office'] == $row['id']) { $sel=' selected'; } else { $sel=''; };
                            echo '<option value="'.$row['id'].'" '.$sel.'>'.$row['name'].'</option>';
                        };
                        ?>
                    </select>
                    <input type="hidden" name="status_office2" id="r2" class="form-control" value="<?php echo $office['office']; ?>" />
                </div>
                <label class="col-sm-3 control-label">№ в планере:</label>
                <div class="col-sm-9">
                    <input type="text" name="planer" id="s" class="form-control" value="<?php echo $office['planerid']; ?>" />
                </div>
                <label class="col-sm-3 control-label">Статус клиента:</label>
                <div class="col-sm-9">
                    <input type="text" name="status1" id="t1" class="form-control" value="<?php echo $office['name']; ?>" readonly />
                    <input type="hidden" name="status2" id="t2" class="form-control" value="<?php echo $office['status_d']; ?>" />
                </div>
                <label class="col-sm-3 control-label">Примечание:</label>
                <div class="col-sm-9">
                    <input type="text" name="note" id="u" class="form-control" value="<?php echo $office['note']; ?>" />
                </div>
                <input type="hidden" name="ok_id" id="w" class="form-control" value=" <?php echo $_GET['ok_id']; ?>" />;
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
<script src="../../js/jquery-1.12.4.min.js"></script>
<script src="../../js/jquery.dataTables.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/jquery.bootstrap.wizard.min.js"></script>
<script src="../../js/dataTables.bootstrap.min.js"></script>
<script src="../../js/jquery.bootstrap.wizard.min.js"></script>
<script src="../../js/jquery.validate.min.js"></script>
<!-- MyScript -->
<script src="ok.main.edit.js"></script>
<?php }
}; ?>
</body>
</html>