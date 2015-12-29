<?php
header("Content-Type: text/html; charset=utf-8");
if (!isset($_POST['equip_a2']) or !isset($_POST['equip_b2'])) {
    header("location: ../includes/info.error.php");
}
require "../includes/constants.php";
//Open database connection
$mysqli = mysqli_connect($host,$user,$password,$db)
or die("Ошибка " . mysqli_error($mysqli));
// logged user
session_start();
$user_id = $_SESSION['session_userid'];
$user_nik = htmlentities(mysqli_real_escape_string($mysqli, $_SESSION['session_username']));
// UPDATE ....
if ($_POST['sign'] == "сетевое") {
    $str = $_POST['equip_a'] . ' ' . $_POST['port_a'] . ' -- ' . $_POST['port_b'] . ' ' . $_POST['equip_b'] . ' Скорость: ' . $_POST['speed'] . ' Мбит/с';
    $str = htmlentities(mysqli_real_escape_string($mysqli, $str));
    $type_net = htmlentities(mysqli_real_escape_string($mysqli, $_POST['type_net']));
    $equip_a2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['equip_a2']));
    $port_a = htmlentities(mysqli_real_escape_string($mysqli, $_POST['port_a']));
    $equip_b2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['equip_b2']));
    $port_b = htmlentities(mysqli_real_escape_string($mysqli, $_POST['port_b']));
    $sla2 = '0';
    $speed = htmlentities(mysqli_real_escape_string($mysqli, $_POST['speed']));
    $scheme = htmlentities(mysqli_real_escape_string($mysqli, $_POST['scheme']));
    $date_in = htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($_POST['date_in']))));
    $date_out = htmlentities(mysqli_real_escape_string($mysqli, '0000-00-00'));
    $in_out = htmlentities(mysqli_real_escape_string($mysqli, $_POST['in_out']));
    $status2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status2']));
    $sign = '0';
    $planer = htmlentities(mysqli_real_escape_string($mysqli, $_POST['planer']));
    $note = htmlentities(mysqli_real_escape_string($mysqli, $_POST['note']));
    $id_link2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['id_link2']));
    // SQL запрос для "сетевое"
    $sql = "UPDATE net_links SET sign_net='$type_net', sign_net2='$type_net',
            equip_a='$equip_a2', port_a='$port_a', equip_b='$equip_b2', port_b='$port_b',
            pass='$speed', name='$str', note='$note', scheme='$scheme',
            flag_link='$sign', planerid='$planer', in_exp='$date_in', out_exp='$date_out',
            inexp='$in_out', status_d='$status2', sla='$sla2', change_login='$user_nik'
            WHERE id_link='$id_link2'";
};
if ($_POST['sign'] == "межсетевое") {
    $str = $_POST['equip_a'] . ' ' . $_POST['port_a'] . ' -- ' . $_POST['port_b'] . ' ' . $_POST['equip_b'] . ' Скорость: ' . $_POST['speed'] . ' Мбит/с';
    $str = htmlentities(mysqli_real_escape_string($mysqli, $str));
    $type_netA = htmlentities(mysqli_real_escape_string($mysqli, $_POST['type_netA']));
    $equip_a2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['equip_a2']));
    $port_a = htmlentities(mysqli_real_escape_string($mysqli, $_POST['port_a']));
    $type_netB = htmlentities(mysqli_real_escape_string($mysqli, $_POST['type_netB']));
    $equip_b2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['equip_b2']));
    $port_b = htmlentities(mysqli_real_escape_string($mysqli, $_POST['port_b']));
    $sla2 = '0';
    $speed = htmlentities(mysqli_real_escape_string($mysqli, $_POST['speed']));
    $scheme = htmlentities(mysqli_real_escape_string($mysqli, $_POST['scheme']));
    $date_in = htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($_POST['date_in']))));
    $date_out = htmlentities(mysqli_real_escape_string($mysqli, '0000-00-00'));
    $in_out = htmlentities(mysqli_real_escape_string($mysqli, $_POST['in_out']));
    $status2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status2']));
    $sign = '2';
    $planer = htmlentities(mysqli_real_escape_string($mysqli, $_POST['planer']));
    $note = htmlentities(mysqli_real_escape_string($mysqli, $_POST['note']));
    $id_link2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['id_link2']));
    // SQL запрос для "сетевое"
    $sql = "UPDATE net_links SET sign_net='$type_netA', sign_net2='$type_netB',
            equip_a='$equip_a2', port_a='$port_a', equip_b='$equip_b2', port_b='$port_b',
            pass='$speed', name='$str', note='$note', scheme='$scheme',
            flag_link='$sign', planerid='$planer', in_exp='$date_in', out_exp='$date_out',
            inexp='$in_out', status_d='$status2', sla='$sla2', change_login='$user_nik'
            WHERE id_link='$id_link2'";
};
if ($_POST['sign'] == "сервис провайдера") {
    $str = $_POST['equip_a'] . ' ' . $_POST['port_a'] . ' -- ' . $_POST['cid'] . ' ' . $_POST['client'] . ' Скорость: ' . $_POST['speed'] . ' Мбит/с';
    $str = htmlentities(mysqli_real_escape_string($mysqli, $str));
    $type_net = htmlentities(mysqli_real_escape_string($mysqli, $_POST['type_net']));
    $equip_a2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['equip_a2']));
    $port_a = htmlentities(mysqli_real_escape_string($mysqli, $_POST['port_a']));
    $client2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['client2']));
    $cid = htmlentities(mysqli_real_escape_string($mysqli, $_POST['cid']));
    $sla2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['sla2']));
    $speed = htmlentities(mysqli_real_escape_string($mysqli, $_POST['speed']));
    $scheme = htmlentities(mysqli_real_escape_string($mysqli, $_POST['scheme']));
    $date_in = htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($_POST['date_in']))));
    $date_out = htmlentities(mysqli_real_escape_string($mysqli, '0000-00-00'));
    $in_out = htmlentities(mysqli_real_escape_string($mysqli, $_POST['in_out']));
    $status2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status2']));
    $sign = '3';
    $planer = htmlentities(mysqli_real_escape_string($mysqli, $_POST['planer']));
    $note = htmlentities(mysqli_real_escape_string($mysqli, $_POST['note']));
    $id_link2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['id_link2']));
    // SQL запрос для "сетевое"
    $sql = "UPDATE net_links SET sign_net='$type_net', sign_net2='$type_net',
            equip_a='$equip_a2', port_a='$port_a', equip_b='$client2', port_b='$cid',
            pass='$speed', name='$str', note='$note', scheme='$scheme',
            flag_link='$sign', planerid='$planer', in_exp='$date_in', out_exp='$date_out',
            inexp='$in_out', status_d='$status2', sla='$sla2', change_login='$user_nik'
            WHERE id_link='$id_link2'";
};
//Get records from database
if (mysqli_query($mysqli, $sql) === TRUE) {
    header("location: ../includes/info.ok.php?info=1");
} else {
    header("location: ../includes/info.error.php?info=1");
};
// close database connection
mysqli_close($mysqli);
?>