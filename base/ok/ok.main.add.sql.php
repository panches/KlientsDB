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
    $sql = 'SELECT max(id_kli) AS id FROM office_kli';
    $res = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($res);
    $str_n = (int)$row['id'] + 1;
    // обязательные поля
    $kli2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['kli2']));
    $country2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['country2']));
    $area2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['area2']));
    $town2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['town2']));
    $office1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['office1']));
    $office2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['office2']));
    $retail2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['retail2']));
    $d = new DateTime($_POST['date_in']);
    $date_in = htmlentities(mysqli_real_escape_string($mysqli, $d->format("Y-m-d")));
    $date_out = htmlentities(mysqli_real_escape_string($mysqli, '0000-00-00'));
    $status2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status2']));
    $scheme_pm = htmlentities(mysqli_real_escape_string($mysqli, $_POST['scheme_pm']));
    // ..добавить
    $sql="INSERT INTO office_kli (id_kli,klient,country_id,area_id,town_id,device,device_id,retail,in_exp,out_exp,status_d,chart_joint,change_login)
          VALUES ('$str_n','$kli2','$country2','$area2','$town2','$office1','$office2','$retail2','$date_in','$date_out','$status2','$scheme_pm','$user_nik')";
    if (mysqli_query($mysqli, $sql) === TRUE) {
        header("location: ../../includes/info.ok.php?info=1");
    } else {
        header("location: ../../includes/info.error.php?info=1");
    };
    // остальные поля
    $addr = htmlentities(mysqli_real_escape_string($mysqli, $_POST['addr']));
    if ($addr != '') {
        $sql = "UPDATE office_kli SET street='$addr' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $email = htmlentities(mysqli_real_escape_string($mysqli, $_POST['email']));
    if ($email != '') {
        $sql = "UPDATE office_kli SET kont_email='$email' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $kontakt = htmlentities(mysqli_real_escape_string($mysqli, $_POST['kontakt']));
    if ($kontakt != '') {
        $sql = "UPDATE office_kli SET kont_tel='$kontakt' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $port = htmlentities(mysqli_real_escape_string($mysqli, $_POST['port']));
    if ($port != '') {
        $sql = "UPDATE office_kli SET port='$port' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $mile1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['mile1']));
    if ($mile1 != '') {
        $sql = "UPDATE office_kli SET chart_joint_nc='$mile1' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $status_office1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status_office1']));
    $status_office2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status_office2']));
    if ($status_office1 != '') {
        $sql = "UPDATE office_kli SET office='$status_office2' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $speed = htmlentities(mysqli_real_escape_string($mysqli, $_POST['speed']));
    if ($speed != '') {
        $sql = "UPDATE office_kli SET speed='$speed' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $device1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['device1']));
    $device2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['device2']));
    if ($device1 != '') {
        $sql = "UPDATE office_kli SET equip='$device2' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $planer = htmlentities(mysqli_real_escape_string($mysqli, $_POST['planer']));
    if ($planer != '') {
        $sql = "UPDATE office_kli SET planerid='$planer' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $in_out = htmlentities(mysqli_real_escape_string($mysqli, $_POST['in_out']));
    if ($in_out != '') {
        $sql = "UPDATE office_kli SET inexp='$in_out' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $note = htmlentities(mysqli_real_escape_string($mysqli, $_POST['note']));
    if ($note != '') {
        $sql = "UPDATE office_kli SET note='$note' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    // закрываем подключение
    mysqli_close($mysqli);
};
?>