<?php
	header("Content-Type: text/html; charset=utf-8");
	if (!isset($_POST['office2']) or !isset($_POST['equip2'])) {
        header("location: ../includes/info.error.php");
	} 
    require "../includes/constants.php";
	//Open database connection
	$mysqli = mysqli_connect($host,$user,$password,$db);
	// проверка подключения 
	if (mysqli_connect_errno()) {
    	printf("Не удалось подключиться: %s\n", mysqli_connect_error());
    	exit();
	}
	$user_id = 2;
	// SQL запрос
    $sql = 'UPDATE `outs_hardware` SET `clients`="'.$_POST['office2'].'",`hostname`="'.$_POST["name"].'",`hardware`="'.$_POST["equip2"].'",`serial`="'.$_POST["num"].'",`license`="'.$_POST["license"].'",`info`="'.$_POST["note"].'",change_login="'.$user_id.'" 
            WHERE outs_id='.$_POST["id_outs"];
  	//Get records from database
	if (mysqli_query($mysqli, $sql) === TRUE) {
        header("location: ../includes/info.ok.php?info=2");
	} else {
        header("location: ../includes/info.error.php?info=2");
	};
?>