<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
    session_start();
    if(!isset($_SESSION["session_username"])) {
        header("location: ../../index.html");
    };
    header("Content-Type: text/html; charset=utf-8");
    if (!isset($_GET['outs_id'])) {
       header("location: ../../includes/info.error.php");
    }
?>
<!DOCTYPE html>
<html>
<head> 
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="../css/fieldset.css" />
  <title>info: Аутсорсинг #<?php echo $_GET['outs_id'] ?></title>
</head>
<body>
<?php	
    require "../../includes/constants.php";
	//Open database connection
    $mysqli = mysqli_connect($host,$user,$password,$db)
                or die("Ошибка " . mysqli_error($mysqli));
	$sql = "SELECT * FROM outs_hardware WHERE  outs_id=".$_GET['outs_id'];
    $res = mysqli_query($mysqli, $sql);
    $outs = mysqli_fetch_assoc($res);
	$sql = "select o.id_kli, o.klient, o.country_id, o.area_id, o.town_id, o.street, o.kont_tel, o.kont_email, o.device, o.device_id, o.port, o.CID_1, o.CID_2, o.CID_3, o.CID_4, o.CID_5,
            o.chart_joint, o.chart_joint_nc, o.office, o.speed, o.equip, o.planerid, o.retail, o.inexp, o.status_d, o.note, o.in_exp, o.out_exp, k.*, t.town, c.country, a.region, s.name 
            from office_kli o, tab_klients k, tab_town t, tab_country c, tab_area a, tab_status s 
            where o.klient = k.id and t.id=o.town_id and o.country_id=c.id and o.area_id=a.id and o.status_d=s.id 
            and o.id_kli = ".$outs['clients'];
    $res = mysqli_query($mysqli, $sql);
    $kli = mysqli_fetch_assoc($res);

	echo '<div><font color="red"><b>'.$kli['client'].', '.$kli['town'].', '.$kli['street'].'</b></font></div>';
	echo '<div>'.$kli['country'].', '.$kli['region'].' обл.</div>';
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
    echo '<div>в эксплуатации: '.date("m.d.Y",strtotime($kli['in_exp'])).'</div>';
    if($kli['out_exp'] == '0000-00-00') {
        $temp_str = "";
    } else {
        $temp_str = date("m.d.Y",strtotime($kli['out_exp']));
    }
    echo '<div>демонтирован:'.$temp_str.'</div>';
	echo '<div>ID в планере: '.$kli['planerid'].'</div>';

	$sql = "SELECT nik FROM equipments2 WHERE id = ".$kli['equip'];
    $res = mysqli_query($mysqli, $sql);
    $temp = mysqli_fetch_assoc($res);

    echo '<div>'.$temp['nik'].'</div>';
    echo '<div><font color="red">Контакт главного офиса: '.$kli['admin'].'</font></div>';
    echo '<div><font color="red">'.$kli['admin_phone'].', '.$kli['admin_email'].', '.$kli['admin_fax'].', '.$kli['comment'].'</font></div>';

	$sql = "SELECT nik FROM tab_access WHERE id=".$kli['manager'];
    $res = mysqli_query($mysqli, $sql);
    $temp = mysqli_fetch_assoc($res);

    echo '<div>Ответственный менеджер: '.$temp['nik'].'</div>';
    echo '<div>-------------------------------</div>';

	$sql1 = "SELECT e.*, i.town_id, i.address, concat_WS(' ',t.town,i.address) as addr, t.town, n.net, b.brend, b.model 
	        FROM net_equip e, tblinform2 i, tab_town t, tab_nets n, tab_equip b 
            WHERE e.linkage='0' AND e.num_node=i.inv_id AND i.town_id=t.id AND i.town_id=t.id AND e.net=n.id AND e.num_equip=b.id 
            AND e.id_equip = ".$outs['hardware'];
    $sql2 = "SELECT e.*, o.town_id, o.street, concat_WS(' ',k.client,o.street) as addr, k.client, n.net, b.brend, b.model 
            FROM net_equip e, office_kli o, tab_klients k, tab_nets n, tab_equip b 
            WHERE e.linkage='1' AND e.num_node=o.id_kli AND o.klient=k.id AND e.net=n.id AND e.num_equip=b.id 
            AND e.id_equip = ".$outs['hardware'];
    $sql = $sql1." UNION ALL ".$sql2;
    $res = mysqli_query($mysqli, $sql);
    $equ = mysqli_fetch_assoc($res);

	echo '<div><b>'.$equ['net'].'</b></div>';
    echo '<div><font color="maroon">'.$equ['ip_address'].'</font></div>';
	echo '<div>'.$equ['name_nms'].'</div>';
	echo '<div>'.$equ['addr'].'</div>';
	echo '<div>'.$equ['brend'].' '.$equ['model'].'</div>';
	echo '<div>'.$equ['scheme'].'</div>';


    $sql = "SELECT name FROM tab_status WHERE id = ".$equ['status_d'];
    $res = mysqli_query($mysqli, $sql);
    $temp = mysqli_fetch_assoc($res);	

    echo '<div><b>Статус:</b> '.$temp['name'].'</div>';
    echo '<div>в эксплуатации: '.date("d.m.Y",strtotime($equ['in_exp'])).'</div>';
    if($equ['out_exp'] == '0000-00-00') {
        $temp_str = "";
    } else {
        $temp_str = date("d.m.Y",strtotime($equ['out_exp']));
    }
    echo '<div>демонтирован:'.$temp_str.'</div>';

	if ($equ['linkage'] = 0){
	    $sql = "SELECT owner FROM tblinform2 WHERE inv_id = ".$equ['num_node'];
    	$res = mysqli_query($mysqli, $sql);
    	$temp = mysqli_fetch_assoc($res);
    	echo '<div><b>Контакты (узел):</b></div>';	
    	echo '<div>'.$temp['owner'].'</div>';	
	} else {
	    $sql = "SELECT kont_tel FROM office_kli WHERE id_kli = ".$equ['num_node'];
    	$res = mysqli_query($mysqli, $sql);
    	$temp = mysqli_fetch_assoc($res);
    	echo '<div><b>Контакты (офис):</b></div>';	
    	echo '<div>'.$temp['kont_tel'].'</div>';		
	}

    $sql = "SELECT brend,model,power FROM tab_equip WHERE id = ".$equ['num_equip'];
    $res = mysqli_query($mysqli, $sql);
    $temp = mysqli_fetch_assoc($res);	
    echo '<div>'.$temp['brend'].' '.$temp['model'].'</div>';
    echo '<div>Потребляет: '.$temp['power'].' Вт'.'</div>';
    echo '<div>Версия ПО: '.$equ['num_ver'].'</div>';
    echo '<div>№ в планере: '.$equ['planerid'].'</div>';

    if ($equ['net']='WiPLL' or $equ['net']='OFDM' or $equ['net']='DECT' or $equ['net']='AiReach' or $equ['net']='NEC' or $equ['net']='SAF') {
	    $sql = "SELECT name FROM tab_installer WHERE id = ".$equ['installer'];
    	$res = mysqli_query($mysqli, $sql);
    	$temp = mysqli_fetch_assoc($res); 
    	echo '<div>Инсталятор: '.$temp['name'].' Вт'.'</div>';   
    	echo '<div>Номер БС: '.$equ['num_bs'].'</div>';	
    	echo '<div>Номер сектора: '.$equ['num_sect'].'</div>';	
    	echo '<div>Частота: '.$equ['rate1'].'</div>';	
    	echo '<div>Угол наклона: '.$equ['corner1'].'</div>';	
    	echo '<div>Азимут: '.$equ['azimuth1'].'</div>';	
    	echo '<div>ID сектора: '.$equ['id_sect1'].'</div>';	
    	echo '<div>AIRMAC: '.$equ['airmac1'].'</div>';	
    	echo '<div>Полоса пропускания (МГц): '.$equ['bandwidth1'].'</div>';	
    }
    echo '<div>-------------------------------</div>';

    echo '<div><b>Серийный номер:</b> '.$outs['serial'].'</div>';
    echo '<div><b>Тип лицензии:</b> '.$outs['license'].'</div>';
    echo '<div><b>Примечание:</b> '.$outs['info'].'</div>';

   mysqli_close($mysqli); 
?>
</body>
</html>