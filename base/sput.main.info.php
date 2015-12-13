<?php
header("Content-Type: text/html; charset=utf-8");
if (!isset($_GET['sput_id'])) {
    header("location: ../includes/info.error.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/fieldset.css" />
    <title>info: Сервисы Клиентов #<?php echo $_GET['sput_id'] ?></title>
</head>
<body>
<?php
require "../includes/constants.php";
//Open database connection
$mysqli = mysqli_connect($host,$user,$password,$db)
                or die("Ошибка " . mysqli_error($mysqli));

$sql = 'SELECT k.client, c.country, a.region, t.town, o.street, o.office, o.kont_tel, o.kont_email, o.in_exp, q.name_nms, q.scheme, concat(tq.brend," ",tq.model) as brend_model, s.name
        FROM office_kli o, tab_klients k, tab_town t, tab_country c, tab_area a, net_equip q, tab_nets n, tab_status s, tab_equip tq
        WHERE o.klient = k.id and t.id=o.town_id and o.country_id=c.id and o.area_id=a.id and o.id_kli = q.num_node and q.linkage="1" and q.net=n.id and o.status_d=s.id and q.num_equip=tq.id
        and (n.sector = "SS") and o.id_kli='.$_GET["sput_id"];
$res = mysqli_query($mysqli, $sql);
$sSput = mysqli_fetch_assoc($res);

echo '<div><font color="#8b0000">Станция: </font>'.$sSput['name_nms'].'</div>';
echo '<div><font color="#8b0000">Клиент: </font>'.$sSput['client'].'</div>';
echo '<div><font color="#8b0000">Страна: </font>'.$sSput['country'].'</div>';
echo '<div><font color="#8b0000">Область: </font>'.$sSput['region'].'</div>';
echo '<div><font color="#8b0000">Город: </font>'.$sSput['town'].'</div>';
echo '<div><font color="#8b0000">Адрес: </font>'.$sSput['street'].'</div>';
echo '<div><font color="#8b0000">Контакт: </font>'.$sSput['kont_tel'].', '.$sSput['kont_email'].'</div>';
switch($sSput['office']) {
    case 0:
        $temp_str = "?";
        break;
    case 1:
        $temp_str = "ГО(главный офис)";
        break;
    case 2:
        $temp_str = "офис";
        break;
    case 3:
        $temp_str = "банкомат, терминал";
        break;
}
echo '<div><font color="#8b0000">Статус: </font>'.$temp_str.'</div>';
echo '<div><font color="#8b0000">Состояние: </font>'.$sSput['name'].'</div>';
$temp_str = date("d.m.Y",strtotime($sSput['in_exp']));
echo '<div><font color="#8b0000">Дата: </font>'.$temp_str.'</div>';
echo '<div><font color="#8b0000">Схема канала: </font>'.$sSput['scheme'].'</div>';

mysqli_free_result($res);
mysqli_close($mysqli);
?>
</body>
</html>