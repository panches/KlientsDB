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
    // BASE: num of table
    switch ($trubl['tab_on']) {
    case 0 :
        echo '<div><font color="red"><b>Не используется!</b></font></div>';
        break;
    // Регламентные работы
    case 1 :
		echo '<div>Регламентные работы:</div>';
        echo ' В работе....';
        break;
    // Collocation
    case 2 :
        echo '<div>Collocation:</div>';
        echo ' В работе....';
        break;
    // Тех.Площадки
    case 3 :
        Header("Location: ../base/tp/tp.main.info.php?tp_id=".$trubl['inv_num_kli']);
        break;
    // Сетевые Устройства
    case 4 :
        Header("Location: ../base/cy/cy.main.info.php?cy_id=".$trubl['inv_num_kli']);
        break;
    // Сетевые Соединения
    case 5 :
        Header("Location: ../base/ss/ss.main.info.php?ss_id=".$trubl['inv_num_kli']);
        break;
    // Офисы Клиентов
    case 6 :
        Header("Location: ../base/ok/ok.main.info.php?ok_id=".$trubl['inv_num_kli']);
        break;
    // Сервисы Клиентов
    case 7 :
        Header("Location: ../base/sk/sk.main.info.php?sk_id=".$trubl['inv_num_kli']);
        break;
    // Сервисы Субпровайдеров
    case 8 :
        Header("Location: ../base/ssy/ssy.main.info.php?ssy_id=".$trubl['inv_num_kli']);
        break;

    }; // switch  
    //Close database connection
    mysqli_close($mysqli);
?>
</body>
</html>