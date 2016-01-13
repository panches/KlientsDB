<?php
    header("Content-Type: text/html; charset=utf-8");
    if ( !isset($_POST['name1']) ) {
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
    // inv_id
    $str_n = $_POST['id_node2'];
    //present data
    $sql= 'SELECT t.*, w.town, w.town_ua, c.country, a.region
              FROM tblinform2 t, tab_town w, tab_country c, tab_area a
              WHERE t.town_id=w.id and t.country_id=c.id and t.area_id=a.id AND t.inv_id='.$str_n;
    $res = mysqli_query($mysqli, $sql);
    $node = mysqli_fetch_assoc($res);
    // обязательные поля
    $sql = "UPDATE tblinform2 SET user_id='$user_id' WHERE inv_id='$str_n'";
    //Get records from database
    if (mysqli_query($mysqli, $sql) === TRUE) {
        header("location: ../../includes/info.ok.php?info=1");
    } else {
        header("location: ../../includes/info.error.php?info=1");
    };
    $name1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['name1']));
    if ($name1 != $node['node_old']) {
        $sql = "UPDATE tblinform2 SET node_old='$name1' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $country2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['country2']));
    if ($country2 != $node['country_id']) {
        $sql = "UPDATE tblinform2 SET country_id='$country2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $area2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['area2']));
    if ($area2 != $node['area_id']) {
        $sql = "UPDATE tblinform2 SET area_id='$area2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $town2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['town2']));
    if ($town2 != $node['town_id']) {
        $sql = "UPDATE tblinform2 SET town_id='$town2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $address1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['address1']));
    if ($address1 != $node['address']) {
        $sql = "UPDATE tblinform2 SET address='$address1' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $status2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status2']));
    if ($status2 != $node['status_d']) {
        $sql = "UPDATE tblinform2 SET status_d='$status2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $lease2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['lease2']));
    if ($lease2 != $node['lease_category_d']) {
        $sql = "UPDATE tblinform2 SET lease_category_d='$lease2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $class1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['class1']));
    if ($class1 != $node['nclass_d']) {
        $sql = "UPDATE tblinform2 SET nclass_d='$class1' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    // остальные поля
    $planner1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['planner1']));
    if ($planner1 != '') {
        $sql = "UPDATE tblinform2 SET planerid='$planner1' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    //Доступ к узлу
    $note1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['note1']));
    if ($note1 != '') {
        $sql = "UPDATE tblinform2 SET node_memo='$note1' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $access2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['access2']));
    if ($access2 != 0) {
        $sql = "UPDATE tblinform2 SET access_mode='$access2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $note4 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['note4']));
    if ($note4 != '') {
        $sql = "UPDATE tblinform2 SET owner='$note4' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    //Кондиционирование
    $system2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['system2']));
    if ($system2 != 0) {
        $sql = "UPDATE tblinform2 SET condition_category='$system2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $proprietor2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['proprietor2']));
    if ($proprietor2 != 0) {
        $sql = "UPDATE tblinform2 SET cond_owner='$proprietor2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    //Электропитание
    $grounding2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['grounding2']));
    if ($grounding2 != 0) {
        $sql = "UPDATE tblinform2 SET ground='$grounding2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $generator2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['generator2']));
    if ($generator2 != 0) {
        $sql = "UPDATE tblinform2 SET el_generator='$generator2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $battery2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['battery2']));
    if ($battery2 != 0) {
        $sql = "UPDATE tblinform2 SET el_battery='$battery2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $acdc1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['acdc1']));
    if ($acdc1 != '') {
        $sql = "UPDATE tblinform2 SET el_type='$acdc1' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $note2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['note2']));
    if ($note2 != '') {
        $sql = "UPDATE tblinform2 SET el_equipment='$note2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $power1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['power1']));
    if ($power1 != '') {
        $sql = "UPDATE tblinform2 SET el_power_d='$power1' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $autonomy1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['autonomy1']));
    if ($autonomy1 != '') {
        $sql = "UPDATE tblinform2 SET el_autonomy_d='$autonomy1' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    //Система контроля и сигнализации
    $note3 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['note3']));
    if ($note3 != '') {
        $sql = "UPDATE tblinform2 SET signalling_type='$note3' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $outpower2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['outpower2']));
    if ($outpower2 != 0) {
        $sql = "UPDATE tblinform2 SET m_power='$outpower2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $doors2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['doors2']));
    if ($doors2 != 0) {
        $sql = "UPDATE tblinform2 SET m_door='$doors2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $temr2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['temr2']));
    if ($temr2 != 0) {
        $sql = "UPDATE tblinform2 SET m_temperature='$temr2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $humidity2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['humidity2']));
    if ($humidity2 != 0) {
        $sql = "UPDATE tblinform2 SET m_humidity='$humidity2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $smoke2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['smoke2']));
    if ($smoke2 != 0) {
        $sql = "UPDATE tblinform2 SET m_smoke='$smoke2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    $water2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['water2']));
    if ($water2 != 0) {
        $sql = "UPDATE tblinform2 SET m_water='$water2' WHERE inv_id='$str_n'";
        $temp = mysqli_query($mysqli, $sql);
    };
    // закрываем подключение
    mysqli_close($mysqli);
?>