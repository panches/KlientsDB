<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location: ../../index.html");
} else {
    ini_set('default_charset',"UTF-8");
    if (!isset($_GET['ssy_id'])) {
        header("location: ../../includes/info.error.php");
    } else {
        require "../../includes/constants.php";
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8" />
            <title>Редактировать CCy</title>
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

        $sql = 'SELECT o.town_a, ta.town as atown, ta.country_id as acountry, ta.area_id as aregion, o.side_a,
                       o.town_b, tb.town as btown, tb.country_id as bcountry, tb.area_id as bregion, o.side_b,
                       o.operator, k.client, o.speed_d, o.contract_main_d, o.dop_dogovor_d, o.our_company,
                       o.num_tab, o.name_data, o.data_id, o.nameclient_id, o.condition_d, o.d_stServ_clientu,
                       o.num_canal, o.cost, o.status_d, s.name as status_name, o.plannerid, o.in_date,
                       o.podrazd, p.name_p, o.corp_retail, o.capex, o.for_what, t.name as name_sk, o.date_end,
                       o.tax_doc, o.sreda_peredachi, o.act_compl, o.acc_num, o.note
                FROM net_operators o
                LEFT JOIN tab_klients k ON o.operator=k.id
                LEFT JOIN tab_status s ON s.id=o.status_d
                LEFT JOIN tab_town ta ON ta.id=o.town_a
                LEFT JOIN tab_town tb ON tb.id=o.town_b
                LEFT JOIN tab_catal_podrazd p ON p.id=o.podrazd
                LEFT JOIN tab_katal_sk_type t ON t.id=o.for_what
                WHERE o.id_oper=' . $_GET['ssy_id'];
        $res = mysqli_query($mysqli, $sql);
        $oper = mysqli_fetch_assoc($res);
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
                                if ($oper['acountry'] == $row['id']) {
                                    echo '<option value="' . $row['id'] . '" selected="selected">' . $row['country'] . '</option>';
                                } else {
                                    echo '<option value="' . $row['id'] . '">' . $row['country'] . '</option>';
                                };
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
                                $sql = "SELECT id,region FROM tab_area WHERE country_id=" . $oper['acountry'] . " order by region";
                                $res = mysqli_query($mysqli, $sql);
                                echo '<option value="0"></option>';
                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                    if ($oper['aregion'] == $row['id']) {
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
                            <select name="townA" id="townA" class="form-control" onchange="javascript:selectTownA();" >
                                <?php
                                $sql = "SELECT id,town FROM tab_town WHERE country_id=" . $oper['acountry'] . " AND area_id=" . $oper['aregion'] . " order by town";
                                $res = mysqli_query($mysqli, $sql);
                                echo '<option value="0"></option>';
                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                    if ($oper['town_a'] == $row['id']) {
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
                <label class="col-sm-2 control-label">Улица:</label>
                <div class="col-sm-10">
                    <?php
                    $test = htmlentities($oper['side_a']);
                    $num=strpos($test, ",");
                    $str_a1=substr($test, 0, $num);
                    ?>
                    <input type="text" name="streetA" id="streetA" class="form-control" value="<?php echo $str_a1; ?>" onchange="javascript:changeStreetA();" />
                </div>
                <label class="col-sm-2 control-label">Дом:</label>
                <div class="col-sm-10">
                    <?php
                    $str_a2=trim(substr($test, $num+1, strlen($test)));
                    ?>
                    <input type="text" name="numA" id="numA" class="form-control" value="<?php echo $str_a2; ?>" onchange="javascript:changeNumA();" />
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
                                if ($oper['bcountry'] == $row['id']) {
                                    echo '<option value="' . $row['id'] . '" selected="selected">' . $row['country'] . '</option>';
                                } else {
                                    echo '<option value="' . $row['id'] . '">' . $row['country'] . '</option>';
                                };
                            };
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Область:</label>
                    <div class="col-sm-10">
                        <div  name="selectDataRegionB">
                            <select name="areaB" id="areaB" class="form-control" onchange="javascript:selectCityB();" >
                                <?php
                                $sql = "SELECT id,region FROM tab_area WHERE country_id=" . $oper['bcountry'] . " order by region";
                                $res = mysqli_query($mysqli, $sql);
                                echo '<option value="0"></option>';
                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                    if ($oper['bregion'] == $row['id']) {
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
                        <div  name="selectDataCityB">
                            <select name="townB" id="townB" class="form-control" onchange="javascript:selectTownB();">
                                <?php
                                $sql = "SELECT id,town FROM tab_town WHERE country_id=" . $oper['bcountry'] . " AND area_id=" . $oper['bregion'] . " order by town";
                                $res = mysqli_query($mysqli, $sql);
                                echo '<option value="0"></option>';
                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                    if ($oper['town_b'] == $row['id']) {
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
                <label class="col-sm-2 control-label">Улица:</label>
                <div class="col-sm-10">
                    <?php
                    $test = htmlentities($oper['side_b']);
                    $num=strpos($test, ",");
                    $str_b1=substr($test, 0, $num);
                    ?>
                    <input type="text" name="streetB" id="streetB" class="form-control" value="<?php echo $str_b1; ?>" onchange="javascript:changeStreetB();" />
                </div>
                <label class="col-sm-2 control-label">Дом:</label>
                <div class="col-sm-10">
                    <?php
                    $str_b2=trim(substr($test, $num+1, strlen($test)));
                    ?>
                    <input type="text" name="numB" id="numB" class="form-control" value="<?php echo $str_b2; ?>" onchange="javascript:changeNumB();" />
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
                                if ($oper['operator'] == $row['id']) {
                                    echo '<option value="' . $row['id'] . '" selected>' . $row['client'] . '</option>';
                                } else {
                                    echo '<option value="' . $row['id'] . '">' . $row['client'] . '</option>';
                                };
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
                            if ($oper['num_tab'] == 5) {
                                echo '<option value="5" selected>СС</option>';
                            } else {
                                echo '<option value="5">СС</option>';
                            };
                            if ($oper['num_tab'] == 6) {
                                echo '<option value="6" selected>ОК</option>';
                            } else {
                                echo '<option value="6">ОК</option>';
                            };
                            if ($oper['num_tab'] == 7) {
                                echo '<option value="7" selected>СК</option>';
                            } else {
                                echo '<option value="7">СК</option>';
                            };
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
                                echo '<option ';
                                if($row['id'] == $oper['nameclient_id']) echo " selected='selected' ";
                                echo 'value='.$row['id'].'>'.$row['client'].'</option>';
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
                                if($row['id'] == $oper['status_d']) echo " selected='selected' ";
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
                                echo '<option ';
                                if($row['id'] == $oper['podrazd']) echo " selected='selected' ";
                                echo 'value="'.$row['id'].'">'.$row['name_p'].'</option>';
                            };
                            ?>
                        </select>
                    </div>
                    <label class="col-sm-2 control-label">Признак:</label>
                    <div class="col-sm-10">
                        <select name="sign" id="sign" class="form-control" onchange="javascript:selectSign();" >
                            <?php
                            $sql = 'SELECT namedepartment FROM tab_catal_comm_dep ORDER BY id';
                            $res = mysqli_query($mysqli, $sql);
                            echo '<option value="0"></option>';
                            while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                echo '<option ';
                                if($row['namedepartment'] == $oper['corp_retail']) echo " selected='selected' ";
                                echo 'value="'.$row['namedepartment'].'">'.$row['namedepartment'].'</option>';
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
                                echo '<option ';
                                if($row['id'] == $oper['for_what']) echo " selected='selected' ";
                                echo 'value="'.$row['id'].'">'.$row['name'].'</option>';
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
                <form id="formadd" method="post" action="ssy.main.edit.sql.php">
                    <div class="form-group">
                        <legend>Точка А</legend>
                        <label class="col-sm-3 control-label">Город:</label>
                        <div class="col-sm-9">
                            <input type="text" name="townA1" id="aa1" class="form-control" value="<?php echo $oper['atown'] ?>" readonly />
                            <input type="hidden" name="townA2" id="aa2" class="form-control" value="<?php echo $oper['town_a'] ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Улица:</label>
                        <div class="col-sm-9">
                            <input type="text" name="areaA1" id="ab1" class="form-control" value="<?php echo $str_a1 ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Дом:</label>
                        <div class="col-sm-9">
                            <input type="text" name="numA1" id="ac1" class="form-control" value="<?php echo $str_a2 ?>" />
                        </div>
                        <legend>Точка Б</legend>
                        <label class="col-sm-3 control-label">Город:</label>
                        <div class="col-sm-9">
                            <input type="text" name="townB1" id="ba1" class="form-control" value="<?php echo $oper['btown'] ?>" readonly />
                            <input type="hidden" name="townB2" id="ba2" class="form-control" value="<?php echo $oper['town_b'] ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Улица:</label>
                        <div class="col-sm-9">
                            <input type="text" name="areaB1" id="bb1" class="form-control" value="<?php echo $str_b1 ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Дом:</label>
                        <div class="col-sm-9">
                            <input type="text" name="numB1" id="bc1" class="form-control" value="<?php echo $str_b2 ?>" />
                        </div>
                        <legend>Оператор</legend>
                        <label class="col-sm-3 control-label">Оператор:</label>
                        <div class="col-sm-9">
                            <input type="text" name="oper1" id="с1" class="form-control" value="<?php echo $oper['client'] ?>" readonly />
                            <input type="hidden" name="oper2" id="с2" class="form-control" value="<?php echo $oper['operator'] ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Скорость:</label>
                        <div class="col-sm-9">
                            <input type="text" name="speed" id="c3" class="form-control" value="<?php echo $oper['speed_d'] ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Договор:</label>
                        <div class="col-sm-9">
                            <div  name="dogovor">
                                <select name="dogov" id="dogov" class="form-control" onchange="javascript:selectDogov();" >
                                    <?php
                                    $sql = 'SELECT d.id,d.dogovor,d.dt_dogovor FROM tab_klients k, z_connecttable z, tab_catal_dogovor d
                                    WHERE k.id=z.tab_a_id AND z.tab_b_id=d.id AND k.id=' . $oper['operator'];
                                    $res = mysqli_query($mysqli, $sql);
                                    echo '<option value="0"></option>';
                                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                        if ($oper['contract_main_d'] == $row['id']) {
                                            $str = $row['dogovor'] . ' от ' . date("d.m.Y", strtotime($row['dt_dogovor']));
                                            echo '<option value="'.$row['id'].'" selected>' . $str . '</option>';
                                        } else {
                                            $str = $row['dogovor'] . ' от ' . date("d.m.Y", strtotime($row['dt_dogovor']));
                                            echo '<option value="'.$row['id'].'">' . $str . '</option>';
                                        };
                                    };
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="dogov2" id="сa2" class="form-control" value="<?php echo $oper['contract_main_d']; ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Доп.Договор:</label>
                        <div class="col-sm-9">
                            <div  name="dopdogovor">
                                <select name="dopdogov" id="dopdogov" class="form-control" onchange="javascript:selectDopdogov();" >
                                    <?php
                                    $sql = 'SELECT dd.id,dd.dop_dogovor,dd.dt_dogovor_dop FROM tab_catal_dogovor d, tab_catal_dogovor_dop dd
                                            WHERE d.id=dd.num_dogov AND d.id="'.$oper['contract_main_d'].'"
                                            ORDER BY dd.dop_dogovor,dd.dt_dogovor_dop';
                                    $res = mysqli_query($mysqli, $sql);
                                    echo '<option value="0"></option>';
                                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                        if ($oper['dop_dogovor_d'] == $row['id']) {
                                            $str = $row['dop_dogovor'] . ' от ' . date("d.m.Y", strtotime($row['dt_dogovor_dop']));
                                            echo '<option value="'.$row['id'].'" selected>' . $str . '</option>';
                                        } else {
                                            $str = $row['dop_dogovor'] . ' от ' . date("d.m.Y", strtotime($row['dt_dogovor_dop']));
                                            echo '<option value="'.$row['id'].'">' . $str . '</option>';
                                        };
                                    };
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="dopdogov2" id="сb2" class="form-control" value="<?php echo $oper['dop_dogovor_d']; ?>" />
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
                                    if($row['id_our'] == $oper['our_company']) echo " selected='selected' ";
                                    echo 'value='.$row['id_our'].'>'.$row['name_our'].'</option>';
                                };
                                ?>
                            </select>
                            <input type="hidden" name="DogovIn2" id="cc2" class="form-control" value="<?php echo $oper['our_company']; ?>" />
                        </div>
                        <legend>Подвязать</legend>
                        <label class="col-sm-3 control-label">База:</label>
                        <div class="col-sm-9">
                            <?php
                            switch ($oper['num_tab']){
                                case 5 : $base1='СС';
                                            break;
                                case 6 : $base1='ОК';
                                            break;
                                case 7 : $base1='СК';
                                            break;
                            };
                            ?>
                            <input type="text" name="base1" id="d1" class="form-control" value="<?php echo $base1; ?>" readonly />
                            <input type="hidden" name="base2" id="d2" class="form-control" value="<?php echo $oper['num_tab']; ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Название:</label>
                        <div class="col-sm-9">
                            <input type="text" name="title1" id="e1" class="form-control" value="<?php echo $oper['name_data']; ?>" readonly />
                            <input type="hidden" name="title2" id="e2" class="form-control" value="<?php echo $oper['data_id']; ?>" />
                        </div>
                        <legend>Клиент</legend>
                        <label class="col-sm-3 control-label">Название клиента:</label>
                        <div class="col-sm-9">
                            <?php
                                $sql = 'SELECT client FROM tab_klients WHERE id=' . $oper['nameclient_id'];
                                $res = mysqli_query($mysqli, $sql);
                                $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
                                $kli1=$row['client'];
                            ?>
                            <input type="text" name="kli1" id="f1" class="form-control" value="<?php echo $kli1; ?>" readonly />
                            <input type="hidden" name="kli2" id="f2" class="form-control" value="<?php echo $oper['nameclient_id']; ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Дата включения:</label>
                        <div class="col-sm-9">
                            <?php
                            if(date("Y-m-d", strtotime($oper['condition_d'])) == '1970-01-01'){
                                echo '<input type="date" name="date_in" id="g" class="form-control" value="" />';
                            } else {
                                echo '<input type="date" name="date_in" id="g" class="form-control" value="'.date("Y-m-d", strtotime($oper['condition_d'])).'" />';
                            };
                            ?>
                        </div>
                        <label class="col-sm-3 control-label">Дата подачи услуги:</label>
                        <div class="col-sm-9">
                            <?php
                            if(date("Y-m-d", strtotime($oper['d_stServ_clientu'])) == '1970-01-01'){
                                echo '<input type="date" name="date_in_work" id="h" class="form-control" value="" />';
                            } else {
                                echo '<input type="date" name="date_in_work" id="h" class="form-control" value="'.date("Y-m-d", strtotime($oper['d_stServ_clientu'])).'" />';
                            };
                            ?>
                        </div>
                        <label class="col-sm-3 control-label">№ канала:</label>
                        <div class="col-sm-9">
                            <input type="text" name="chanel" id="i" class="form-control" value="<?php echo $oper['num_canal']; ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Стоимость:</label>
                        <div class="col-sm-9">
                            <input type="text" name="cost" id="j" class="form-control" value="<?php echo $oper['cost']; ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Статус:</label>
                        <div class="col-sm-9">
                            <input type="text" name="status1" id="t1" class="form-control" value="<?php echo $oper['status_name']; ?>" readonly />
                            <input type="hidden" name="status2" id="t2" class="form-control" value="<?php echo $oper['status_d']; ?>" />
                        </div>
                        <label class="col-sm-3 control-label">ID в планере:</label>
                        <div class="col-sm-9">
                            <input type="text" name="planer" id="k" class="form-control" value="<?php echo $oper['plannerid']; ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Дата постановки задачи:</label>
                        <div class="col-sm-9">
                            <?php
                            if(date("Y-m-d", strtotime($oper['in_date'])) == '1970-01-01'){
                                echo '<input type="date" name="date_in_task" id="l" class="form-control" value="" />';
                            } else {
                                echo '<input type="date" name="date_in_task" id="l" class="form-control" value="'.date("Y-m-d", strtotime($oper['in_date'])).'" />';
                            };
                            ?>
                        </div>
                        <label class="col-sm-3 control-label">Подразделение:</label>
                        <div class="col-sm-9">
                            <input type="text" name="subunit1" id="m1" class="form-control" value="<?php echo $oper['name_p']; ?>" readonly />
                            <input type="hidden" name="subunit2" id="m2" class="form-control" value="<?php echo $oper['podrazd']; ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Признак:</label>
                        <div class="col-sm-9">
                            <input type="text" name="sign1" id="n1" class="form-control" value="<?php echo $oper['corp_retail']; ?>" readonly />
                            <input type="hidden" name="sign2" id="n2" class="form-control" value="<?php echo $oper['corp_retail']; ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Стоимость включения:</label>
                        <div class="col-sm-9">
                            <input type="text" name="cost_in" id="o" class="form-control" value="<?php echo $oper['capex']; ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Тип услуги:</label>
                        <div class="col-sm-9">
                            <input type="text" name="service_type1" id="p1" class="form-control" value="<?php echo $oper['name_sk']; ?>" readonly />
                            <input type="hidden" name="service_type2" id="p2" class="form-control" value="<?php echo $oper['for_what']; ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Дата отключения:</label>
                        <div class="col-sm-9">
                            <?php
                            if(date("Y-m-d", strtotime($oper['date_end'])) == '1970-01-01'){
                                echo '<input type="date" name="date_out" id="q" class="form-control" value="" />';
                            } else {
                                echo '<input type="date" name="date_out" id="q" class="form-control" value="'.date("Y-m-d", strtotime($oper['date_end'])).'" />';
                            };
                            ?>
                        </div>
                        <label class="col-sm-3 control-label">Налоговая накладная:</label>
                        <div class="col-sm-9">
                            <input type="text" name="tax_bill" id="r" class="form-control" value="<?php echo $oper['tax_doc']; ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Аренда услуги:</label>
                        <div class="col-sm-9">
                            <select name="rent_service1" id="s1" onchange="javascript:selectRent();" class="form-control">
                                <?php
                                $sql = 'SELECT id,name_sredi FROM tab_catal_sreda_peredachi ORDER BY id';
                                $res = mysqli_query($mysqli, $sql);
                                echo '<option value="0"></option>';
                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                    echo '<option ';
                                    if($row['id'] == $oper['sreda_peredachi']) echo " selected='selected' ";
                                    echo 'value="'.$row['id'].'">'.$row['name_sredi'].'</option>';
                                };
                                ?>
                            </select>
                            <input type="hidden" name="rent_service2" id="s2" class="form-control" value="<?php echo $oper['sreda_peredachi']; ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Акт выполненных работ:</label>
                        <div class="col-sm-9">
                            <input type="text" name="act" id="u" class="form-control" value="<?php echo $oper['act_compl']; ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Номер счета:</label>
                        <div class="col-sm-9">
                            <input type="text" name="bill" id="v" class="form-control" value="<?php echo $oper['acc_num']; ?>" />
                        </div>
                        <label class="col-sm-3 control-label">Примечание:</label>
                        <div class="col-sm-9">
                            <input type="text" name="note" id="w" class="form-control" value="<?php echo $oper['note']; ?>" />
                        </div>
                        <input type="hidden" name="ssy_id" id="x" class="form-control" value="<?php echo $_GET['ssy_id']; ?>" />;
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
        <script src="ssy.main.edit.js"></script>
        </body>
        </html>
<?php
    }
}; ?>