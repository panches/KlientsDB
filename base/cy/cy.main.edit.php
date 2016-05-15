<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location: ../../index.html");
} else {
    ini_set('default_charset',"UTF-8");
    if (!isset($_GET['cy_id'])) {
        header("location: ../../includes/info.error.php");
    } else {
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
        //present data
        $sql = 'SELECT e.id_equip,n.net,e.ip_address,e.name_nms,concat_WS(" ",t.town,i.address) as addr,concat_WS(" ",b.brend,b.model) as brend_model,
                e.status_d,e.planerid,e.num_equip,e.linkage,e.num_node,e.net as net_d,e.scheme,e.num_ver,e.in_exp,e.out_exp,e.inexpl,st.name AS st_name
                FROM klients.net_equip e, klients.tblinform2 i, klients.tab_town t, tab_nets n,tab_equip b, tab_status st
                WHERE e.linkage="0" AND e.num_node=i.inv_id AND i.town_id=t.id AND e.net=n.id AND e.num_equip=b.id AND st.id=e.status_d AND e.id_equip='.$_GET['cy_id'].'
                UNION ALL
                SELECT e.id_equip,n.net,e.ip_address,e.name_nms,concat_WS(" ",k.client,o.street) as addr,concat_WS(" ",b.brend,b.model) as brend_model,
                e.status_d,e.planerid,e.num_equip,e.linkage,e.num_node,e.net as net_d,e.scheme,e.num_ver,e.in_exp,e.out_exp,e.inexpl,st.name AS st_name
                FROM klients.net_equip e, klients.office_kli o, klients.tab_klients k, tab_nets n, tab_equip b, tab_status st
                WHERE e.linkage="1" AND e.num_node=o.id_kli AND o.klient=k.id AND e.net=n.id AND e.num_equip=b.id AND st.id=e.status_d AND e.id_equip='.$_GET['cy_id'];
        $res = mysqli_query($mysqli, $sql) or die("ERROR: ".mysql_error());
        $equip = mysqli_fetch_assoc($res);
        ?>

        <div id="rootwizard">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container">
                        <ul>
                            <li><a href="#tab1" data-toggle="tab">1.Устройство</a></li>
                            <li><a href="#tab2" data-toggle="tab">2.Свойства</a></li>
                            <li><a href="#tab3" data-toggle="tab">3.Все Поля</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane" id="tab1">
                    <div  class="container">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">из справочника:</label>
                            <div class="col-sm-10">
                                <select name="equip" id="equip" onchange="javascript:selectEquip();" class="form-control">
                                    <?php
                                    $sql = 'SELECT id,brend,model FROM tab_equip ORDER BY brend,model';
                                    $res = mysqli_query($mysqli, $sql);
                                    echo '<option value="0"></option>';
                                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                        if($equip['num_equip'] == $row['id']){
                                            echo '<option value="'.$row['id'].'" selected>'.$row['brend'].' '.$row['model'].'</option>';
                                        } else {
                                            echo '<option value="' . $row['id'] . '">' . $row['brend'] . ' ' . $row['model'] . '</option>';
                                        }
                                    };
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">размещено:</label>
                            <div class="col-sm-10">
                                <select name="locat" id="locat" onchange="javascript:selectLocat();" class="form-control">
                                    <?php
                                    if($equip['linkage'] == 0){
                                        echo '<option value="0" selected>узел</option>';
                                    } else {
                                        echo '<option value="0">узел</option>';
                                    };
                                    if($equip['linkage'] == 1){
                                        echo '<option value="1" selected>офис</option>';
                                    } else {
                                        echo '<option value="1">офис</option>';
                                    };
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- узел -->
                        <div id="varnode">
                            <label for="node">Подвязан к узлу:</label>
                            <table id="node" class="display cell-border compact" cellspacing="0" width="100%"></table>
                            <div id="node_show"><font color="red"><?php echo $equip['addr']; ?></font></div><br>
                        </div>
                        <!-- офис -->
                        <div id="varoffice">
                            <label for="office">Подвязан к офису:</label>
                            <table id="office" class="display cell-border compact" cellspacing="0" width="100%"></table>
                            <div id="office_show"><font color="red"><?php echo $equip['addr']; ?></font></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab2">
                    <div  class="container">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Тип сети:</label>
                            <div class="col-sm-10">
                                <select name="nets" id="nets" onchange="javascript:selectNet();" class="form-control">
                                    <option value="0"></option>
                                    <?php
                                    $sql = 'SELECT id,net FROM tab_nets ORDER BY id';
                                    $res = mysqli_query($mysqli, $sql);
                                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                        if($equip['net_d'] == $row['id']){
                                            echo '<option value="'.$row['id'].'" selected>'.$row['net'].'</option>';
                                        } else {
                                            echo '<option value="' . $row['id'] . '">' . $row['net'] . '</option>';
                                        }
                                    };
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Статус соединения:</label>
                            <div class="col-sm-10">
                                <select name="status_equip" id="status_equip" onchange="javascript:selectStatus();" class="form-control" >
                                    <option value="0"></option>
                                    <?php
                                    $sql = 'SELECT id,name FROM tab_status ORDER BY id';
                                    $res = mysqli_query($mysqli, $sql);
                                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                        if($equip['status_d'] == $row['id']){
                                            echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
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
                        <form id="formadd" method="post" action="cy.main.edit.sql.php">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Тип сети:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="type_net" id="a1" class="form-control" value="<?php echo $equip['net']; ?>" />
                                    <input type="hidden" name="type_net2" id="a2" class="form-control" value="<?php echo $equip['net_d']; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">IP адрес:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="ipaddr" id="b" class="form-control" value="<?php echo $equip['ip_address']; ?>" />
                                </div>
                            </div>
                            <legend>Устройство</legend>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">в NMS:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nms" id="c" class="form-control" value="<?php echo $equip['name_nms']; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">из справочника:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="fromlist" id="d1" class="form-control" value="<?php echo $equip['brend_model']; ?>" />
                                    <input type="hidden" name="fromlist2" id="d2" class="form-control" value="<?php echo $equip['num_equip']; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">размещено:</label>
                                <div class="col-sm-9">
                                    <?php
                                    if($equip['linkage'] == 0){ $location = 'узел'; $location2 = 0; }
                                    else { $location = 'офис'; $location2 = 1; }
                                    ?>
                                    <input type="text" name="location" id="e1" class="form-control" value="<?php echo $location ?>" />
                                    <input type="hidden" name="location2" id="e2" class="form-control" value="<?php echo $location2 ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">подвязан:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="attach" id="f1" class="form-control" value="<?php echo $equip['addr']; ?>" />
                                    <input type="hidden" name="attach2" id="f2" class="form-control" value="<?php echo $equip['num_node']; ?>" />
                                </div>
                            </div>
                            <legend></legend>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Схема канала:</label>
                                <div class="col-sm-9">
                                    <textarea  rows="3" name="scheme" id="g" class="form-control"><?php echo $equip['scheme']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Номер версии ПО:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="version" id="h" class="form-control" value="<?php echo $equip['num_ver']; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Принят в эксплуатацию:</label>
                                <div class="col-sm-9">
                                    <?php
                                    echo '<input type="date" name="date_in" id="i" class="form-control" value="'.date("Y-m-d", strtotime($equip['in_exp'])).'" />';
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Выведен из эксплуатации:</label>
                                <div class="col-sm-9">
                                    <?php
                                    if(date("Y-m-d", strtotime($equip['out_exp'])) == '1970-01-01'){
                                        echo '<input type="date" name="date_out" id="j" class="form-control" value="" />';
                                    } else {
                                        echo '<input type="date" name="date_out" id="j" class="form-control" value="'.date("Y-m-d", strtotime($equip['out_exp'])).'" />';
                                    };
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Особенности приема:</label>
                                <div class="col-sm-9">
                                    <?php
                                    echo '<input type="text" name="in_out" id="l" class="form-control" value="'.$equip['inexpl'].'" />';
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Статус соединения:</label>
                                <div class="col-sm-9">
                                    <?php
                                    echo '<input type="text" name="status" id="m1" class="form-control" value="'.$equip['st_name'].'" />';
                                    echo '<input type="hidden" name="status2" id="m2" class="form-control" value="'.$equip['status_d'].'" />';
                                    ?>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">№ в планере:</label>
                                <div class="col-sm-9">
                                    <?php
                                    echo '<input type="text" name="planer" id="n" class="form-control" value="'.$equip['planerid'].'" />';
                                    ?>
                                </div>
                            </div>
                            <legend></legend>
                            <?php
                            echo '<input type="hidden" name="id_equip2" id="o2" class="form-control" value="' . $equip['id_equip'] . '" />';
                            ?>
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
        <script src="cy.main.edit.js"></script>
    </body>
    </html>
    <?php
    }
}; ?>
