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
    // поиск max(inv_id)
    $sql = 'SELECT max(inv_id) as id FROM tblinform2';
    $res = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($res);
    $str_n = (int) $row['id'] + 1;
    // обязательные поля
    $name1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['name1']));
    $country2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['country2']));
    $area2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['area2']));
    $town2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['town2']));
    $address1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['address1']));
    $status2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status2']));
    $lease2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['lease2']));
    $class1 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['class1']));
    $sql = "INSERT INTO tblinform2 (inv_id, node_old, country_id, area_id, town_id, address, lease_category_d, status_d, nclass_d, user_id)
            VALUES ('$str_n','$name1','$country2','$area2','$town2','$address1','$lease2','$status2','$class1','$user_id')";
    //Get records from database
    if (mysqli_query($mysqli, $sql) === TRUE) {
        header("location: ../../includes/info.ok.php?info=1");
    } else {
        header("location: ../../includes/info.error.php?info=1");
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
    // открытие ТТ - если status = 'тестовая эксплуатация'
    if ($status2 == 1) {
        // берем время с сервера
        $sql = 'SELECT NOW() as dt';
        $temp = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_assoc($temp);
        $dt_str = htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d H:i:s", strtotime($row['dt']))));
        $date_raw = (date('s') + strtotime("+13 day"));
        switch (date('l', $date_raw)) {
            case 'Saturdey':
                $str = (date('s') + strtotime("+12 day"));
                $dt_out = date('Y-m-d', $str);
                break;
            case 'Sunday':
                $str = (date('s') + strtotime("+11 day"));
                $dt_out = date('Y-m-d', $str);
                break;
            default:
                $dt_out = date('Y-m-d', $date_raw);
        };
        $str_d = date('Y-m-d'); $str_t = date('H:i:s');
        // !!! подкорректировать поле user_id
        $sql = "INSERT INTO trubl (inv_num_kli, date_of_start, time_of_start, description, type_trubl_d, name_user, user_id, date_of_open, last_zapisi, tab_on, state_tt, ring_on,
                    sostoyanie, otlogeno_data, otlogeno_time)
                    VALUES ('$str_n','$str_d','$str_t','Прием в эксплуатацию','6','$user_nik','2400029','$dt_str','$dt_str','4','2','0',
                    'отложено','$dt_out','10:00:00')";
        $temp = mysqli_query($mysqli, $sql);
        $sql = "SELECT num_of_trubl_tick FROM trubl WHERE (inv_num_kli='$str_n') AND (date_of_start='$str_d') AND (sostoyanie='отложено')";
        $temp = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_assoc($temp);
        $str_tt = $row['num_of_trubl_tick'];
        $str = 'До : '.$dt_out.' 10:00:00, Причина: Истек срок приема в эксплуатацию, приймите решение, по результату измените статус объекта на который открыт ТТ';
        $sql = "INSERT INTO zapisi_trubl_tic (num_trubl, date_zapisi, time_zapisi, kontakt, desc_zapisi, name_user, col_centr, transition)
                        VALUES ('$str_tt','$str_d','$str_t','Отложено','$str','$user_nik','0','23')";
        $temp = mysqli_query($mysqli, $sql);
    };
    // добавить запись в табл tab_status_history
    $status = htmlentities(mysqli_real_escape_string($mysqli, $_POST['status']));
    $sql = "INSERT INTO tab_status_history  (id_zapisi, id_tab, old_status, new_status) VALUES ('$str_n','4','-','$status')";
    $temp = mysqli_query($mysqli, $sql);
    // закрываем подключение
    mysqli_close($mysqli);
?>