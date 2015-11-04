<?php
  header("Content-Type: text/html; charset=utf-8");
  if (!isset($_GET['tt_id'])) { 
     echo '<div><font color="red"><b>Не выбрана запись!</b></font></div>'; exit();  
  }   
?>
<!DOCTYPE html>
<html>
<head> 
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="css/fieldset.css" />
  <title>Инфо. о TT #<?php echo $_GET['tt_id']; ?> </title>
</head>
<body>
<?php	
    require "../includes/constants.php";
	//Open database connection
    $mysqli = mysqli_connect($host,$user,$password,$db);
    $sql = 'SELECT t.tab_on,t.inv_num_kli,GetNameOfClient(t.tab_on,t.inv_num_kli) AS klient_calc,t.description,c.type_tt 
            FROM trubl t, category_type_tt c WHERE (c.id = t.type_trubl_d) AND num_of_trubl_tick='.$_GET['tt_id']; 
    $res = mysqli_query($mysqli, $sql);
    $trubl = mysqli_fetch_assoc($res);

    //echo '<div><font color="red"><b>'.$trubl['inv_num_kli'].', '.$trubl['tab_on'].'</b></font></div>';

    // Сервисы
    switch ($trubl['tab_on']) {
    case 0 :
    	echo '<div><font color="red"><b>Не используется!</b></font></div>';
      break;
    // Регламентные работы
    case 1 :
		  echo '<div>Регламентные работы:</div>';
      $sql = 'SELECT * FROM reglament WHERE reg_id = '.$trubl['inv_num_kli'];
    	$res = mysqli_query($mysqli, $sql);
    	$reglament = mysqli_fetch_assoc($res);
    	echo '<div><b>Начало работ:</b> '.date("d.m.Y", strtotime($reglament['beg_date'])).'</div>';
      echo '<div><b>Суть работ:</b></div>';
      echo '<div>'.$reglament['klient'].'</div>';
      echo '<div>'.$reglament['addres_bid'].'</div>';
      echo '<div><b>Кто подал заявку:</b></div>';
      echo '<div>'.$reglament['name_bid'].'</div>';
      echo '<div><b>Письмо:</b></div>';
      echo '<div>'.$reglament['mail_from'].'</div>';
      echo '<div><b>Примечание:</b></div>';
      echo '<div>'.$reglament['note_bid'].'</div>';
      echo '<div><b>Заявка подана:</b> '.$reglament['start_dt'].'</div>';
      break;
    // Collocation
    case 2 :
      echo '<div>Collocation:</div>';
      $sql = 'SELECT c.id_col, c.equip, c.numst, c.musor, c.kli_id, c.numdogovor, c.planerid, c.socket_id, c.numunit, c.access_list, 
              c.inf_id, c.status_d, c.kontakt, c.equip_id, c.power, c.equip_type, c.ray_el, c.phase_el, c.ray2_el, c.phase2_el, c.in_exp, c.out_exp, c.scheme, 
              k.*, t.town, i.address, s.name 
              FROM klients.collocation c, klients.tab_klients k, klients.tblinform2 i, klients.tab_town t, klients.tab_status s 
              WHERE c.kli_id=k.id and c.inf_id=i.inv_id and i.town_id=t.id and c.status_d=s.id and c.id_col = '.$trubl['inv_num_kli'];
      $res = mysqli_query($mysqli, $sql);
      $coll = mysqli_fetch_assoc($res);
      echo '<div><b>Клиент:</b> '.$coll['client'].'</div>';
      echo '<div>Контакт: '.$coll['kontakt'].'</div>';
      echo '<div>№ договора: '.$coll['numdogovor'].'</div>';
      echo '<div>Socket ID: '.$coll['socket_id'].'</div>';
      echo '<div><b>Подключение:</b></div>';
      if ($coll['inf_id'] <= 0) {
        $str = '';
      } else {
        $sql = "SELECT i.inv_id,t.town,i.address FROM tblinform2 i, tab_town t WHERE i.town_id=t.id AND i.inv_id=".$coll['inf_id'];
        $res = mysqli_query($mysqli, $sql);
        $temp = mysqli_fetch_assoc($res);
        $str = $temp['town'].' '.$temp['address'];
      };
      echo '<div>Узел: '.$str.'</div>';
      if ($coll['equip_id'] <= 0) {
        $str = '';
      } else {
        $sql = "SELECT id_equip, name_nms FROM net_equip WHERE id_equip=".$coll['equip_id'];
        $res = mysqli_query($mysqli, $sql);
        $temp = mysqli_fetch_assoc($res);
        $str = $temp['name_nms'];
      };
      echo '<div>Устройство: '.$str.'</div></br>';
      echo '<div>Оборудование: '.$coll['equip'].'</div>';
      echo '<div>Тип: '.$coll['equip_type'].'</div>';
      echo '<div>№ стойки: '.$coll['numst'].'</div>';
      echo '<div>№ юнита: '.$coll['numunit'].'</div>';
      echo '<div>Схема включения:</div>';
      echo '<div>'.$coll['scheme'].'</div>';
      echo '<div><b>Электропитание:</b></div>';
      echo '<div>Мощность (Вт): '.$coll['power'].'</div>';
      echo '<div>Основное:</div>';
      echo '<div>Луч: '.$coll['ray_el'].', Фаза: '.$coll['phase_el'].'</div>';
      echo '<div>Резервное:</div>';
      echo '<div>Луч: '.$coll['ray2_el'].', Фаза: '.$coll['phase2_el'].'</div>';
      echo '<div>Примечание:</div>';
      echo '<div>'.$coll['musor'].'</div></br>';
      echo '<div>Установлен: '.date("d.m.Y", strtotime($coll['in_exp'])).'</div>';
      $sql = "SELECT name FROM tab_status WHERE id=".$coll['status_d'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div>Статус: '.$temp['name'].'</div></br>';
      echo '<div><font color="red"><b>Контакт главного офиса:</b></font></div>';
      echo '<div>'.$coll['admin'].'</div>';
      echo '<div>'.$coll['admin_phone'].'</div>';
      echo '<div>'.$coll['admin_email'].'</div>';
      echo '<div>'.$coll['admin_fax'].'</div>';
      echo '<div><font color="blue"><b>Ответственный менеджер:</b></font></div>';
      $sql = "SELECT nik FROM tab_access WHERE id=".$coll['manager'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div>'.$temp['nik'].'</div>';
      break;
    // Тех.Площадки
    case 3 :
      echo '<div>Тех.Площадки:</div>';
      echo ' В работе....';
      break;
    // Сетевые Устройства
    case 4 :
      echo '<div>Сетевые Устройства:</div>';
      $sql = 'SELECT e.*, i.town_id, i.address, concat_WS(" ",t.town,i.address) as addr, t.town, n.net as net_1, b.brend, b.model 
             FROM klients.net_equip e, klients.tblinform2 i, klients.tab_town t, tab_nets n, tab_equip b 
             WHERE e.linkage="0" AND e.num_node=i.inv_id AND i.town_id=t.id AND i.town_id=t.id AND e.net=n.id AND e.num_equip=b.id 
             AND e.id_equip = '.$trubl['inv_num_kli'].
             ' UNION ALL 
             SELECT e.*, o.town_id, o.street, concat_WS(" ",k.client,o.street) as addr, k.client, n.net as net_1, b.brend, b.model 
             FROM klients.net_equip e, klients.office_kli o, klients.tab_klients k, tab_nets n, tab_equip b 
             WHERE e.linkage="1" AND e.num_node=o.id_kli AND o.klient=k.id AND e.net=n.id AND e.num_equip=b.id 
             AND e.id_equip = '.$trubl['inv_num_kli'];      
      $res = mysqli_query($mysqli, $sql);
      $cu = mysqli_fetch_assoc($res);
      echo '<div><b>'.$cu['net_1'].'</b></div>';
      echo '<div><font color="red">'.$cu['ip_address'].'</font></div>';
      echo '<div><b>'.$trubl['klient_calc'].'</b></div>';
      echo '<div><b>ТТ№: </b>'.$_GET['tt_id'].'</div>';
      echo '<div><b>Причина открытия: </b>'.$trubl['description'].', '.$trubl['type_tt'].'</div>';
      echo '<div>'.$cu['brend'].', '.$cu['model'].'</div>';
      echo '<div>'.$cu['scheme'].'</div>';
      $sql = "SELECT `name` FROM `tab_status` WHERE `id`=".$cu['status_d'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div><b>Статус: </b><font color="red">'.$temp['name'].'</font></div>';
      echo '<div>в эксплуатации: '.$cu['in_exp'].'</div>';
      echo '<div>демонтирован: '.$cu['out_exp'].'</div></br>';
      switch ($cu['linkage']) {
        case 0:
          $sql = "SELECT `owner` FROM `tblinform2` WHERE `inv_id`=".$cu['num_node'];
          $res = mysqli_query($mysqli, $sql);
          $temp = mysqli_fetch_assoc($res);
          echo '<div><b>Контакты (узел):</b></div>';
          echo '<div>'.$temp['owner'].'</div></br>';
          break;
        case 1:
          $sql = "SELECT `kont_tel` FROM `office_kli` WHERE `id_kli`=".$cu['num_node'];
          $res = mysqli_query($mysqli, $sql);
          $temp = mysqli_fetch_assoc($res);
          echo '<div><b>Контакты (офис):</b></div>';
          echo '<div>'.$temp['kont_tel'].'</div></br>';
          break;
      };
      $sql = "SELECT `brend`,`model`,`power` FROM `tab_equip` WHERE `id`=".$cu['num_equip'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div>'.$temp['brend'].', '.$temp['model'].'</div>';
      echo '<div>Потребляет: '.$temp['power'].' Вт</div>';
      echo '<div>Версия ПО: '.$cu['num_ver'].' Вт</div>';
      echo '<div>№ в планере: '.$cu['planerid'].'</div>';
      if (in_array($cu['net_1'], array('WiPLL','OFDM','DECT','AiReach','NEC','SAF'))) {
        $sql = "SELECT `name` FROM `tab_installer` WHERE `id`=".$cu['installer'];
        $res = mysqli_query($mysqli, $sql);
        $temp = mysqli_fetch_assoc($res);
        echo '<div>Инсталятор: '.$temp['name'].'</div></br>';
        echo '<div>Номер БС: '.$cu['num_bs'].'</div>';
        echo '<div>Номер сектора: '.$cu['num_sect'].'</div>';
        echo '<div>Частота: '.$cu['rate1'].'</div>';
        echo '<div>Угол наклона: '.$cu['corner1'].'</div>';
        echo '<div>Азимут: '.$cu['azimuth1'].'</div>';
        echo '<div>ID сектора: '.$cu['id_sect1'].'</div>';
        echo '<div>AIRMAC: '.$cu['airmac1'].'</div>';
        echo '<div>Полоса пропускания (МГц): '.$cu['bandwidth1'].'</div>';
      };
      break;
    // Сетевые Соединения
    case 5 :
      echo '<div>Сетевые Соединения:</div>';
      $sql = 'SELECT * FROM `net_links` WHERE `id_link` = '.$trubl['inv_num_kli'];
      $res = mysqli_query($mysqli, $sql);
      $cc = mysqli_fetch_assoc($res);
      echo '<div><b>'.$cc['sign_net'].' + '.$cc['sign_net2'].'</b></div>';
      switch ($cc['flag_link']) {
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
          $sql = "SELECT `client` FROM `tab_klients` WHERE `id`=".$cc['equip_b'];
          $res = mysqli_query($mysqli, $sql);
          $temp = mysqli_fetch_assoc($res);
          echo '<div>Партнер - '.$temp['client'].', CID = '.$cc['port_b'].'</div>';
          break;
      };
      echo '<div>'.$cc['name'].'</div>';
      echo '<div>CID-ы:'.$cc['pointer_1'].','.$cc['pointer_2'].','.$cc['pointer_3'].','.$cc['pointer_4'].','.$cc['pointer_5'].','.$cc['pointer_6'].','.$cc['pointer_7'].','.$cc['pointer_8'].','.$cc['pointer_9'].','.$cc['pointer_10'].','.$cc['pointer_11'].','.$cc['pointer_12'].','.$cc['pointer_13'].','.$cc['pointer_14'].','.$cc['pointer_15'].'</div></br>';
      echo '<div><b>Схема:</b></div>';
      echo '<div>'.$cc['scheme'].'</div>';
      echo '<div><b>Примечание:</b></div>';
      echo '<div>'.$cc['note'].'</div>';
      $sql = "SELECT `name` FROM `tab_status` WHERE `id`=".$cc['status_d'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div><b>Статус: '.$temp['name'].'</b></div>';
      echo '<div>в эксплуатации: '.date("d.m.Y", strtotime($cc['in_exp'])).'</div>';
      if ($cc['out_exp'] == '0000-00-00') {
        $str = '';
      } else {
        $str = date("d.m.Y", strtotime($cc['out_exp']));
      }
      echo '<div>демонтирован: '.$str.'</div>';
      echo '<div>Особенности приема в эксплуатацию: '.$cc['inexp'].'</div>';
      echo '<div>ID в планере: '.$cc['planerid'].'</div>';
      break;
    // Офисы Клиентов
    case 6 :
      echo '<div>Офисы Клиентов:</div>';
      $sql ='SELECT o.id_kli, o.klient, o.country_id, o.area_id, o.town_id, o.street, o.kont_tel, o.kont_email, o.device, o.device_id, o.port, o.CID_1, o.CID_2, o.CID_3, o.CID_4, o.CID_5, 
         o.chart_joint, o.chart_joint_nc, o.office, o.speed, o.equip, o.planerid, o.retail, o.inexp, o.status_d, o.note, o.in_exp, o.out_exp, k.*, t.town, c.country, a.region, s.name 
         FROM office_kli o, tab_klients k, tab_town t, tab_country c, tab_area a, tab_status s 
         WHERE o.klient = k.id and t.id=o.town_id and o.country_id=c.id and o.area_id=a.id and o.status_d=s.id 
         and o.id_kli = '.$trubl['inv_num_kli'];
      $res = mysqli_query($mysqli, $sql);
      $ok = mysqli_fetch_assoc($res);
      echo '<div><font color="red"><b>'.$ok['client'].', '.$ok['town'].', '.$ok['street'].'</b></font></div>';
      echo '<div>'.$ok['country'].', '.$ok['region'].' обл.</div></br>';
      echo '<div><font color="blue"><b>Контакт локального офиса: </b>'.$ok['kont_tel'].'</font></div>';
      if ($ok['kont_email'] <> '') {
        echo '<div>'.$ok['kont_email'].'</div>';
      };
      $sql = "SELECT net, name_nms FROM net_equip WHERE id_equip = ".$ok['device_id'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      $str = $temp['name_nms'];
      $sql = "SELECT net FROM tab_nets WHERE id=".$temp['net'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div></div>';
      echo '<div><b>Схема ПМ: </b></div>';
      echo '<div>'.$temp['net'].'/'.$str.' '.$ok['port'].' --- '.$ok['chart_joint'].'</div>';
      echo '<div></div>';
      echo '<div>Примечание: '.$ok['note'].'</div>';
      echo '<div>'.$ok['chart_joint_nc'].'</div>';
      echo '<div>Скорость: '.$ok['speed'].'</div>';
      echo '<div>Статус: '.$ok['name'].'</div>';
      echo '<div>в эксплуатации: '.$ok['in_exp'].'</div>';
      echo '<div>демонтирован: '.$ok['out_exp'].'</div>';
      echo '<div>ID в планере: '.$ok['planerid'].'</div>';
      $sql = "SELECT `nik` FROM `equipments2` WHERE `id`=".$ok['equip'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div>'.$temp['nik'].'</div>';
      echo '<div><font color="red">Контакт главного офиса: '.$ok['admin'].'</font></div>';
      echo '<div><font color="red">'.$ok['admin_phone'].', '.$ok['admin_email'].', '.$ok['admin_fax'].', '.$ok['comment'].'</font></div>';
      echo '<div></div>';
      $sql = "SELECT `nik` FROM tab_access WHERE id=".$ok['manager'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div><font color="blue"><b>Ответственный менеджер:</b> '.$temp['nik'].'</font></div>';
      break;
    // Сервисы Клиентов
    case 7 :
      echo '<div>Сервисы Клиентов:</div>';
      $sql = 'SELECT * FROM net_data d, tab_klients k, tab_status s, tab_katal_sk_type t 
             WHERE d.client=k.id and d.status_d=s.id and d.type_serv_d=t.id 
             and d.id_data='.$trubl['inv_num_kli'];
      $res = mysqli_query($mysqli, $sql);
      $ck = mysqli_fetch_assoc($res);
      echo '<div><b>'.$trubl['klient_calc'].'</b></div>';
      echo '<div><b>ТТ№: </b>'.$_GET['tt_id'].'</div>';
      echo '<div><b>Причина открытия: </b>'.$trubl['description'].', '.$trubl['type_tt'].'</div>';
      $sql = "SELECT `nik` FROM tab_access WHERE id IN (SELECT `manager` FROM tab_klients WHERE id=".$ck['client'].")";
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo $sql;  // Error!!!!!!!!!!!!!!!!!!
      $manager = $temp['nik'];
     // клиент A
      $sql = 'SELECT o.street, k.client, k.manager, t.town, o.device_id, o.port, o.chart_joint, o.office 
            FROM office_kli o, tab_klients k, tab_town t, tab_country c, tab_area a, tab_status s 
            WHERE o.klient = k.id and t.id=o.town_id and o.country_id=c.id and o.area_id=a.id and o.status_d=s.id and o.id_kli='.$ck['office_a'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      $of1=$temp['office']; $dv1=$temp['device_id']; $port1=$temp['port']; $chart1=$temp['chart_joint'];
     // клиент Б
      $sql = 'SELECT o.street, k.client, k.manager, t.town, o.device_id, o.port, o.chart_joint, o.office 
            FROM office_kli o, tab_klients k, tab_town t, tab_country c, tab_area a, tab_status s 
            WHERE o.klient = k.id and t.id=o.town_id and o.country_id=c.id and o.area_id=a.id and o.status_d=s.id and o.id_kli='.$ck['office_b'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      $of2=$temp['office']; $dv2=$temp['device_id']; $port2=$temp['port']; $chart2=$temp['chart_joint'];

      echo '<div><b>CID: </b>'.$ck['CID'].'</div>';
      $sql = 'SELECT name FROM tab_katal_office_status WHERE id='.$of1;
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      $str = $temp['name'];
      $sql = 'SELECT name FROM tab_katal_office_status WHERE id='.$of2;
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div>'.str.' --- '.$ck['CID'].'</div>';
      echo '<div></div>';
      echo '<div><b>Трасса для расчитываемой схемы: </b>'.$ck['ras_scheme'].'</div>';
     // поиск записи устройства А по номеру
      $sql = 'SELECT net, name_nms FROM net_equip WHERE id_equip = '.$dv1;
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      $str = $temp['name_nms'];
      $sql = 'SELECT `net` FROM tab_nets WHERE id='.$temp['net'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div><font color="blue"><b>ПМ офис А: '.$temp['net'].'/'.$str.' '.$port1.'</b></font> --- '.$chart1.'</div>';
      echo '<div>Между офисами: <font color="blue">'.$ck['ras_scheme'].'</font></div>';
     // поиск записи устройства Б по номеру
      $sql = 'SELECT net, name_nms FROM net_equip WHERE id_equip = '.$dv1;
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      $str = $temp['name_nms'];
      $sql = 'SELECT `net` FROM tab_nets WHERE id='.$temp['net'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div><font color="blue"><b>ПМ офис Б: '.$temp['net'].'/'.$str.' '.$port2.'</b></font> --- '.$chart2.'</div>';
      echo '<div></div>';
      echo '<div>Трасса по сети (текст): '.$ck['shema'].'</div>';
      echo '<div></div>';
      echo '<div>Примечание: '.$ck['comment'].'</div>';
      $sql = 'SELECT `name` FROM `tab_status` WHERE `id`='.$ck['status_d'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div>Статус: '.$temp['name'].'</div>';
      echo '<div>в эксплуатации: '.$ck['in_exp'].'</div>';
      echo '<div>демонтирован: '.$ck['out_exp'].'</div>';
      echo '<div>Особенности приема в эксплуатацию: '.$ck['inexp'].'</div>';
     // менеджер
      echo '<div><b>Менеджер:</b> '.$manager.', <b>№ в планере:</b> '.$ck['planerid'].'</div>';
      echo '<div></div>';
      // Office A
      $sql='SELECT o.kont_tel, o.kont_email, o.chart_joint, k.client, k.admin, k.admin_phone, k.admin_email, k.admin_fax 
          from office_kli o, tab_klients k 
          where o.klient = k.id and id_kli = '.$ck['office_a'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div><font color="blue">Контакт Офиса А: '.$temp['client'].'</font></div>';
      echo '<div>'.$temp['kont_tel'].'</div>';
      echo '<div>'.$temp['kont_email'].'</div>';
      // Office B
      $sql='SELECT o.kont_tel, o.kont_email, o.chart_joint, k.client, k.admin, k.admin_phone, k.admin_email, k.admin_fax 
          from office_kli o, tab_klients k 
          where o.klient = k.id and id_kli = '.$ck['office_b'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div><font color="blue">Контакт Офиса Б: '.$temp['client'].'</font></div>';
      echo '<div>'.$temp['kont_tel'].'</div>';
      echo '<div>'.$temp['kont_email'].'</div>';
      // main Office
      $sql = 'SELECT * FROM tab_klients WHERE id='.$ck['client'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div><font color="red">Контакт главного Офиса: '.$temp['client'].'</div>';
      echo '<div>'.$temp['admin'].'</div>';
      echo '<div>'.$temp['admin_phone'].', '.$temp['admin_email'].', '.$temp['admin_fax'].', '.$temp['comment'].'</div>';


  // Информация о Субпровайдере
/*     str:='SELECT kli.`client`,oper.`num_canal`,oper.`contract_main`,oper.`contract`,oper.`plannerid`,'
          +'kli.`admin`,kli.`admin_phone`,kli.`admin_email`,kli.`Comment`,tab_access.`nik` '
          +'FROM `net_operators` oper '
          +'LEFT JOIN  tab_klients kli ON oper.operator=kli.id '
          +'LEFT JOIN  tab_access ON kli.`manager`=tab_access.id '
          +'WHERE oper.num_tab="7" AND oper.data_id="'+GlobalData.temp_str+'" AND oper.status_d<>"7" '
          +'ORDER BY oper.id_oper LIMIT 1';
     GlobalProc.DBSelect(str, DataModule1.ZQuery100);
     if DataModule1.ZQuery100.RecordCount>0 then
     begin
       RichEdit1.SelAttributes.Style := [fsBold];
       AddColorText('Сервис субпровайдера СК: '+#13#10, Darker(clRed, 45));
       AddColorText('Cубпровайдер: ', Darker(clRed, 45));
       RichEdit1.SelAttributes.Style := [];
       RichEdit1.SelText := DataModule1.ZQuery100.FieldByName('client').AsString+#13#10;
       RichEdit1.SelAttributes.Style := [fsBold];
       AddColorText('№ канала: ', Darker(clRed, 45));
       RichEdit1.SelAttributes.Style := [];
       RichEdit1.SelText := DataModule1.ZQuery100.FieldByName('num_canal').AsString+#13#10;
       str:='№ договора: '+DataModule1.ZQuery100.FieldByName('contract_main').AsString+', № доп.договора: '+DataModule1.ZQuery100.FieldByName('contract').AsString;
       AddColorText(str+#13#10, Darker(clRed, 45));
       Add('');
       RichEdit1.SelAttributes.Style := [fsBold];
       AddColorText('ФИО админинистратора: ', Darker(clRed, 45));
       RichEdit1.SelAttributes.Style := [];
       RichEdit1.SelText := DataModule1.ZQuery100.FieldByName('admin').AsString+#13#10;
       str:='Контакты: '+DataModule1.ZQuery100.FieldByName('admin_phone').AsString+', '+DataModule1.ZQuery100.FieldByName('admin_email').AsString+', '+DataModule1.ZQuery100.FieldByName('Comment').AsString;
       AddColorText(str, Darker(clRed, 45));
       RichEdit1.SelAttributes.Style := [fsBold];
       AddColorText('Менеджер провайдера: ', Darker(clRed, 45));
       RichEdit1.SelAttributes.Style := [];
       RichEdit1.SelText := DataModule1.ZQuery100.FieldByName('nik').AsString+', ';
       RichEdit1.SelAttributes.Style := [fsBold];
       AddColorText('№ в планере: ', Darker(clRed, 45));
       RichEdit1.SelAttributes.Style := [];
       RichEdit1.SelText := DataModule1.ZQuery100.FieldByName('plannerid').AsString+#13#10;
     end
     else begin
       str:='SELECT kli.`client`,oper.`num_canal`,oper.`contract_main`,oper.`contract`,oper.`plannerid`,'
            +'kli.`admin`,kli.`admin_phone`,kli.`admin_email`,kli.`Comment`,tab_access.`nik` '
            +'FROM `net_operators` oper '
            +'LEFT JOIN  tab_klients kli ON oper.operator=kli.id '
            +'LEFT JOIN  tab_access ON kli.`manager`=tab_access.id '
            +'WHERE oper.num_tab="6" AND (oper.data_id="'+DataModule1.ZQuery101.FieldByName('office_a').AsString+'") '
            +'AND oper.status_d<>"7" '
            +'ORDER BY oper.id_oper LIMIT 1';
       GlobalProc.DBSelect(str, DataModule1.ZQuery100);
       if DataModule1.ZQuery100.RecordCount>0 then
       begin
         RichEdit1.SelAttributes.Style := [fsBold];
         AddColorText('Сервис субпровайдера Офис А: '+#13#10, Darker(clRed, 45));
         AddColorText('Cубпровайдер: ', Darker(clRed, 45));
         RichEdit1.SelAttributes.Style := [];
         RichEdit1.SelText := DataModule1.ZQuery100.FieldByName('client').AsString+#13#10;
         RichEdit1.SelAttributes.Style := [fsBold];
         AddColorText('№ канала: ', Darker(clRed, 45));
         RichEdit1.SelAttributes.Style := [];
         RichEdit1.SelText := DataModule1.ZQuery100.FieldByName('num_canal').AsString+#13#10;
         str:='№ договора: '+DataModule1.ZQuery100.FieldByName('contract_main').AsString+', № доп.договора: '+DataModule1.ZQuery100.FieldByName('contract').AsString;
         AddColorText(str+#13#10, Darker(clRed, 45));
         Add('');
         RichEdit1.SelAttributes.Style := [fsBold];
         AddColorText('ФИО админинистратора: ', Darker(clRed, 45));
         RichEdit1.SelAttributes.Style := [];
         RichEdit1.SelText := DataModule1.ZQuery100.FieldByName('admin').AsString+#13#10;
         str:='Контакты: '+DataModule1.ZQuery100.FieldByName('admin_phone').AsString+', '+DataModule1.ZQuery100.FieldByName('admin_email').AsString+', '+DataModule1.ZQuery100.FieldByName('Comment').AsString;
         AddColorText(str, Darker(clRed, 45));
         RichEdit1.SelAttributes.Style := [fsBold];
         AddColorText('Менеджер провайдера: ', Darker(clRed, 45));
         RichEdit1.SelAttributes.Style := [];
         RichEdit1.SelText := DataModule1.ZQuery100.FieldByName('nik').AsString+', ';
         RichEdit1.SelAttributes.Style := [fsBold];
         AddColorText('№ в планере: ', Darker(clRed, 45));
         RichEdit1.SelAttributes.Style := [];
         RichEdit1.SelText := DataModule1.ZQuery100.FieldByName('plannerid').AsString+#13#10;
       end else
       begin
         str:='SELECT kli.`client`,oper.`num_canal`,oper.`contract_main`,oper.`contract`,oper.`plannerid`,'
              +'kli.`admin`,kli.`admin_phone`,kli.`admin_email`,kli.`Comment`,tab_access.`nik` '
              +'FROM `net_operators` oper '
              +'LEFT JOIN  tab_klients kli ON oper.operator=kli.id '
              +'LEFT JOIN  tab_access ON kli.`manager`=tab_access.id '
              +'WHERE oper.num_tab="6" AND (oper.data_id="'+DataModule1.ZQuery101.FieldByName('office_b').AsString+'") '
              +'AND oper.status_d<>"7" '
              +'ORDER BY oper.id_oper LIMIT 1';
         GlobalProc.DBSelect(str, DataModule1.ZQuery100);
         if DataModule1.ZQuery100.RecordCount>0 then
         begin
           RichEdit1.SelAttributes.Style := [fsBold];
           AddColorText('Сервис субпровайдера Офис Б: '+#13#10, Darker(clRed, 45));
           AddColorText('Cубпровайдер: ', Darker(clRed, 45));
           RichEdit1.SelAttributes.Style := [];
           RichEdit1.SelText := DataModule1.ZQuery100.FieldByName('client').AsString+#13#10;
           RichEdit1.SelAttributes.Style := [fsBold];
           AddColorText('№ канала: ', Darker(clRed, 45));
           RichEdit1.SelAttributes.Style := [];
           RichEdit1.SelText := DataModule1.ZQuery100.FieldByName('num_canal').AsString+#13#10;
           str:='№ договора: '+DataModule1.ZQuery100.FieldByName('contract_main').AsString+', № доп.договора: '+DataModule1.ZQuery100.FieldByName('contract').AsString;
           AddColorText(str+#13#10, Darker(clRed, 45));
           Add('');
           RichEdit1.SelAttributes.Style := [fsBold];
           AddColorText('ФИО админинистратора: ', Darker(clRed, 45));
           RichEdit1.SelAttributes.Style := [];
           RichEdit1.SelText := DataModule1.ZQuery100.FieldByName('admin').AsString+#13#10;
           str:='Контакты: '+DataModule1.ZQuery100.FieldByName('admin_phone').AsString+', '+DataModule1.ZQuery100.FieldByName('admin_email').AsString+', '+DataModule1.ZQuery100.FieldByName('Comment').AsString;
           AddColorText(str, Darker(clRed, 45));
           RichEdit1.SelAttributes.Style := [fsBold];
           AddColorText('Менеджер провайдера: ', Darker(clRed, 45));
           RichEdit1.SelAttributes.Style := [];
           RichEdit1.SelText := DataModule1.ZQuery100.FieldByName('nik').AsString+', ';
           RichEdit1.SelAttributes.Style := [fsBold];
           AddColorText('№ в планере: ', Darker(clRed, 45));
           RichEdit1.SelAttributes.Style := [];
           RichEdit1.SelText := DataModule1.ZQuery100.FieldByName('plannerid').AsString+#13#10;
         end;
       end;
     end;
*/
      break;
    // Сервисы Субпровайдеров
    case 8 :
      echo '<div>Сервисы Субпровайдеров:</div>';
      $sql = 'SELECT * FROM net_operators o, tab_klients k WHERE o.operator=k.id AND id_oper = '.$trubl['inv_num_kli'];
      $res = mysqli_query($mysqli, $sql);
      $ccu = mysqli_fetch_assoc($res);
      $sql = "SELECT town FROM tab_town WHERE id=".$ccu['town_a'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div>Точка А: '.$temp['town'].', '.$ccu['side_a'].'</div>';
      $sql = "SELECT town FROM tab_town WHERE id=".$ccu['town_b'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div>Точка Б: '.$temp['town'].', '.$ccu['side_b'].'</div>';
      echo '<div>Скорость: '.$ccu['speed_m'].'</div>';
      echo '<div>Субпровайдер: '.$ccu['client'].'</div>';
      echo '<div>Стоимость: '.$ccu['cost'].'</div>';
      echo '<div>№ задачи: '.$ccu['plannerid'].'</div>';
      if ($ccu['for_what'] <= 0) {
        $str = '';
      } else {
        $sql = "SELECT `name` FROM tab_katal_sk_type WHERE id=".$ccu['for_what'];
        $res = mysqli_query($mysqli, $sql);
        $temp = mysqli_fetch_assoc($res);
        $str = $temp['name'];
      };
      echo '<div>Тип услуги: '.$str.'</div>';
      if ($ccu['nameclient_id'] <= 0) {
        $str = '';
      } else {
        $sql = "SELECT `client` FROM tab_klients WHERE id=".$ccu['nameclient_id'];
        $res = mysqli_query($mysqli, $sql);
        $temp = mysqli_fetch_assoc($res);
        $str = $temp['client'];
      };
      echo '<div>Название клиента: '.$str.'</div>';
      echo '<div>corp\retail: '.$ccu['corp_retail'].'</div>';
      echo '<div>Дата включения: '.$ccu['condition'].'</div>';
      $sql = "SELECT COUNT(*) AS N FROM tab_klients WHERE id=".$ccu['status_d'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      if ($temp['N'] = 0) {
        $str = 'в эксплуатации';
      } else {
        $sql = "SELECT `name` FROM tab_status WHERE id=".$ccu['status_d'];
        $res = mysqli_query($mysqli, $sql);
        $temp = mysqli_fetch_assoc($res);
        $str = $temp['name'];
      }
      echo '<div>Состояние: '.$str.'</div>';
      echo '<div>Примечание: '.$ccu['note'].'</div>';
      break;
    // Аутсорсинг
    case 9 :
      echo '<div>Аутсорсинг:</div>';
      $sql = "SELECT * FROM outs_hardware WHERE outs_id=".$trubl['inv_num_kli'];
      $res = mysqli_query($mysqli, $sql);
      $outs = mysqli_fetch_assoc($res);
      $sql = "select o.id_kli, o.klient, o.country_id, o.area_id, o.town_id, o.street, o. kont_tel, o.kont_email, o.device, o.device_id, o.port, o.CID_1, o.CID_2, o.CID_3, o.CID_4, o.CID_5, 
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
      echo '<div>в эксплуатации: '.$kli['in_exp'].'</div>';
      echo '<div>демонтирован: '.$kli['out_exp'].'</div>';
      echo '<div>ID в планере: '.$kli['planerid'].'</div>';

      $sql = "SELECT `nik` FROM `equipments2` WHERE `id`=".$kli['equip'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res);
      echo '<div>'.$temp['nik'].'</div>';
      echo '<div><font color="red">Контакт главного офиса: '.$kli['admin'].'</font></div>';
      echo '<div><font color="red">'.$kli['admin_phone'].', '.$kli['admin_email'].', '.$kli['admin_fax'].', '.$kli['comment'].'</font></div>';

      $sql = "SELECT `nik` FROM tab_access WHERE id=".$kli['manager'];
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

      $sql = "SELECT `name` FROM `tab_status` WHERE `id`=".$equ['status_d'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res); 
      echo '<div><b>Статус:</b> '.$temp['name'].'</div>';
      echo '<div>в эксплуатации: '.$equ['in_exp'].'</div>';
      echo '<div>демонтирован: '.$equ['out_exp'].'</div>';

      if ($equ['linkage'] = 0){
        $sql = "SELECT `owner` FROM `tblinform2` WHERE `inv_id`=".$equ['num_node'];
        $res = mysqli_query($mysqli, $sql);
        $temp = mysqli_fetch_assoc($res);
        echo '<div><b>Контакты (узел):</b></div>';  
        echo '<div>'.$temp['owner'].'</div>'; 
      } else {
        $sql = "SELECT `kont_tel` FROM `office_kli` WHERE `id_kli`=".$equ['num_node'];
        $res = mysqli_query($mysqli, $sql);
        $temp = mysqli_fetch_assoc($res);
        echo '<div><b>Контакты (офис):</b></div>';  
        echo '<div>'.$temp['kont_tel'].'</div>';    
      }

      $sql = "SELECT `brend`,`model`,`power` FROM `tab_equip` WHERE `id`=".$equ['num_equip'];
      $res = mysqli_query($mysqli, $sql);
      $temp = mysqli_fetch_assoc($res); 
      echo '<div>'.$temp['brend'].' '.$temp['model'].'</div>';
      echo '<div>Потребляет: '.$temp['power'].' Вт'.'</div>';
      echo '<div>Версия ПО: '.$equ['num_ver'].'</div>';
      echo '<div>№ в планере: '.$equ['planerid'].'</div>';

      if (in_array($equ['net'], array('WiPLL','OFDM','DECT','AiReach','NEC','SAF'))) {
        $sql = "SELECT `name` FROM `tab_installer` WHERE `id`=".$equ['installer'];
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
      break;

    }; // switch  
  mysqli_close($mysqli);
?>
</body>
</html>