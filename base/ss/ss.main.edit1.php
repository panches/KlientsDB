<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location: ../../index.html");
};
ini_set('default_charset',"UTF-8");
if (!isset($_GET['ss_id'])) {
    header("location: ../../includes/info.error.php");
};
require "../../includes/constants.php"; //Open database connection
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>Изменить Сетевое Соединение</title>
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

    $sql = 'SELECT *,
             eq1.id_equip AS eq1id,eq1.name_nms AS eq1name,
             eq2.id_equip AS eq2id,eq2.name_nms AS eq2name,
             st.name AS st_name
            FROM net_links link
            LEFT JOIN net_equip eq1 ON eq1.id_equip=link.equip_a
            LEFT JOIN net_equip eq2 ON eq2.id_equip=link.equip_b
            LEFT JOIN tab_status st ON st.id=link.status_d
            WHERE id_link='.$_GET['ss_id'];
    $res = mysqli_query($mysqli, $sql);
    $link = mysqli_fetch_array($res, MYSQLI_ASSOC);
?>

<div id="rootwizard">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <ul>
                    <li><a href="#tab1" data-toggle="tab">1.Выбор устройств</a></li>
                    <li><a href="#tab2" data-toggle="tab">2.Статус соединения</a></li>
                    <li><a href="#tab3" data-toggle="tab">3.Все данные</a></li>
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
                                if ($link['sign_net'] == $row['net'] ) {
                                    echo '<option value="' . $row['id'] . '" selected>' . $row['net'] . '</option>';
                                } else {
                                    echo '<option value="' . $row['id'] . '">' . $row['net'] . '</option>';
                                }
                            };
                            ?>
                        </select>
                    </div>
                </div>  <br>
                <!-- Устройство А -->
                <label for="equipA">Устройство А:</label>
                <table id="equipA" class="display cell-border compact" cellspacing="0" width="100%"></table>
                <?php
                echo '<div id="eqa_show"><font color="red">'.$link['eq1name'].'</font></div><br>';
                ?>
                <!-- Устройство Б -->
                <label for="equipB">Устройство Б:</label>
                <table id="equipB" class="display cell-border compact" cellspacing="0" width="100%"></table>
                <?php
                echo '<div id="eqb_show"><font color="red">'.$link['eq2name'].'</font></div><br>';
                ?>
            </div>
        </div>
        <div class="tab-pane" id="tab2">
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
                                if ($link['st_name'] == $row['name']) {
                                    echo '<option value="' . $row['id'] . '" selected>' . $row['name'] . '</option>';
                                } else {
                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                }
                            };
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab3">
            <div  class="container">
                <!-- Форма Остальные данные -->
                <form id="formadd" method="post" action="ss.main.edit.sql.php">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Тип сети:</label>
                        <div class="col-sm-9">
                            <?php
                            echo '<input type="text" name="type_net" id="a1" class="form-control" value="'.$link['sign_net'].'" />';
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Устройство А:</label>
                        <div class="col-sm-9">
                            <?php
                            echo '<input type="text" name="equip_a" id="b1" class="form-control" value="'.$link['eq1name'].'" />';
                            echo '<input type="hidden" name="equip_a2" id="b2" class="form-control" value="'.$link['eq1id'].'" />';
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Порт А:</label>
                        <div class="col-sm-9">
                            <?php
                            echo '<input type="text" name="port_a" id="c" class="form-control" value="'.$link['port_a'].'" />';
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Устройство Б:</label>
                        <div class="col-sm-9">
                            <?php
                            echo '<input type="text" name="equip_b" id="d1" class="form-control" value="'.$link['eq2name'].'" />';
                            echo '<input type="hidden" name="equip_b2" id="d2" class="form-control" value="'.$link['eq2id'].'" />';
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Порт Б:</label>
                        <div class="col-sm-9">
                            <?php
                            echo '<input type="text" name="port_b" id="e" class="form-control" value="'.$link['port_b'].'" />';
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Пропускная способность (Мбит/с):</label>
                        <div class="col-sm-9">
                            <?php
                            echo '<input type="text" name="speed" id="f" class="form-control" value="'.$link['pass'].'" />';
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Схема:</label>
                        <div class="col-sm-9">
                            <?php
                            echo '<textarea  rows="3" name="scheme" id="g" class="form-control">'.$link['scheme'].'</textarea>';
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Принят в эксплуатацию:</label>
                        <div class="col-sm-9">
                            <?php
                            echo '<input type="date" name="date_in" id="i" class="form-control" value="'.date("Y-m-d", strtotime($link['in_exp'])).'" />';
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Выведен из эксплуатации:</label>
                        <div class="col-sm-9">
                            <?php
                            echo '<input type="date" name="date_out" id="j" class="form-control" value="'.date("Y-m-d", strtotime($link['out_exp'])).'" />';
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Особенности приема:</label>
                        <div class="col-sm-9">
                            <?php
                            echo '<input type="text" name="in_out" id="l" class="form-control" value="'.$link['inexp'].'" />';
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Статус соединения:</label>
                        <div class="col-sm-9">
                            <?php
                            echo '<input type="text" name="status" id="m1" class="form-control" value="'.$link['st_name'].'" />';
                            echo '<input type="hidden" name="status2" id="m2" class="form-control" value="'.$link['status_d'].'" />';
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Признак соединения:</label>
                        <div class="col-sm-9">
                            <input type="text" name="sign" id="n" class="form-control" value="сетевое" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">№ в планере:</label>
                        <div class="col-sm-9">
                            <?php
                            echo '<input type="text" name="planer" id="o" class="form-control" value="'.$link['planerid'].'" />';
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Примечание:</label>
                        <div class="col-sm-9">
                            <?php
                            echo '<textarea  rows="3" name="note" id="p" class="form-control">'.$link['note'].'</textarea>';
                            ?>
                        </div>
                    </div>
                    <?php
                    echo '<input type="hidden" name="id_link2" id="r2" class="form-control" value="'.$link['id_link'].'" />';
                    ?>
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
<script src="ss.main.add1.js"></script>
<script>
$(function() {
// найти все записи в таблицах, которые содержат выбранный тип сети
    $("#equipA").dataTable().api().search("<?php echo $link['sign_net'] ?>").draw();
    $("#equipB").dataTable().api().search("<?php echo $link['sign_net'] ?>").draw();
});
</script>
</body>
</html>    