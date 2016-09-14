<?php
    header("Content-Type: text/html; charset=utf-8");
    if ( !isset($_POST['id_equip2']) ) {
        header("location: ../../includes/info.error.php");
    }
    require "../../includes/constants.php";
    //Open database connection
    $mysqli = mysqli_connect($host,$user,$password,$db)
    or die("Ошибка " . mysqli_error($mysqli));
    //Find user's open session
    session_start();
    $user_id = $_SESSION['session_userid'];
    $user_nik = htmlentities(mysqli_real_escape_string($mysqli, $_SESSION['session_username']));
    // id_equip
    $str_n = $_POST['id_equip2'];
    //present data
    $sql = 'SELECT e.id_equip,e.ip_address,e.name_nms,concat_WS(" ",t.town,i.address) as addr,concat_WS(" ",b.brend,b.model) as brend_model,
            e.status_d,e.planerid,e.num_equip,e.linkage,e.net as net_d,e.scheme,e.num_ver,e.num_node,e.in_exp,e.out_exp,e.inexpl
            FROM klients.net_equip e, klients.tblinform2 i, klients.tab_town t, tab_nets n, tab_equip b
            WHERE e.linkage="0" AND e.num_node=i.inv_id AND i.town_id=t.id AND i.town_id=t.id AND e.net=n.id AND e.num_equip=b.id AND e.id_equip='.$str_n.'
            UNION ALL
            SELECT e.id_equip,e.ip_address,e.name_nms,concat_WS(" ",k.client,o.street) as addr,concat_WS(" ",b.brend,b.model) as brend_model,
            e.status_d,e.planerid,e.num_equip,e.linkage,e.net as net_d,e.scheme,e.num_ver,e.num_node,e.in_exp,e.out_exp,e.inexpl
            FROM klients.net_equip e, klients.office_kli o, klients.tab_klients k, tab_nets n, tab_equip b
            WHERE e.linkage="1" AND e.num_node=o.id_kli AND o.klient=k.id AND e.net=n.id AND e.num_equip=b.id AND e.id_equip='.$str_n;
    $res = mysqli_query($mysqli, $sql) or die("ERROR: ".mysql_error());
    $equip = mysqli_fetch_assoc($res);
    // обязательные поля
    $sql = "UPDATE net_equip SET user_id='$user_id' WHERE id_equip='$str_n+'";
    //Get records from database
    if (mysqli_query($mysqli, $sql) === TRUE) {
        header("location: ../../includes/info.ok.php?info=1");
    } else {
        header("location: ../../includes/info.error.php?info=1");
    };
    $type_net2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['type_net2']));
    if($type_net2 != $equip['net_d']){
        $sql = "UPDATE net_equip SET net='$type_net2' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    }
    $ipaddr = htmlentities(mysqli_real_escape_string($mysqli, $_POST['ipaddr']));
    if($ipaddr != $equip['ip_address']){
        $sql = "UPDATE net_equip SET ip_address='$ipaddr' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    }
    $nms = htmlentities(mysqli_real_escape_string($mysqli, $_POST['nms']));
    if($nms != $equip['name_nms']){
        $sql = "UPDATE net_equip SET name_nms='$nms' WHERE id_equip='$sql'";
        $temp = mysqli_query($mysqli, $sql);
    }
    $location2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['location2']));
    if($location2 != $equip['linkage']){
        $sql = "UPDATE net_equip SET linkage='$location2' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    }
    $attach2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['attach2']));
    if($attach2 != $equip['num_node']){
        $sql = "UPDATE net_equip SET num_node='$attach2' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    }
    $status2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status2']));
    if($status2 != $equip['status_d']){
        $sql = "UPDATE net_equip SET status_d='$status2' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $d = new DateTime($_POST['date_in']);
    $date_in = htmlentities(mysqli_real_escape_string($mysqli, $d->format("Y-m-d")));
    if($date_in != htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($equip['in_exp']))))){
        $sql = "UPDATE net_equip SET in_exp='$date_in' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    if($_POST['date_out'] == ''){
        $date_out='0000-00-00';
    } else {
        $d = new DateTime($_POST['date_out']);
        $date_out = htmlentities(mysqli_real_escape_string($mysqli,  $d->format("Y-m-d")));
    }
    if($date_out != htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($equip['out_exp']))))){
        $sql = "UPDATE net_equip SET out_exp='$date_out' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    }
    // остальные поля
    $scheme = htmlentities(mysqli_real_escape_string($mysqli, $_POST['scheme']));
    if($scheme != $equip['scheme']){
        $sql = "UPDATE net_equip SET scheme='$scheme' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    }
    $fromlist2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['fromlist2']));
    if ($fromlist2 != $equip['num_equip']) {
        $sql = "UPDATE net_equip SET num_equip='$fromlist2' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $version = htmlentities(mysqli_real_escape_string($mysqli, $_POST['version']));
    if ($version != $equip['num_ver']) {
        $sql = "UPDATE net_equip SET num_ver='$version' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $planer = htmlentities(mysqli_real_escape_string($mysqli, $_POST['planer']));
    if ($planer != $equip['planerid']) {
        $sql = "UPDATE net_equip SET planerid='$planer' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $in_out = htmlentities(mysqli_real_escape_string($mysqli, $_POST['in_out']));
    if ($in_out != $equip['inexpl']) {
        $sql = "UPDATE net_equip SET inexpl='$in_out' WHERE id_equip='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    // закрываем подключение
    mysqli_close($mysqli);
?>