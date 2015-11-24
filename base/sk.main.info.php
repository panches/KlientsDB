<?php
header("Content-Type: text/html; charset=utf-8");
if (!isset($_GET['sk_id'])) {
    header("location: ../includes/info.error.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/fieldset.css" />
    <title>info: Сервисы Клиентов #<?php echo $_GET['sk_id'] ?></title>
</head>
<body>
<?php
require "../includes/constants.php";
//Open database connection
$mysqli = mysqli_connect($host,$user,$password,$db);

$sql = "SELECT * FROM net_data WHERE id_data = ".$_GET['sk_id'];
$res = mysqli_query($mysqli, $sql);
$sKli = mysqli_fetch_assoc($res);

$sql = "SELECT name FROM tab_katal_sk_type WHERE id = ".$sKli['type_serv_d'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
$str4 = $temp['name'];
$sql = "SELECT client FROM tab_klients WHERE id = ".$sKli['client'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
$str5 = $temp['client'];
$sql = "SELECT town,street FROM office_kli o, tab_town t WHERE t.id=o.town_id AND o.id_kli= ".$sKli['office_a'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
$str0 = $temp['town'];
$str1 = $temp['street'];
$sql = "SELECT town,street FROM office_kli o, tab_town t WHERE t.id=o.town_id AND o.id_kli= ".$sKli['office_b'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
$str2 = $temp['town'];
$str3 = $temp['street'];
if($str0 == $str2) {
    if($sKli['speed'] == '') { $str = '?'; }
    else { $str = $sKli['speed'];  };
    $nameKli = "СК - ".$str5.", ".$str4.", ".$str."M, (".$str0.", ".$str1." - ".$str3.")";
} else {
    if($sKli['speed'] == '') { $str = '?'; }
    else { $str = $sKli['speed'];  };
    $nameKli = "СК - ".$str5.", ".$str4.", ".$str."M, (".$str0.", ".$str1." - ".$str2.", ".$str3.")";
};
echo '<div><b>'.$nameKli.'</b></div>';
$sql = "SELECT nik FROM tab_access WHERE id IN (SELECT manager FROM tab_klients WHERE id = ".$sKli['client'].")";
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
$manager = $temp['nik'];
// клиент А
$sql = "SELECT o.street, k.client, k.manager, t.town, o.device_id, o.port, o.chart_joint, o.office
        FROM office_kli o, tab_klients k, tab_town t, tab_country c, tab_area a, tab_status s
        WHERE o.klient = k.id and t.id=o.town_id and o.country_id=c.id and o.area_id=a.id and o.status_d=s.id and o.id_kli = ".$sKli['office_a'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
$of1 = $temp['office'];
$dv1 = $temp['device_id'];
$port1 = $temp['port'];
$chart1 = $temp['chart_joint'];
// клиент Б
$sql = "SELECT o.street, k.client, t.town, o.device_id, o.port, o.chart_joint, o.office
        FROM office_kli o, tab_klients k, tab_town t, tab_country c, tab_area a, tab_status s
        WHERE o.klient = k.id and t.id=o.town_id and o.country_id=c.id and o.area_id=a.id and o.status_d=s.id and o.id_kli = ".$sKli['office_b'];
$of2 = $temp['office'];
$dv2 = $temp['device_id'];
$port2 = $temp['port'];
$chart2 = $temp['chart_joint'];
echo '<div>CID: '.$sKli['CID'].'</div>';
$sql = "SELECT name FROM tab_katal_office_status WHERE id = ".$of1;
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
$str1 = $temp['name'];
$sql = "SELECT name FROM tab_katal_office_status WHERE id = ".$of2;
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
echo '<div>'.$str1.' --- '.$temp['name'].'</div>';
echo '<div></div>';
echo '<div><b>Трасса для расчитываемой схемы: </b>'.$sKli['ras_scheme'].'</div>';
// поиск записи устройства А по номеру
$sql = "SELECT net,name_nms FROM net_equip WHERE id_equip = ".$dv1;
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
$str1 = $temp['name_nms'];
$sql = "SELECT net FROM tab_nets WHERE id = ".$temp['net'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
echo '<div>ПМ офис А: <b>'.$temp['net'].'/'.$str1.' '.$port1.' --- '.$chart1.'</b></div>';
echo '<div>Между офисами: '.$sKli['ras_scheme'].'</div>';
// поиск записи устройства Б по номеру
$sql = "SELECT net,name_nms FROM net_equip WHERE id_equip = ".$dv2;
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
$str1 = $temp['name_nms'];
$sql = "SELECT net FROM tab_nets WHERE id = ".$temp['net'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
echo '<div>ПМ офис Б: <b>'.$temp['net'].'/'.$str1.' '.$port2.' --- '.$chart2.'</b></div>';
echo '<div></div>';
echo '<div>Трасса по сети (текст): </div>';
echo '<div>'.$sKli['shema'].'</div>';
echo '<div>Примечание: </div>';
echo '<div>'.$sKli['comment'].'</div>';
$sql = "SELECT name FROM tab_status WHERE id = ".$sKli['status_d'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
if($sKli['out_exp'] == '0000-00-00') {
    echo '<div>Статус: '.$temp['name'].' '. date("m.d.Y",strtotime($sKli['in_exp'])).'</div>';
} else {
    echo '<div>Статус: '.$temp['name'].', в эксплуатации: '.date("m.d.Y",strtotime($sKli['in_exp'])).', демонтирован: '.date("m.d.Y",strtotime($sKli['out_exp'])).'</div>';
};
echo '<div>Особенности приема в эксплуатацию: '.$sKli['inexp'].'</div>';
// менеджер
echo '<div><b>Менеджер: </b>'.$manager.'<b>, № в планере: </b>'.$sKli['planerid'].'</div>';
echo '<div></div>';
$sql = "SELECT o.kont_tel, o.kont_email, o.chart_joint, k.client, k.admin, k.admin_phone, k.admin_email, k.admin_fax
        FROM office_kli o, tab_klients k
        WHERE o.klient = k.id and id_kli = ".$sKli['office_a'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
echo '<div><font color="blue">Контакт Офиса А: '.$temp['client'].'</font></div>';
echo '<div>'.$temp['kont_tel'].'</div>';
echo '<div>'.$temp['kont_email'].'</div>';
$sql = "SELECT o.kont_tel, o.kont_email, o.chart_joint, k.client, k.admin, k.admin_phone, k.admin_email, k.admin_fax
        FROM office_kli o, tab_klients k
        WHERE o.klient = k.id and id_kli = ".$sKli['office_b'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
echo '<div><font color="blue">Контакт Офиса Б: '.$temp['client'].'</font></div>';
echo '<div>'.$temp['kont_tel'].'</div>';
echo '<div>'.$temp['kont_email'].'</div>';
$sql = "SELECT * FROM tab_klients WHERE id = ".$sKli['client'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
echo '<div><font color="#8b0000">Контакт главного Офиса: </font>'.$temp['client'].'</div>';
echo '<div>'.$temp['admin'].'</div>';
echo '<div>'.$temp['admin_phone'].', '.$temp['admin_email'].', '.$temp['admin_fax'].', '.$temp['comment'].'</div>';


mysqli_close($mysqli);
?>
</body>
</html>