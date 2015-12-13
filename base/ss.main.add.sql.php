<?php
    header("Content-Type: text/html; charset=utf-8");
    if (!isset($_POST['equip_a2']) or !isset($_POST['equip_b2'])) {
        header("location: ../includes/info.error.php");
    }
    require "../includes/constants.php";
    //Open database connection
    $mysqli = mysqli_connect($host,$user,$password,$db)
            or die("Ошибка " . mysqli_error($mysqli));

    session_start();
    $user_id = $_SESSION['session_userid'];
    $user_nik = htmlentities(mysqli_real_escape_string($mysqli, $_SESSION['session_username']));
    // экранизация символов в строке
    $str = $_POST['equip_a'].' '.$_POST['port_a'].' -- '.$_POST['port_b'].' '.$_POST['equip_b'].' Скорость: '.$_POST['speed'].' Мбит/с';
    $str = htmlentities(mysqli_real_escape_string($mysqli, $str));
    $type_net2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['type_net2']));
    $equip_a2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['equip_a2']));
    $port_a = htmlentities(mysqli_real_escape_string($mysqli, $_POST['port_a']));
    $equip_b2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['equip_b2']));
    $port_b = htmlentities(mysqli_real_escape_string($mysqli, $_POST['port_b']));
    $speed = htmlentities(mysqli_real_escape_string($mysqli, $_POST['speed']));
    $scheme = htmlentities(mysqli_real_escape_string($mysqli, $_POST['scheme']));
    $date_in = htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d",strtotime($_POST['date_in']))));
    $date_out = htmlentities(mysqli_real_escape_string($mysqli, '0000-00-00'));
    $in_out = htmlentities(mysqli_real_escape_string($mysqli, $_POST['in_out']));
    $status2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status2']));
    $sign2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['sign2']));
    $planer = htmlentities(mysqli_real_escape_string($mysqli, $_POST['planer']));
    $note = htmlentities(mysqli_real_escape_string($mysqli, $_POST['note']));
    // SQL запрос для "сетевое"
    $sql = "INSERT INTO net_links (sign_net, sign_net2, equip_a, port_a, equip_b, port_b, pass, name, note,
            scheme, flag_link, planerid, in_exp, out_exp, inexp, status_d, sla, change_login)
            VALUES ('$type_net2','$type_net2','$equip_a2','$port_a','$equip_b2','$port_b','$speed','$str','$note',
            '$scheme','$sign2','$planer','$date_in','$date_out','$in_out','$status2',0,'$user_nik')";
    //Get records from database
    if (mysqli_query($mysqli, $sql) === TRUE) {
        header("location: ../includes/info.ok.php?info=1");
    } else {
        header("location: ../includes/info.error.php?info=1");
    };
    // закрываем подключение
    mysqli_close($mysqli);
?>