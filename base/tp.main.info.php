<?php
  header("Content-Type: text/html; charset=utf-8");
  if (!isset($_GET['tp_id'])) {
      header("location: ../includes/info.error.php");
  }   
?>
<!DOCTYPE html>
<html>
<head> 
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="css/fieldset.css" />
  <title>info: о Тех.Площадке</title>
</head>
<body>
<?php
    require "../includes/constants.php";
	//Open database connection
    $mysqli = mysqli_connect($host,$user,$password,$db);
	$sql = "SELECT t.*,c.country,a.region,w.town,lcat.lease_category AS lc1,s.name AS statname,
				tac.access_mode, ccat.condition_category AS cc,lcat2.lease_category AS lc2 
            FROM tblinform2 t 
            LEFT JOIN tab_town w ON t.town_id=w.id 
            LEFT JOIN tab_country c ON t.country_id=c.id 
            LEFT JOIN tab_area a ON  t.area_id=a.id 
            LEFT JOIN tab_lease_category lcat ON lcat.id=t.lease_category_d 
            LEFT JOIN tab_status s ON s.id=t.status_d 
            LEFT JOIN tab_access_mode tac ON tac.id =t.access_mode 
            LEFT JOIN tab_condition_category ccat ON ccat.id =t.condition_category 
            LEFT JOIN tab_lease_category lcat2 ON lcat2.id =t.cond_owner 
            WHERE  t.inv_id=".$_GET['tp_id'];
    $res = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($res);
?>
    <fieldset>
        <legend>Адрес узла</legend>
        <div>
          <label for="name">Название:</label>
          <span><?php echo $row['node_old'] ?></span>
        </div>
        <div>
          <label for="country">Страна:</label>
          <span><?php echo $row['country'] ?></span>
        </div>  
        <div> 
          <label for="area">Область:</label>
          <span><?php echo $row['region'] ?></span>
        </div>        
        <div> 
          <label for="town">Город:</label>
          <span><?php echo $row['town'] ?></span>
        </div>         
        <div>
          <label for="address">Адрес:</label>
          <span><?php echo $row['address'] ?></span>
        </div>
        <div> 
          <label for="lease">Категория аренды:</label>
          <span><?php echo $row['lc1'] ?></span>
        </div>   
        <div> 
          <label for="status">Статус:</label>
          <span><?php echo $row['statname'] ?></span>
        </div>   
        <div>
          <label for="planner">№ задачи Planner:</label>
          <span><?php echo $row['planerid'] ?></span>
        </div>        
        <div> 
          <label for="class">Класс:</label>
          <span><?php echo $row['nclass_d'] ?></span>
        </div>   
    </fieldset> 
    <fieldset>
        <legend>Доступ к узлу</legend>
        <div> 
          <label for="access">Режим доступа:</label>
		  <span><?php echo $row['access_mode'] ?></span>  
        </div>   
        <div>
          <label for="note1">Примечание:</label>
          <textarea   cols="35" rows="3" name="note1" id="note1" class="note"><?php echo $row['node_memo'] ?></textarea>
        </div>    
    </fieldset> 
    <fieldset>
        <legend>Электропитание</legend>
        <div> 
          <label for="grounding">Заземление:</label>
          <?php 
           switch($row['ground']) {
 			case 0: echo "<span></span>"; break;
 			case 1: echo "<span>НЕТ</span>"; break;
 			case 2: echo "<span>ЕСТЬ</span>"; break;
 		  }?>
        </div>   
        <div> 
          <label for="generator">Возможность подключить генератор:</label>
          <?php 
           switch($row['el_generator']) {
 			case 0: echo "<span></span>"; break;
 			case 1: echo "<span>НЕТ</span>"; break;
 			case 2: echo "<span>ЕСТЬ</span>"; break;
 		  }?>
        </div>   
        <div> 
          <label for="battery">Возможность подключить батмассив:</label>
          <?php 
           switch($row['el_battery']) {
 			case 0: echo "<span></span>"; break;
 			case 1: echo "<span>НЕТ</span>"; break;
 			case 2: echo "<span>ЕСТЬ</span>"; break;
 		  }?>
        </div> 
        <div> 
          <label for="acdc">Тип электропитания:</label>
          <span><?php echo $row['el_type'] ?></span>
        </div> 
        <div>
          <label for="note2">Примечание:</label>
          <textarea   cols="35" rows="3" name="note2" id="note2" class="note"><?php echo $row['el_equipment'] ?></textarea>
        </div> 
        <div>
          <label for="power">Потребляемая мощность (Вт.):</label>
          <span><?php echo $row['el_power_d'] ?></span>
        </div>           
        <div>
          <label for="autonomy">Время автономности (ч.):</label>
          <span><?php echo $row['el_autonomy_d'] ?></span>
        </div>
    </fieldset> 
    <fieldset>
        <legend>Кондиционирование</legend>
        <div> 
          <label for="system">Система:</label>
          <span><?php echo $row['cc'] ?></span>
        </div>   
        <div> 
          <label for="proprietor">Владелец:</label>
          <span><?php echo $row['lc2'] ?></span>
        </div>   
    </fieldset>  
    <fieldset>
        <legend>Система контроля и сигнализации</legend>
        <div> 
          <label for="outpower">внешнее питание:</label>
          <?php 
           switch($row['m_power']) {
 			case 0: echo "<span></span>"; break;
 			case 1: echo "<span>НЕТ</span>"; break;
 			case 2: echo "<span>ЕСТЬ</span>"; break;
 		  }?>
 	    </div>   
        <div> 
          <label for="doors">двери:</label>
          <?php 
           switch($row['m_door']) {
 			case 0: echo "<span></span>"; break;
 			case 1: echo "<span>НЕТ</span>"; break;
 			case 2: echo "<span>ЕСТЬ</span>"; break;
 		  }?>
        </div> 
        <div> 
          <label for="temr">температура:</label>
          <?php 
           switch($row['m_temperature']) {
 			case 0: echo "<span></span>"; break;
 			case 1: echo "<span>НЕТ</span>"; break;
 			case 2: echo "<span>ЕСТЬ</span>"; break;
 		  }?>
        </div>             
        <div> 
          <label for="humidity">влажность:</label>
          <?php 
           switch($row['m_humidity']) {
 			case 0: echo "<span></span>"; break;
 			case 1: echo "<span>НЕТ</span>"; break;
 			case 2: echo "<span>ЕСТЬ</span>"; break;
 		  }?>
        </div> 
        <div> 
          <label for="smoke">дым:</label>
          <?php 
           switch($row['m_smoke']) {
 			case 0: echo "<span></span>"; break;
 			case 1: echo "<span>НЕТ</span>"; break;
 			case 2: echo "<span>ЕСТЬ</span>"; break;
 		  }?>
        </div> 
        <div> 
          <label for="water">вода:</label>
          <?php 
           switch($row['m_water']) {
 			case 0: echo "<span></span>"; break;
 			case 1: echo "<span>НЕТ</span>"; break;
 			case 2: echo "<span>ЕСТЬ</span>"; break;
 		  }?>
        </div> 
        <div>
          <label for="note3">Примечание:</label>
          <textarea   cols="35" rows="3" name="note3" id="note3" class="note"><?php $row['signalling_type'] ?></textarea>
        </div>                            
    </fieldset>
<?php mysqli_close($mysqli); ?>
</body>
</html>