<?php
    ini_set('default_charset',"UTF-8");
/*Open database connection*/
    require "../includes/constants.php";
/* проверка подключения */
    $mysqli = mysqli_connect($host,$user,$password,$db);
	if (mysqli_connect_errno()) {
    	printf("Не удалось подключиться: %s\n", mysqli_connect_error());
    	exit();
	}
/* запрос, в зависимости от параметра */
switch($_POST['action']) {
   /* заполнить инженерами рабочее место */
        case "showWorkers":
        		if( $_POST['num'] == 0 ) {
                	$sql = 'SELECT `num`,`name` FROM `resp_sector` ORDER BY `name`';
                	$res = mysqli_query($mysqli, $sql);
                	while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                        echo '<option value="'.$row['num'].'">'.$row['name'].'</option>';
                	};
					echo '<option value="-1">-</option>';
                } else {
                	echo '<option value="0">Все</option>';
                	$numpl = $_POST['num'] + 999999;
                	$sql = 'SELECT `num_area`,`name_area` FROM `resp_area`
                            WHERE (`num_area` BETWEEN "'.$_POST['num'].'" AND "'.$numpl.'") ';
                	$res = mysqli_query($mysqli, $sql);
                	while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                        echo '<option value="'.$row['num_area'].'">'.$row['name_area'].'</option>';
                	};
                	$sql = 'SELECT `id`,`id_num`,`worker` FROM `expworkers`
                            WHERE (`id_num` BETWEEN "'.$_POST['num'].'" AND "'.$numpl.'")
                          	  AND (absence="0" OR absence="3")';
                	$res = mysqli_query($mysqli, $sql);
                	while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                		$val = $row['id'] + $row['id_num'];
                        echo '<option value="'.$val.'">'.$row['worker'].'</option>';
                	};
                };
  				break;
	/* заполнить таблицу всеми записями */			
		case "showAllRecords":
				$sql = 'SELECT t.num_of_trubl_tick,t.state_tt,t.priority,
							GetNameOfClient(t.tab_on,t.inv_num_kli) AS klient_calc,
							t.date_of_start,t.time_of_start,t.description,t.name_user,e.worker,
							ROUND((UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(concat(t.date_of_start," ",t.time_of_start))) / 3600) AS prostoy,
							c.type_tt 
						FROM trubl t, category_type_tt c, expworkers e 
						WHERE (c.id = t.type_trubl_d) AND (t.type_trubl_d <> "5") AND (t.sostoyanie <> "отложено") 
							AND (t.depend_on = "0") AND (t.date_of_end = "0000-00-00") AND (e.id = MOD(t.user_id,100000))
						ORDER BY t.num_of_trubl_tick';	
				$res = mysqli_query($mysqli, $sql);
               	while($row = mysqli_fetch_array($res)) {
               	/*поле S формируется*/	
               		switch ($row[1]) {
						   case '0':
							   $stt = '<font color="red">А</font>';
							   break;
						   case '1':
							   $stt = '<font color="yellow">П</font>';
							   break;
						   case '2':
							   $stt = '<font color="green">У</font>';
							   break;
					   };
				/*форматирование даты*/
					$date_elements  = explode("-",$row[4]);
					$nDate = $date_elements[2].'.'.$date_elements[1].'.'.$date_elements[0];   
				/*окончательный массив данных формируется*/		
                    $output[] = array ($row[0],$stt,$row[2],$row[3],$nDate,$row[5],$row[6],$row[7],$row[8],$row[9],$row[10]);
               	};
				echo json_encode($output);
			break;
  	/* заполнить таблицу в зависимости о рабочего места */	
		case "showSelectedRecords":
				$isset = '';
				if ($_POST['sector'] == 0) {
					if ($_POST['workers'] == -1) {
						$isset = 'AND (t.user_id = "0") ';
					} else {
						if ($_POST['workers'] == 0) {
							$isset = '';
						} else {
							$plus = $_POST['workers'] + 999999;
							$isset = 'AND (t.user_id BETWEEN '.$_POST['workers'].' AND '.$plus.')'; 
						}
					}
				} else {
					if ($_POST['workers'] == 0) {
						$plus = $_POST['workers'] + 999999;
						$isset = 'AND (t.user_id BETWEEN '.$_POST['workers'].' AND '.$plus.')';						
					} else {
						if (($_POST['workers'] % 100000) == 0) {
							$plus = $_POST['workers'] + 999;
							$isset = 'AND (t.user_id BETWEEN '.$_POST['workers'].' AND '.$plus.')';								
						} else {
							$isset = 'AND (t.user_id = '.$_POST['workers'].')';
						}	
					}
				};
				$sql = 'SELECT t.num_of_trubl_tick,t.state_tt,t.priority,
							GetNameOfClient(t.tab_on,t.inv_num_kli) AS klient_calc,
							t.date_of_start,t.time_of_start,t.description,t.name_user,e.worker,
							ROUND((UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(concat(t.date_of_start," ",t.time_of_start))) / 3600) AS prostoy,
							c.type_tt 
						FROM trubl t, category_type_tt c, expworkers e 
						WHERE (c.id = t.type_trubl_d) AND (t.type_trubl_d <> "5") AND (t.sostoyanie <> "отложено") 
							AND (t.depend_on = "0") AND (t.date_of_end = "0000-00-00") AND (e.id = MOD(t.user_id,100000)) '
							.$isset.	
						'ORDER BY t.num_of_trubl_tick';	
				$res = mysqli_query($mysqli, $sql);
               	while($row = mysqli_fetch_array($res)) {
               	/*поле S формируется*/	
               		switch ($row[1]) {
						   case '0':
							   $stt = '<font color="red">А</font>';
							   break;
						   case '1':
							   $stt = '<font color="yellow">П</font>';
							   break;
						   case '2':
							   $stt = '<font color="green">У</font>';
							   break;
					   };
				/*форматирование даты*/
					$date_elements  = explode("-",$row[4]);
					$nDate = $date_elements[2].'.'.$date_elements[1].'.'.$date_elements[0];   
				/*окончательный массив данных формируется*/		
                    $output[] = array ($row[0],$stt,$row[2],$row[3],$nDate,$row[5],$row[6],$row[7],$row[8],$row[9],$row[10]);
               	};
				echo json_encode($output);			
			break;	
	/*подчиненные записи*/		
		case 'showSlaveTable':
				$sql = 'SELECT num_zap_trubl,date_zapisi,time_zapisi,kontakt,desc_zapisi,name_user 
						FROM zapisi_trubl_tic 
				        WHERE num_trubl = '.$_POST['idNum'].' AND name_user <> "автомат" 
				        ORDER BY date_zapisi, time_zapisi, num_zap_trubl';	
				$res = mysqli_query($mysqli, $sql);
               	while($row = mysqli_fetch_array($res)) {
                    $output[] = array ($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
               	};
				echo json_encode($output);			
			break;

};

?>