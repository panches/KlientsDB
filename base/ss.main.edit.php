<?php
/** Date: 23.12.2015 */
header("Content-Type: text/html; charset=utf-8");

if (!isset($_GET['ss_id'])) {
    header("location: ../includes/info.error.php");
};

switch ($_GET['ss_link']) {
    case 'сетевое':
        include('ss.main.edit1.php');
        break;

    case 'сервисное':
        echo 'сервисное';
        break;

    case 'межсетевое':
        include('ss.main.edit2.php');
        break;

    case 'сервис провайдера':
        include('ss.main.edit3.php');
        break;
};

?>