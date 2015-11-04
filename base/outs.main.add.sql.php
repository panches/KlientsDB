<?php
	header("Content-Type: text/html; charset=utf-8");
	if (!isset($_POST['office2']) or !isset($_POST['equip2'])) {
        header("location: ../includes/info.error.php");
       // echo "Нет данных! Ошибка.";  exit();
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
	$sql = 'INSERT INTO `outs_hardware` (`clients`,`hostname`,`hardware`,`serial`,`license`,`info`,change_login) 
            VALUES ("'.$_POST["office2"].'","'.$_POST["name"].'","'.$_POST["equip2"].'","'.$_POST["num"].'","'.$_POST["license"].'","'.$_POST["note"].'","'.$user_id.'")';
  	//Get records from database
	if (mysqli_query($mysqli, $sql) === TRUE) {
        header("location: ../includes/info.ok.php?info=1");
	} else {
        header("location: ../includes/info.error.php?info=1");
	};            
?>