<?php
header("Content-Type: text/html; charset=utf-8");
if (!isset($_GET['ok_id'])) {
    header("location: ../../includes/info.error.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/fieldset.css" />
    <title>info: Офис Клиента #<?php echo $_GET['ok_id'] ?></title>
</head>
<body>
<?php
require "../../includes/constants.php";
//Open database connection
$mysqli = mysqli_connect($host,$user,$password,$db);
echo '<div class="container-fluid">';
$sql = "select o.id_kli, o.klient, o.country_id, o.area_id, o.town_id, o.street, o.kont_tel, o.kont_email, o.device, o.device_id,
          o.port, o.CID_1, o.CID_2, o.CID_3, o.CID_4, o.CID_5, o.chart_joint, o.chart_joint_nc, o.office, o.speed, o.equip, o.planerid,
          o.retail, o.inexp, o.status_d, o.note, o.in_exp, o.out_exp, k.admin_phone, k.*, t.town, c.country, a.region, s.name
        from office_kli o, tab_klients k, tab_town t, tab_country c, tab_area a, tab_status s
        where o.klient = k.id and t.id=o.town_id and o.country_id=c.id and o.area_id=a.id and o.status_d=s.id
        and o.id_kli = ".$_GET['ok_id'];
$res = mysqli_query($mysqli, $sql);
$kli = mysqli_fetch_assoc($res);
echo '<div><font color="red"><b>'.$kli['client'].', '.$kli['town'].', '.$kli['street'].'</b></font></div>';
echo '<div>'.$kli['country'].', '.$kli['region'].' обл.</div>';
echo '<div></div>';
echo '<div><b>Контакт локального офиса: </b><font color="blue">'.$kli['kont_tel'].'</font></div>';
if($kli['kont_email'] != '') {
    echo '<div>'.$kli['kont_email'].'</div>';
}
echo '<div>Схема ПМ:</div>';
$sql = "SELECT net, name_nms FROM net_equip WHERE id_equip=".$kli['device_id'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
$str = $temp['name_nms'];
$sql = "SELECT net FROM tab_nets WHERE id=".$temp['net'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
echo '<div>'.$temp['net'].'/'.$str.' '.$kli['port'].' --- '.$kli['chart_joint'].'</div>';
echo '<div>Примечание: '.$kli['note'].'</div>';
echo '<div>'.$kli['chart_joint_nc'].'</div>';
echo '<div>Скорость: '.$kli['speed'].' Mbps</div>';
echo '<div>Статус: '.$kli['name'].'</div>';
echo '<div>в эксплуатации: '.date("d.m.Y",strtotime($kli['in_exp'])).'</div>';
if($kli['out_exp'] == '0000-00-00') {
    $temp_str = "";
} else {
    $temp_str = date("d.m.Y",strtotime($kli['out_exp']));
}
echo '<div>демонтирован:'.$temp_str.'</div>';
echo '<div>ID в планере: '.$kli['planerid'].'</div>';
$sql = "SELECT nik FROM equipments2 WHERE id = ".$kli['equip'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
echo '<div>'.$temp['nik'].'</div>';
echo '<div><font color="red">Контакт главного офиса:</font> '.$kli['admin'].'</div>';
echo '<div>'.$kli['admin_phone'].', '.$kli['admin_email'].', '.$kli['admin_fax'].', '.$kli['Comment'].'</div>';
$sql = "SELECT nik FROM tab_access WHERE id=".$kli['manager'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
echo '<div><b>Ответственный менеджер:</b> '.$temp['nik'].'</div>';
echo '</div>';
mysqli_close($mysqli);
?>
</body>
</html>