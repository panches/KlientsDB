<?php
header("Content-Type: text/html; charset=utf-8");
if (!isset($_POST['areaA1'])) {
    header("location: ../../includes/info.error.php");
} else {
    require "../../includes/constants.php";
    //Open database connection
    $mysqli = mysqli_connect($host, $user, $password, $db)
    or die("Ошибка " . mysqli_error($mysqli));
    // data from session
    session_start();
    $user_id = $_SESSION['session_userid'];
    $user_nik = htmlentities(mysqli_real_escape_string($mysqli, $_SESSION['session_username']));
    // поиск max(id_equip)
    $sql = 'select max(id_oper) as id from net_operators';
    $res = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($res);
    $str_n = (int)$row['id'] + 1;
    // insert data
    $townA2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['townA2']));
    $areaA1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['areaA1']));
    $numA1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['numA1']));
    $s_a = $areaA1 . ', ' . $numA1;
    $townB2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['townB2']));
    $areaB1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['areaB1']));
    $numB1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['numB1']));
    $s_b = $areaB1 . ', ' . $numB1;
    $speed  = htmlentities(mysqli_real_escape_string($mysqli, $_POST['speed']));
    $oper2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['oper2']));
    $title1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['title1']));
    $title2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['title2']));
    $base2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['base2']));
    $cost = htmlentities(mysqli_real_escape_string($mysqli, $_POST['cost']));
    $date_in = htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($_POST['date_in']))));
    $chanel = htmlentities(mysqli_real_escape_string($mysqli, $_POST['chanel']));
    $planer = htmlentities(mysqli_real_escape_string($mysqli, $_POST['planer']));
    $note = htmlentities(mysqli_real_escape_string($mysqli, $_POST['note']));
    $status2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status2']));
    $kli2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['kli2']));
    $sign1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['sign1']));
    $service_type2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['service_type2']));
    $date_in_task = htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($_POST['date_in_task']))));
    $subunit2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['subunit2']));
    $date_out = htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($_POST['date_out']))));
    $rent_service2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['rent_service2']));
    $DogovIn2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['DogovIn2']));
    $cost_in = htmlentities(mysqli_real_escape_string($mysqli, $_POST['cost_in']));
    $tax_bill = htmlentities(mysqli_real_escape_string($mysqli, $_POST['tax_bill']));
    $act = htmlentities(mysqli_real_escape_string($mysqli, $_POST['act']));
    $bill = htmlentities(mysqli_real_escape_string($mysqli, $_POST['bill']));
    $date_in_work = htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($_POST['date_in_work']))));
    $dogov2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['dogov2']));
    $dopdogov2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['dopdogov2']));

    $sql = "INSERT INTO net_operators (id_oper, side_a, side_b, speed_d, operator, name_data, data_id, num_tab, town_a, town_b,
            `cost`, `condition_d`, num_canal, plannerid, note, status_d, user_id, nameclient_id, corp_retail,
            for_what, `in_date`, `podrazd`, date_end, change_login, last_change, sreda_peredachi, our_company,
            capex, tax_doc, act_compl, acc_num, d_stServ_clientu, contract_main_d, dop_dogovor_d)
            VALUES ('$str_n','$s_a','$s_b','$speed','$oper2','$title1','$title2','$base2','$townA2','$townB2',
            '$cost','$date_in','$chanel','$planer','$note','$status2','$user_id','$kli2','$sign1',
            '$service_type2','$date_in_task','$subunit2','$date_out','$user_id', NOW(),'$rent_service2','$DogovIn2',
            '$cost_in','$tax_bill','$act','$bill','$date_in_work','$dogov2','$dopdogov2')";
   // echo $sql;
    if (mysqli_query($mysqli, $sql) === TRUE) {
        header("location: ../../includes/info.ok.php?info=1");
    } else {
        header("location: ../../includes/info.error.php?info=1");
    };
    // добавить запись в табл tab_status_history
    $status1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status1']));
    $sql = "INSERT INTO tab_status_history  (id_zapisi, id_tab, old_status, new_status) VALUES ('$str_n','8','-','$status1')";
   // echo $sql;
    $temp = mysqli_query($mysqli, $sql);
    // закрываем подключение
    mysqli_close($mysqli);
};
?>