<?php
    require "../includes/constants.php";
	//Open database connection
	$mysqli = mysqli_connect($host,$user,$password,$db);
	/* проверка подключения */
	if (mysqli_connect_errno()) {
    	printf("Не удалось подключиться: %s\n", mysqli_connect_error());
    	exit();
	}
	// SQL запрос
	$sql = 'SELECT o.id_kli, k.client, t.town, o.street, q.name_nms, o.port, o.chart_joint_nc, c.country, a.region 
      FROM office_kli o, net_equip q, tab_klients k, tab_town t, tab_country c, tab_area a, tab_status s 
      WHERE o.klient = k.id and q.id_equip=o.device_id and t.id=o.town_id and o.country_id=c.id and o.area_id=a.id and o.status_d=s.id 
      ORDER BY o.id_kli';
  	//Get records from database
    $result = mysqli_query($mysqli, $sql);
	//Add all records to an array
	while ($row = mysqli_fetch_array($result, MYSQL_NUM)) {
		$rows[] = $row;
	}
	mysqli_free_result($result);
	//Return result to 
	$out = array('data' => $rows);
	echo json_encode($out);	
?>