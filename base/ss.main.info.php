<?php
header("Content-Type: text/html; charset=utf-8");
if (!isset($_GET['ss_id'])) {
    header("location: ../includes/info.error.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/fieldset.css" />
    <title>info: Сетевые Соединения #<?php echo $_GET['ss_id'] ?></title>
</head>
<body>
<?php
require "../includes/constants.php";
//Open database connection
$mysqli = mysqli_connect($host,$user,$password,$db);

$sql = "SELECT * FROM net_links WHERE id_link = ".$_GET['ss_id'];
$res = mysqli_query($mysqli, $sql);
$link = mysqli_fetch_assoc($res);
echo '<div><b>'.$link['sign_net'].' + '.$link['sign_net2'].'</b></div>';
switch($link['flag_link']) {
    case 0:
        echo '<div>Соединение - сетевое</div>';
        break;
    case 1:
        echo '<div>Соединение - сервисное</div>';
        break;
    case 2:
        echo '<div>Соединение - межсетевое</div>';
        break;
    case 3:
        echo '<div>Сервис провайдера</div>';
        $sql = "SELECT client FROM tab_klients WHERE id = ".$link['equip_b'];
        $res = mysqli_query($mysqli, $sql);
        $temp = mysqli_fetch_assoc($res);
        echo '<div>Партнер - '.$temp['client'].', CID = '.$link['port_b'].'</div>';
        break;
};
echo '<div>'.$link['name'].'</div>';
echo '<div>CID-ы: '.$link['pointer_1'].', '.$link['pointer_2'].', '.$link['pointer_3'].', '.$link['pointer_4'].', '.$link['pointer_5'].', '.$link['pointer_6'].', '.$link['pointer_7'].', '.$link['pointer_8'].
     ', '.$link['pointer_9'].', '.$link['pointer_10'].', '.$link['pointer_11'].', '.$link['pointer_12'].', '.$link['pointer_13'].', '.$link['pointer_14'].', '.$link['pointer_15'].'</div>';
echo '<b>Схема:</b>';
echo '<div>'.$link['scheme'].'</div>';
echo '<b>Примечание:</b>';
echo '<div>'.$link['note'].'</div>';
$sql = "SELECT name FROM tab_status WHERE id = ".$link['status_d'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
echo '<div><b>Статус:</b>'.$temp['name'].'</div>';
echo '<div>в эксплуатации: '.date("m.d.Y",strtotime($link['in_exp'])).'</div>';
if($link['out_exp'] == '0000-00-00') {
    $temp_str = "";
} else {
    $temp_str = date("m.d.Y",strtotime($link['out_exp']));
}
echo '<div>демонтирован:'.$temp_str.'</div>';
echo '<div>Особенности приема в эксплуатацию:'.$link['inexp'].'</div>';
echo '<div>ID в планере:'.$link['planerid'].'</div>';

mysqli_close($mysqli);
?>
</body>
</html>