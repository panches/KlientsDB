<?php
header("Content-Type: text/html; charset=utf-8");
if (!isset($_POST['sk_id'])) {
    header("location: ../../includes/info.error.php");
} else {
    require "../../includes/constants.php";
    //Open database connection
    $mysqli = mysqli_connect($host, $user, $password, $db)
    or die("Ошибка " . mysqli_error($mysqli));
    //Find user's open session
    session_start();
    $user_id = $_SESSION['session_userid'];
    $user_nik = htmlentities(mysqli_real_escape_string($mysqli, $_SESSION['session_username']));
    // id_sk
    $str_n = $_POST['sk_id'];
    //present data
    $sql = 'SELECT net_data.*, k.client AS kli, s.name AS sk_status, t.name AS sk_type FROM net_data, tab_klients k, tab_status s, tab_katal_sk_type t
            WHERE net_data.client=k.id and net_data.status_d=s.id and net_data.type_serv_d=t.id AND net_data.id_data=' . $str_n;
    $res = mysqli_query($mysqli, $sql) or die("ERROR: " . mysql_error());
    $service = mysqli_fetch_assoc($res);
    // EDIT
    // постоянные
    $status2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status2']));
    if ($status2 == $service['status_d']) {
        $sql = 'UPDATE net_data SET sla_d = "tab_sla_net_data", last_date = "' . date("Y-m-d") . '", last_name = "' . $user_nik . '", change_login = "' . $user_nik . '"
                WHERE id_data = "' . $str_n . '"';
    } else {
        $sql = 'UPDATE net_data SET sla_d = "tab_sla_net_data", change_login = "' . $user_nik . '"
                WHERE id_data = "' . $str_n . '"';
    }
    if (mysqli_query($mysqli, $sql) === TRUE) {
        header("location: ../../includes/info.ok.php?info=1");
    } else {
        header("location: ../../includes/info.error.php?info=1");
    };
    // по требованию
    $type_serv2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['type_serv2']));
    if ($service['type_serv_d'] != $type_serv2) {
        $sql = 'UPDATE net_data SET type_serv_d = "' . $type_serv2 . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $officeA2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['officeA2']));
    if ($service['office_a'] != $officeA2) {
        $sql = 'UPDATE net_data SET office_a = "' . $officeA2 . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $officeA1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['officeA1']));
    if ($service['name_a'] != $officeA1) {
        $sql = 'UPDATE net_data SET name_a = "' . $officeA1 . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $officeB2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['officeB2']));
    if ($service['office_b'] != $officeB2) {
        $sql = 'UPDATE net_data SET office_b = "' . $officeB2 . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    }
    $officeB1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['officeB1']));
    if ($service['name_b'] != $officeB1) {
        $sql = 'UPDATE net_data SET name_b = "' . $officeB1 . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    }
    $kli2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['kli2']));
    if ($service['client'] != $kli2) {
        $sql = 'UPDATE net_data SET client = "' . $kli2 . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $speed = htmlentities(mysqli_real_escape_string($mysqli, $_POST['speed']));
    if ($service['speed'] != $speed) {
        $sql = 'UPDATE net_data SET speed = "' . $speed . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $cid = htmlentities(mysqli_real_escape_string($mysqli, $_POST['cid']));
    if ($service['cid'] != $cid) {
        $sql = 'UPDATE net_data SET CID = "' . $cid . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $sla2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['sla2']));
    if ($service['sla_id'] != $sla2) {
        $sql = 'UPDATE net_data SET sla_id = "' . $sla2 . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $status2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status2']));
    if ($service['status_d'] != $status2) {
        $sql = 'UPDATE net_data SET status_d = "' . $status2 . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $rasch_track = htmlentities(mysqli_real_escape_string($mysqli, $_POST['rasch_track']));
    if ($service['ras_scheme'] != $rasch_track) {
        $sql = 'UPDATE net_data SET ras_scheme = "' . $rasch_track . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $track = htmlentities(mysqli_real_escape_string($mysqli, $_POST['track']));
    if ($service['shema'] != $track) {
        $sql = 'UPDATE net_data SET shema = "' . $track . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $note = htmlentities(mysqli_real_escape_string($mysqli, $_POST['note']));
    if ($service['comment'] != $note) {
        $sql = 'UPDATE net_data SET comment = "' . $note . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $priority2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['priority2']));
    if ($service['prioritet'] != $priority2) {
        $sql = 'UPDATE net_data SET prioritet = "' . $priority2 . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $planer = htmlentities(mysqli_real_escape_string($mysqli, $_POST['planer']));
    if ($service['planerid'] != $planer) {
        $sql = 'UPDATE net_data SET planerid = "' . $planer . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $retail2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['retail2']));
    if ($service['retail'] != $retail2) {
        $sql = 'UPDATE net_data SET retail = "' . $retail2 . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $d = new DateTime($_POST['date_in']);
    $date_in = htmlentities(mysqli_real_escape_string($mysqli, $d->format("Y-m-d")));
    if ($date_in != htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($office['in_exp']))))) {
        $sql = 'UPDATE net_data SET in_exp = "' . $date_in . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    if($_POST['date_out'] == ''){
        $date_out='0000-00-00';
    } else {
        $d = new DateTime($_POST['date_out']);
        $date_out = htmlentities(mysqli_real_escape_string($mysqli,  $d->format("Y-m-d")));
    }
    if ($date_out != htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($office['out_exp']))))) {
        $sql = 'UPDATE net_data SET out_exp = "' . $date_out . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $in_out = htmlentities(mysqli_real_escape_string($mysqli, $_POST['in_out']));
    if ($service['inexp'] != $in_out) {
        $sql = 'UPDATE net_data SET inexp = "' . $in_out . '" WHERE id_data = "' . $str_n . '"';
        $temp = mysqli_query($mysqli, $sql);
    };
    // Изменять статус ОК, при изменении статуса СК #113
    $sql = 'SELECT COUNT(*) as num FROM net_data WHERE net_data.status_d = "2" AND (net_data.office_a = "' . $officeA2 . '" OR net_data.office_b = "' . $officeA2 . '")';
    $temp = mysqli_query($mysqli, $sql);
    if ($temp['num'] == 0) {
        if ($status2 == 6 || $status2 == 7) {
            $sql = 'UPDATE office_kli SET status_d = "' . $status2 . '", out_exp="' . $date_out . '" WHERE id_kli = "' . $officeA2 . '"';
        } else {
            $sql = 'UPDATE office_kli SET status_d = "' . $status2 . '" WHERE id_kli = "' . $officeA2 . '"';
        }
        $temp = mysqli_query($mysqli, $sql);
    };
    $sql = 'SELECT COUNT(*) as num FROM net_data WHERE net_data.status_d = "2" AND (net_data.office_a = "' . $officeB2 . '" OR net_data.office_b = "' . $officeB2 . '")';
    $temp = mysqli_query($mysqli, $sql);
    if ($temp['num'] == 0) {
        if ($status2 == 6 || $status2 == 7) {
            $sql = 'UPDATE office_kli SET status_d = "' . $status2 . '", out_exp="' . $date_out . '" WHERE id_kli = "' . $officeB2 . '"';
        } else {
            $sql = 'UPDATE office_kli SET status_d = "' . $status2 . '" WHERE id_kli = "' . $officeB2 . '"';
        }
        $temp = mysqli_query($mysqli, $sql);
    };
    // закрываем подключение
    mysqli_close($mysqli);
};
?>