<?php

    ini_set('default_charset',"UTF-8");

    require "constants.php";
    //Open database connection
    $mysqli = mysqli_connect($host,$user,$password,$db)
                or die("Ошибка " . mysqli_error($mysqli));

    switch ($_POST['action']){
        case "dogovor":
            echo '<select name="dogov" id="dogov" class="form-control" onchange="javascript:selectDogov();" >';
            $sql = 'SELECT d.id,d.dogovor,d.dt_dogovor FROM tab_klients k, z_connecttable z, tab_catal_dogovor d
                    WHERE k.id=z.tab_a_id AND z.tab_b_id=d.id AND k.id=' . $_POST['kli'];
            $res = mysqli_query($mysqli, $sql);
            echo '<option value="0"></option>';
            while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                $str = $row['dogovor'] . ' от ' . date("d.m.Y", strtotime($row['dt_dogovor']));
                echo '<option value="'.$row['id'].'">' . $str . '</option>';
            };
            echo '</select>';
            break;

        case "dopdogovor":
            echo '<select name="dopdogov" id="dopdogov" class="form-control" onchange="javascript:selectDopdogov();" >';
            $sql = 'SELECT dd.id,dd.dop_dogovor,dd.dt_dogovor_dop FROM tab_catal_dogovor d, tab_catal_dogovor_dop dd
                    WHERE d.id=dd.num_dogov AND d.id="'.$_POST['dogov'].'"
                    ORDER BY dd.dop_dogovor,dd.dt_dogovor_dop';
            $res = mysqli_query($mysqli, $sql);
            echo '<option value="0"></option>';
            while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                $str = $row['dop_dogovor'] . ' от ' . date("d.m.Y", strtotime($row['dt_dogovor_dop']));
                echo '<option value="'.$row['id'].'">' . $str . '</option>';
            };
            echo '</select>';
            break;

    };
    //Close database connection
    mysqli_close($mysqli);
?>