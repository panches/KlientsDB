<?php
    header("Content-Type: text/html; charset=utf-8");
    if (!isset($_POST['equip_a2']) or !isset($_POST['equip_b2'])) {
        header("location: ../../includes/info.error.php");
    }
    require "../../includes/constants.php";
    //Open database connection
    $mysqli = mysqli_connect($host,$user,$password,$db)
                    or die("Ошибка " . mysqli_error($mysqli));

    session_start();
    $user_id = $_SESSION['session_userid'];
    $user_nik = htmlentities(mysqli_real_escape_string($mysqli, $_SESSION['session_username']));
    // поиск max(id_equip)
    $sql = 'SELECT max(id_equip) AS id FROM net_equip';
    $res = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($res);
    $str_n = (int) $row['id'] + 1;
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
    if (mysqli_query($mysqli, $sql) === TRUE) {
        header("location: ../../includes/info.ok.php?info=1");
    } else {
        header("location: ../../includes/info.error.php?info=1");
    };
    // остальные поля
    $fromlist2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['fromlist2']));
    if($fromlist2 != '') {
        $sql = "UPDATE net_equip SET num_equip='$fromlist2' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $version = htmlentities(mysqli_real_escape_string($mysqli, $_POST['version']));
    if($version != '') {
        $sql = "UPDATE net_equip SET num_ver='$version' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $planer = htmlentities(mysqli_real_escape_string($mysqli, $_POST['planer']));
    if($planer != '') {
        $sql = "UPDATE net_equip SET planerid='$planer' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $in_out = htmlentities(mysqli_real_escape_string($mysqli, $_POST['in_out']));
    if($in_out != '') {
        $sql = "UPDATE net_equip SET inexpl='$in_out' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    // закрываем подключение
    mysqli_close($mysqli);
?>