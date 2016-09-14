<?php
header("Content-Type: text/html; charset=utf-8");
if (!isset($_POST['kli1'])) {
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
    $sql = 'SELECT max(id_data) AS id FROM net_data';
    $res = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($res);
    $str_n = (int) $row['id'] + 1;
    // обязательные поля
    $kli2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['kli2']));
    $officeA2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['officeA2']));
    $officeA1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['officeA1']));
    $officeB2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['officeB2']));
    $officeB1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['officeB1']));
    $type_serv2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['type_serv2']));
    $speed = htmlentities(mysqli_real_escape_string($mysqli, $_POST['speed']));
    $cid = htmlentities(mysqli_real_escape_string($mysqli, $_POST['cid']));
    $sla2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['sla2']));
    $status2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status2']));
    $last_date = htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d")));
    $rasch_track = htmlentities(mysqli_real_escape_string($mysqli, $_POST['rasch_track']));
    $track = htmlentities(mysqli_real_escape_string($mysqli, $_POST['track']));
    $note = htmlentities(mysqli_real_escape_string($mysqli, $_POST['note']));
    $priority2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['priority2']));
    $start_dt = htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d h:i:s")));
    $planer = htmlentities(mysqli_real_escape_string($mysqli, $_POST['planer']));
    $retail2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['retail2']));
    $d = new DateTime($_POST['date_in']);
    $date_in = htmlentities(mysqli_real_escape_string($mysqli, $d->format("Y-m-d")));
    $date_out = htmlentities(mysqli_real_escape_string($mysqli, '0000-00-00'));
    $in_out = htmlentities(mysqli_real_escape_string($mysqli, $_POST['in_out']));

    $sql = "INSERT INTO net_data (id_data, client, office_a, name_a, office_b, name_b, type_serv_d, speed, CID,
            SLA, sla_d, sla_id, QOS, status_d, last_date, last_name, zaporozhie,
            ras_scheme, shema, comment, prioritet, start_dt, planerid, retail, in_exp, out_exp, inexp, change_login)
            VALUES ('$str_n','$kli2','$officeA2','$officeA1','$officeB2','$officeB1','$type_serv2','$speed','$cid',
            '0', 'tab_sla_net_data','$sla2','0','$status2','$last_date','$user_nik', '1',
            '$rasch_track','$track','$note','$priority2','$start_dt','$planer','$retail2','$date_in','$date_out','$in_out','$user_nik')";
    if (mysqli_query($mysqli, $sql) === TRUE) {
        header("location: ../../includes/info.ok.php?info=1");
    } else {
        header("location: ../../includes/info.error.php?info=1");
    };
    //echo $sql;
// тестовая эксплуатация:
    if ($status2 == 1) {
        if (date('w', strtotime(changeDate(date("Y-m-d"), 13))) == 6) {
            $dt_str = changeDate(date("Y-m-d"), 12);
        } else {
            if (date('w', strtotime(changeDate($_POST['dt'], 13))) == 0) {
                $dt_str = changeDate(date("Y-m-d"), 11);
            } else {
                $dt_str = changeDate(date("Y-m-d"), 13);
            };
        };
        $last_time = htmlentities(mysqli_real_escape_string($mysqli, date("h:i:s")));
        $sql = "INSERT INTO trubl (inv_num_kli, date_of_start, time_of_start, description, type_trubl_d, name_user, user_id, date_of_open, last_zapisi, tab_on, state_tt, ring_on,
                sostoyanie, otlogeno_data, otlogeno_time)
                VALUES ('$str_n', '$last_date', '$last_time', 'Прием в эксплуатацию', '6', '$user_nik', '2400029', '$start_dt', '$start_dt', '7', '2', '0',
                'отложено', '$dt_str', '10:00:00')";
        //$temp = mysqli_query($mysqli, $sql);
        $sql = "SELECT num_of_trubl_tick FROM trubl WHERE (inv_num_kli='$str_n') AND (date_of_start='$last_date') AND (sostoyanie='отложено')";
        //$temp = mysqli_query($mysqli, $sql);
        $num_of_trubl_tick = $temp['num_of_trubl_tick'];
        $str = 'Истек срок приема в эксплуатацию, приймите решение, по результату измените статус объекта на который открыт ТТ';
        $str = "До : '$dt_str' 10:00:00, Причина: '$str'";
        $sql = "INSERT INTO zapisi_trubl_tic (num_trubl, kontakt, desc_zapisi, name_user, col_centr, transition)
                VALUES ('$num_of_trubl_tick', '$str', '$user_nik', '0', '23')";
        //$temp = mysqli_query($mysqli, $sql);
    };

    function changeDate($dt,$n){
// дату ($dt) увеличить на $n>0 дней, или уменьшить $n<0 дней
        $date = $dt;
        $d = new DateTime($date);
        $d->modify($n . " day");
        return $d->format("Y-m-d");
    };
    // закрываем подключение
    mysqli_close($mysqli);
};
?>