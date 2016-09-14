<?php
header("Content-Type: text/html; charset=utf-8");
if (!isset($_POST['ssy_id'])) {
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
    $str_n = $_POST['ssy_id'];
    //present dat
    $sql = 'SELECT o.town_a, ta.town as atown, ta.country_id as acountry, ta.area_id as aregion, o.side_a,
                   o.town_b, tb.town as btown, tb.country_id as bcountry, tb.area_id as bregion, o.side_b,
                   o.operator, k.client, o.speed_d, o.contract_main_d, o.dop_dogovor_d, o.our_company,
                   o.num_tab, o.name_data, o.data_id, o.nameclient_id, o.condition_d, o.d_stServ_clientu,
                   o.num_canal, o.cost, o.status_d, s.name as status_name, o.plannerid, o.in_date,
                   o.podrazd, p.name_p, o.corp_retail, o.capex, o.for_what, t.name as name_sk, o.date_end,
                   o.tax_doc, o.sreda_peredachi, o.act_compl, o.acc_num, o.note
            FROM net_operators o
            LEFT JOIN tab_klients k ON o.operator=k.id
            LEFT JOIN tab_status s ON s.id=o.status_d
            LEFT JOIN tab_town ta ON ta.id=o.town_a
            LEFT JOIN tab_town tb ON tb.id=o.town_b
            LEFT JOIN tab_catal_podrazd p ON p.id=o.podrazd
            LEFT JOIN tab_katal_sk_type t ON t.id=o.for_what
            WHERE o.id_oper=' . $str_n;
    $res = mysqli_query($mysqli, $sql);
    $oper = mysqli_fetch_assoc($res);

    $sql = "UPDATE net_operators SET change_login='$user_id' WHERE id_oper='$str_n'";
    if (mysqli_query($mysqli, $sql) === TRUE) {
        header("location: ../../includes/info.ok.php?info=1");
    } else {
        header("location: ../../includes/info.error.php?info=1");
    };
    $townA2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['townA2']));
    if ($oper['town_a'] != $townA2) {
        $sql = 'UPDATE net_operators SET town_a="'.$townA2.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $townB2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['townB2']));
    if ($oper['town_b'] != $townB2) {
        $sql = 'UPDATE net_operators SET town_b="'.$townB2.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $areaA1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['areaA1']));
    $numA1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['numA1']));
    $s_a = $areaA1.', '.$numA1;
    if ($oper['side_a']!= $s_a) {
        $sql = 'UPDATE net_operators SET side_a="'.$s_a.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $areaB1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['areaA1']));
    $numB1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['numA1']));
    $s_b = $areaB1.', '.$numB1;
    if ($oper['side_b'] != $s_b) {
        $sql = 'UPDATE net_operators SET side_b="'.$s_b.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $oper2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['oper2']));
    if ($oper['operator'] != $oper2) {
        $sql = 'UPDATE net_operators SET operator="'.$oper2.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $sign2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['sign2']));
    if ($oper['corp_retail'] != $sign2) {
        $sql = 'UPDATE net_operators SET corp_retail="'.$sign2.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $speed = htmlentities(mysqli_real_escape_string($mysqli, $_POST['speed']));
    if ($oper['speed_d'] != $speed) {
        $sql = 'UPDATE net_operators SET speed_d="'.$speed.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $title2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['title2']));
    if ($oper['data_id'] != $title2) {
        $sql = 'UPDATE net_operators SET data_id="'.$title2.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $title1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['title1']));
    if ($oper['name_data'] != $title1) {
        $sql = 'UPDATE net_operators SET name_data="'.$title1.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    if($_POST['date_in_task'] == ''){
        $date_in_task='0000-00-00';
    } else {
        $d = new DateTime($_POST['date_in_task']);
        $date_in_task = htmlentities(mysqli_real_escape_string($mysqli,  $d->format("Y-m-d")));
    };
    if (htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($oper['in_date'])))) !=  $date_in_task) {
        $sql = 'UPDATE net_operators SET `in_date`="'.$date_in_task.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $base2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['base2']));
    if ($oper['num_tab'] != $base2) {
        $sql = 'UPDATE net_operators SET num_tab="'.$base2.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $cost = htmlentities(mysqli_real_escape_string($mysqli, $_POST['cost']));
    if ($oper['cost'] != $cost) {
        $sql = 'UPDATE net_operators SET `cost`="'.$cost.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    if($_POST['date_in'] == ''){
        $date_in='0000-00-00';
    } else {
        $d = new DateTime($_POST['date_in']);
        $date_in = htmlentities(mysqli_real_escape_string($mysqli,  $d->format("Y-m-d")));
    };
    if (htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($oper['condition_d'])))) !=  $date_in) {
        $sql = 'UPDATE net_operators SET `condition_d`="'.$date_in.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    if($_POST['date_in_work'] == ''){
        $date_in_work='0000-00-00';
    } else {
        $d = new DateTime($_POST['date_in_work']);
        $date_in_work = htmlentities(mysqli_real_escape_string($mysqli,  $d->format("Y-m-d")));
    };
    if (htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($oper['d_stServ_clientu'])))) !=  $date_in_work) {
        $sql = 'UPDATE net_operators SET `d_stServ_clientu`="'.$date_in_work.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $chanel = htmlentities(mysqli_real_escape_string($mysqli, $_POST['chanel']));
    if ($oper['num_canal'] != $chanel) {
        $sql = 'UPDATE net_operators SET `num_canal`="'.$chanel.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $dogov2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['dogov2']));
    if ($oper['contract_main_d'] != $dogov2) {
        $sql = 'UPDATE net_operators SET `contract_main_d`="'.$dogov2.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $dopdogov2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['dopdogov2']));
    if ($oper['dop_dogovor_d'] != $dopdogov2) {
        $sql = 'UPDATE net_operators SET `dop_dogovor_d`="'.$dopdogov2.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $planer = htmlentities(mysqli_real_escape_string($mysqli, $_POST['planer']));
    if ($oper['plannerid'] != $planer) {
        $sql = 'UPDATE net_operators SET `plannerid`="'.$planer.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $note = htmlentities(mysqli_real_escape_string($mysqli, $_POST['note']));
    if ($oper['note'] != $note) {
        $sql = 'UPDATE net_operators SET `note`="'.$note.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $status2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status2']));
    if ($oper['status_d'] != $status2) {
        $sql = 'UPDATE net_operators SET `status_d`="'.$status2.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $kli2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['kli2']));
    if ($oper['nameclient_id'] != $kli2) {
        $sql = 'UPDATE net_operators SET `nameclient_id`="'.$kli2.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $service_type2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['service_type2']));
    if ($oper['for_what'] != $service_type2) {
        $sql = 'UPDATE net_operators SET `for_what`="'.$service_type2.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $subunit2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['subunit2']));
    if ($oper['podrazd'] != $subunit2) {
        $sql = 'UPDATE net_operators SET `podrazd`="'.$subunit2.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    if($_POST['date_out'] == ''){
        $date_out='0000-00-00';
    } else {
        $d = new DateTime($_POST['date_out']);
        $date_out = htmlentities(mysqli_real_escape_string($mysqli,  $d->format("Y-m-d")));
    };
    if (htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d", strtotime($oper['date_end'])))) !=  $date_out) {
        $sql = 'UPDATE net_operators SET `date_end`="'.$date_out.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $cost_in = htmlentities(mysqli_real_escape_string($mysqli, $_POST['cost_in']));
    if ($oper['capex'] != $cost_in) {
        $sql = 'UPDATE net_operators SET `capex`="'.$cost_in.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $tax_bill = htmlentities(mysqli_real_escape_string($mysqli, $_POST['tax_bill']));
    if ($oper['tax_doc'] != $tax_bill) {
        $sql = 'UPDATE net_operators SET `tax_doc`="'.$tax_bill.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $act = htmlentities(mysqli_real_escape_string($mysqli, $_POST['act']));
    if ($oper['act_compl'] != $act) {
        $sql = 'UPDATE net_operators SET `act_compl`="'.$act.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $bill = htmlentities(mysqli_real_escape_string($mysqli, $_POST['bill']));
    if ($oper['acc_num'] != $bill) {
        $sql = 'UPDATE net_operators SET `acc_num`="'.$bill.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $rent_service2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['rent_service2']));
    if ($oper['sreda_peredachi'] != $rent_service2) {
        $sql = 'UPDATE net_operators SET `sreda_peredachi`="'.$rent_service2.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    $DogovIn2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['DogovIn2']));
    if ($oper['our_company'] != $DogovIn2) {
        $sql = 'UPDATE net_operators SET `our_company`="'.$DogovIn2.'" WHERE id_oper="'.$str_n.'"';
        $temp = mysqli_query($mysqli, $sql);
    };
    // закрываем подключение
    mysqli_close($mysqli);
};
?>