<?php
header("Content-Type: text/html; charset=utf-8");
if (!isset($_POST['ok_id'])) {
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
    // id_kli
    $str_n = $_POST['ok_id'];
    //present data
    $sql = 'select o.id_kli, o.klient, o.country_id, o.area_id, o.town_id, o.street, o.kont_tel, o.kont_email, o.device, o.device_id, o.port, o.CID_1, o.CID_2, o.CID_3, o.CID_4, o.CID_5,
            o.chart_joint, o.chart_joint_nc, o.office, o.speed, o.equip, o.planerid, o.retail, o.inexp, o.status_d, o.note, o.in_exp, o.out_exp, k.client, k.key_word, k.class, t.town, c.country, a.region, s.name
            from office_kli o, tab_klients k, tab_town t, tab_country c, tab_area a, tab_status s
            where o.klient = k.id and t.id=o.town_id and o.country_id=c.id and o.area_id=a.id and o.status_d=s.id AND o.id_kli='.$_POST['ok_id'];
    $res = mysqli_query($mysqli, $sql) or die("ERROR: " . mysql_error());
    $office = mysqli_fetch_assoc($res);
    // обязательные поля
    $sql = "UPDATE office_kli SET change_login='$user_nik' WHERE id_kli='$str_n'";
    //Get records from database
    if (mysqli_query($mysqli, $sql) === TRUE) {
        header("location: ../../includes/info.ok.php?info=1");
    } else {
        header("location: ../../includes/info.error.php?info=1");
    };
    $kli2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['kli2']));
    if($kli2 != $office['klient']){
        $sql = "UPDATE office_kli SET klient='$kli2' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $country2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['country2']));
    if($country2 != $office['country_id']){
        $sql = "UPDATE office_kli SET country_id='$country2' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $area2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['area2']));
    if($area2 != $office['area_id']){
        $sql = "UPDATE office_kli SET area_id='$area2' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $town2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['town2']));
    if($town2 != $office['town_id']){
        $sql = "UPDATE office_kli SET town_id='$town2' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $office1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['office1']));
    if($office1 != $office['device']){
        $sql = "UPDATE office_kli SET device='$office1' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $office2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['office2']));
    if($office2 != $office['device_id']){
        $sql = "UPDATE office_kli SET device_id='$office2' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $retail2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['retail2']));
    if($retail2 != $office['retail']){
        $sql = "UPDATE office_kli SET retail='$retail2' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $d = new DateTime($_POST['date_in']);
    $date_in = htmlentities(mysqli_real_escape_string($mysqli, $d->format("Y-m-d")));
    if($date_in != htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($office['in_exp']))))){
        $sql = "UPDATE office_kli SET in_exp='$date_in' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    if($_POST['date_out'] == ''){
        $date_out='0000-00-00';
    } else {
        $d = new DateTime($_POST['date_out']);
        $date_out = htmlentities(mysqli_real_escape_string($mysqli,  $d->format("Y-m-d")));
    }
    if($date_out != htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($office['out_exp']))))){
        $sql = "UPDATE office_kli SET out_exp='$date_out' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    }
    $status2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status2']));
    if($status2 != $office['status_d']){
        $sql = "UPDATE office_kli SET status_d='$status2' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $scheme_pm = htmlentities(mysqli_real_escape_string($mysqli, $_POST['scheme_pm']));
    if($scheme_pm != $office['chart_joint']){
        $sql = "UPDATE office_kli SET chart_joint='$scheme_pm' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    // остальные поля
    $addr = htmlentities(mysqli_real_escape_string($mysqli, $_POST['addr']));
    if ($addr != $office['street']) {
        $sql = "UPDATE office_kli SET street='$addr' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $email = htmlentities(mysqli_real_escape_string($mysqli, $_POST['email']));
    if ($email != $office['kont_email']) {
        $sql = "UPDATE office_kli SET kont_email='$email' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $kontakt = htmlentities(mysqli_real_escape_string($mysqli, $_POST['kontakt']));
    if ($kontakt != $office['kont_tel']) {
        $sql = "UPDATE office_kli SET kont_tel='$kontakt' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $port = htmlentities(mysqli_real_escape_string($mysqli, $_POST['port']));
    if ($port != $office['port']) {
        $sql = "UPDATE office_kli SET port='$port' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $mile1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['mile1']));
    if ($mile1 != $office['chart_joint_nc']) {
        $sql = "UPDATE office_kli SET chart_joint_nc='$mile1' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $status_office2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status_office2']));
    if ($status_office2 != $office['office']) {
        $sql = "UPDATE office_kli SET office='$status_office2' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $speed = htmlentities(mysqli_real_escape_string($mysqli, $_POST['speed']));
    if ($speed != $office['speed']) {
        $sql = "UPDATE office_kli SET speed='$speed' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $device2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['device2']));
    if ($device2 != $office['equip']) {
        $sql = "UPDATE office_kli SET equip='$device2' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $planer = htmlentities(mysqli_real_escape_string($mysqli, $_POST['planer']));
    if ($planer != $office['planerid']) {
        $sql = "UPDATE office_kli SET planerid='$planer' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $in_out = htmlentities(mysqli_real_escape_string($mysqli, $_POST['in_out']));
    if ($in_out != $office['inexp']) {
        $sql = "UPDATE office_kli SET inexp='$in_out' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $note = htmlentities(mysqli_real_escape_string($mysqli, $_POST['note']));
    if ($note != $office['note']) {
        $sql = "UPDATE office_kli SET note='$note' WHERE id_kli='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    // закрываем подключение
    mysqli_close($mysqli);
};
?>