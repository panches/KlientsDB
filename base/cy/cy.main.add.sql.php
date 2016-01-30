<?php
header("Content-Type: text/html; charset=utf-8");
if (!isset($_POST['type_net'])) {
    header("location: ../../includes/info.error.php");
} else {
    require "../../includes/constants.php";
    //Open database connection
    $mysqli = mysqli_connect($host, $user, $password, $db)
                or die("Ошибка " . mysqli_error($mysqli));

    session_start();
    $user_id = $_SESSION['session_userid'];
    $user_nik = htmlentities(mysqli_real_escape_string($mysqli, $_SESSION['session_username']));
    // поиск max(id_equip)
    $sql = 'SELECT max(id_equip) AS id FROM net_equip';
    $res = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($res);
    $str_n = (int)$row['id'] + 1;
    // обязательные поля
    $type_net2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['type_net2']));
    $ipaddr = htmlentities(mysqli_real_escape_string($mysqli, $_POST['ipaddr']));
    $nms = htmlentities(mysqli_real_escape_string($mysqli, $_POST['nms']));
    $location2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['location2']));
    $attach2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['attach2']));
    $scheme = htmlentities(mysqli_real_escape_string($mysqli, $_POST['scheme']));
    $status2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status2']));
    $date_in = htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($_POST['date_in']))));
    $date_out = htmlentities(mysqli_real_escape_string($mysqli, '0000-00-00'));
    $sql = "INSERT INTO net_equip (id_equip, net, ip_address, name_nms, linkage, num_node, scheme, status_d, in_exp, out_exp, user_id)
       VALUES ('$str_n', '$type_net2', '$ipaddr', '$nms', '$location2', '$attach2', '$scheme', '$status2', '$date_in', '$date_out', '$user_id')";
    //Get records from database
    //$temp = mysqli_query($mysqli, $sql);
        if (mysqli_query($mysqli, $sql) === TRUE) {
            header("location: ../../includes/info.ok.php?info=1");
        } else {
            header("location: ../../includes/info.error.php?info=1");
        };
    // остальные поля
    $fromlist2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['fromlist2']));
    if ($fromlist2 != '') {
        $sql = "UPDATE net_equip SET num_equip='$fromlist2' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $version = htmlentities(mysqli_real_escape_string($mysqli, $_POST['version']));
    if ($version != '') {
        $sql = "UPDATE net_equip SET num_ver='$version' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $planer = htmlentities(mysqli_real_escape_string($mysqli, $_POST['planer']));
    if ($planer != '') {
        $sql = "UPDATE net_equip SET planerid='$planer' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $in_out = htmlentities(mysqli_real_escape_string($mysqli, $_POST['in_out']));
    if ($in_out != '') {
        $sql = "UPDATE net_equip SET inexpl='$in_out' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    // открытие ТТ - если status = 'тестовая эксплуатация'
    if ($status2 == 1) {
        // берем время с сервера
        $sql = 'SELECT NOW() as dt';
        $temp = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_assoc($temp);
        $dt_str = htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d H:i:s", strtotime($row['dt']))));
        $date_raw = (date('s') + strtotime("+13 day"));
        switch (date('l', $date_raw)) {
            case 'Saturdey':
                $str = (date('s') + strtotime("+12 day"));
                $dt_out = date('Y-m-d', $str);
                break;
            case 'Sunday':
                $str = (date('s') + strtotime("+11 day"));
                $dt_out = date('Y-m-d', $str);
                break;
            default:
                $dt_out = date('Y-m-d', $date_raw);
        };
        $str_d = date('Y-m-d'); $str_t = date('H:i:s');
        // !!! подкорректировать поле user_id
        $sql = "INSERT INTO trubl (inv_num_kli, date_of_start, time_of_start, description, type_trubl_d, name_user, user_id, date_of_open, last_zapisi, tab_on, state_tt, ring_on,
            sostoyanie, otlogeno_data, otlogeno_time)
            VALUES ('$str_n','$str_d','$str_t','Прием в эксплуатацию','6','$user_nik','2400029','$dt_str','$dt_str','4','2','0',
            'отложено','$dt_out','10:00:00')";
        $temp = mysqli_query($mysqli, $sql);
        $sql = "SELECT num_of_trubl_tick FROM trubl WHERE (inv_num_kli='$str_n') AND (date_of_start='$str_d') AND (sostoyanie='отложено')";
        $temp = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_assoc($temp);
        $str_tt = $row['num_of_trubl_tick'];
        $str = 'До : '.$dt_out.' 10:00:00, Причина: Истек срок приема в эксплуатацию, приймите решение, по результату измените статус объекта на который открыт ТТ';
        $sql = "INSERT INTO zapisi_trubl_tic (num_trubl, date_zapisi, time_zapisi, kontakt, desc_zapisi, name_user, col_centr, transition)
                VALUES ('$str_tt','$str_d','$str_t','Отложено','$str','$user_nik','0','23')";
        $temp = mysqli_query($mysqli, $sql);
    };
    // добавить запись в табл tab_status_history
    $status = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status']));
    $sql = "INSERT INTO tab_status_history  (id_zapisi, id_tab, old_status, new_status) VALUES ('$str_n','4','-','$status')";
    $temp = mysqli_query($mysqli, $sql);
    // закрываем подключение
    mysqli_close($mysqli);
};
?>