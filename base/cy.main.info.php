<?php
header("Content-Type: text/html; charset=utf-8");
if (!isset($_GET['cy_id'])) {
    header("location: ../includes/info.error.php");
}
?>
    <!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/fieldset.css" />
        <title>info: Сетевые Устройства #<?php echo $_GET['cy_id'] ?></title>
    </head>
    <body>
<?php
require "../includes/constants.php";
//Open database connection
$mysqli = mysqli_connect($host,$user,$password,$db)
                or die("Ошибка " . mysqli_error($mysqli));

$sql = 'SELECT e.*, i.town_id, i.address, concat_WS(" ",t.town,i.address) as addr, t.town, n.net AS net1, b.brend, b.model
        FROM klients.net_equip e, klients.tblinform2 i, klients.tab_town t, tab_nets n, tab_equip b
        WHERE e.linkage="0" AND e.num_node=i.inv_id AND i.town_id=t.id AND i.town_id=t.id AND e.net=n.id AND e.num_equip=b.id
        AND e.id_equip = '.$_GET['cy_id'].'
        UNION ALL
        SELECT e.*, o.town_id, o.street, concat_WS(" ",k.client,o.street) as addr, k.client, n.net AS net1, b.brend, b.model
        FROM klients.net_equip e, klients.office_kli o, klients.tab_klients k, tab_nets n, tab_equip b
        WHERE e.linkage="1" AND e.num_node=o.id_kli AND o.klient=k.id AND e.net=n.id AND e.num_equip=b.id
        AND e.id_equip = '.$_GET['cy_id'];
$res = mysqli_query($mysqli, $sql);
$equip = mysqli_fetch_assoc($res);
echo '<div><b>'.$equip['net1'].'</b></div>';
echo '<div><font color="red">'.$equip['ip_address'].'</font></div>';
echo '<div>'.$equip['name_nms'].'</div>';
echo '<div>'.$equip['addr'].'</div>';
echo '<div>'.$equip['brend'].' '.$equip['model'].'</div>';
echo '<div>'.$equip['scheme'].'</div>';
$sql = "SELECT name FROM tab_status WHERE id = ".$equip['status_d'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
echo '<div><b>Статус: </b>'.$temp['name'].'</div>';
echo '<div>в эксплуатации: '.date("m.d.Y",strtotime($equip['in_exp'])).'</div>';
if($equip['out_exp'] == '0000-00-00') {
    $temp_str = "";
} else {
    $temp_str = date("m.d.Y",strtotime($equip['out_exp']));
}
echo '<div>демонтирован: '.$temp_str.'</div>';
echo '<div></div>';
if($equip['linkage'] == 0) {
    $sql = "SELECT owner FROM tblinform2 WHERE inv_id =  ".$equip['num_node'];
    $res = mysqli_query($mysqli, $sql);
    $temp = mysqli_fetch_assoc($res);
    echo '<div><b>Контакты (узел): </b>'.$temp['owner'].'</div>';
};
if($equip['linkage'] == 1) {
    $sql = "SELECT kont_tel FROM office_kli WHERE id_kli =  ".$equip['num_node'];
    $res = mysqli_query($mysqli, $sql);
    $temp = mysqli_fetch_assoc($res);
    echo '<div><b>Контакты (офис): </b>'.$temp['kont_tel'].'</div>';
};
echo '<div></div>';
$sql = "SELECT brend,model,power FROM tab_equip WHERE id = ".$equip['num_equip'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
echo '<div>'.$temp['brend'].' '.$temp['model'].'</div>';
echo '<div>Потребляет: '.$temp['power'].' Вт</div>';
echo '<div>Версия ПО: '.$equip['num_ver'].'</div>';
echo '<div>№ в планере: '.$equip['planerid'].'</div>';
$radio = array("WiPLL","OFDM","DECT","AiReach","NEC","SAF");
if(in_array($equip['net1'],$radio)) {
    echo '<div></div>';
    $sql = "SELECT name FROM tab_installer WHERE id = ".$equip['installer'];
    $res = mysqli_query($mysqli, $sql);
    $temp = mysqli_fetch_assoc($res);
    echo '<div>Инсталятор: '.$temp['name'].'</div>';
    echo '<div>Номер БС: '.$equip['num_bs'].'</div>';
    echo '<div>Номер сектора: '.$equip['num_sect'].'</div>';
    echo '<div>Частота: '.$equip['rate1'].'</div>';
    echo '<div>Угол наклона: '.$equip['corner1'].'</div>';
    echo '<div>Азимут: '.$equip['azimuth1'].'</div>';
    echo '<div>ID сектора: '.$equip['id_sect1'].'</div>';
    echo '<div>AIRMAC: '.$equip['airmac1'].'</div>';
    echo '<div>Полоса пропускания (МГц): '.$equip['bandwidth1'].'</div>';
};

mysqli_free_result($res);
mysqli_close($mysqli);
?>
    </body>
</html>