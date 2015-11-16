<?php
	header("Content-Type: text/html; charset=utf-8");
	if (!isset($_POST['office2']) or !isset($_POST['equip2'])) {
        header("location: ../includes/info.error.php");
       // echo "Нет данных! Ошибка.";  exit();
	} 
    require "../includes/constants.php";
	//Open database connection
	$mysqli = mysqli_connect($host,$user,$password,$db)
                or die("Ошибка " . mysqli_error($mysqli));

	$user_id = 2; // ВРЕМЕННО!!!!!! надо заменить на вошедшего
    // экранизация символов в строке
    $office2 = htmlentities(mysqli_real_escape_string($mysqli, $_POST['office2']));
    // SQL запрос
	$sql = 'INSERT INTO `outs_hardware` (`clients`,`hostname`,`hardware`,`serial`,`license`,`info`,change_login)
            VALUES ("$office2","'.$_POST["name"].'","'.$_POST["equip2"].'","'.$_POST["num"].'","'.$_POST["license"].'","'.$_POST["note"].'","'.$user_id.'")';
  	//Get records from database
	if (mysqli_query($mysqli, $sql) === TRUE) {
        header("location: ../includes/info.ok.php?info=1");
	} else {
        header("location: ../includes/info.error.php?info=1");
	};
    // закрываем подключение
    mysqli_close($mysqli);
?>