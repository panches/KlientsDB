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
	$sql = 'SELECT e.id_equip, n.net, e.ip_address, e.name_nms, concat_WS(" ",t.town,i.address) as addr, b.brend, b.model 
           FROM net_equip e, tblinform2 i, tab_town t, tab_nets n, tab_equip b 
           WHERE e.linkage="0" AND e.num_node=i.inv_id AND i.town_id=t.id AND i.town_id=t.id AND e.net=n.id AND e.num_equip=b.id 
           UNION ALL 
           SELECT e.id_equip, n.net, e.ip_address, e.name_nms, concat_WS(" ",k.client,o.street) as addr, b.brend, b.model 
           FROM net_equip e, office_kli o, tab_klients k, tab_nets n, tab_equip b 
           WHERE e.linkage="1" AND e.num_node=o.id_kli AND o.klient=k.id AND e.net=n.id AND e.num_equip=b.id 
           ORDER BY id_equip ASC';
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