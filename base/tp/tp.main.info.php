<?php
  header("Content-Type: text/html; charset=utf-8");
  if (!isset($_GET['tp_id'])) {
      header("location: ../../includes/info.error.php");
  }   
?>
<!DOCTYPE html>
<html lang="en">
<head> 
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>info: о Тех.Площадке</title>
  <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css" />
</head>
<body>
<?php
    require "../../includes/constants.php";
	//Open database connection
    $mysqli = mysqli_connect($host,$user,$password,$db)
                or die("Ошибка " . mysqli_error($mysqli));
    //Query to MySQL
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
  <div class="container">
      <legend>Адрес узла</legend>
        <div class="row">
            <div class="col-md-4"><label for="node">Название:</label></div>
            <div class="col-md-8"><strong class="text-info"><?php echo $row['node_old'] ?></strong></div>
        </div>
        <div class="row">
            <div class="col-md-4"><label for="country">Страна:</label></div>
            <div class="col-md-8"><strong class="text-info"><?php echo $row['country'] ?></strong></div>
        </div>  
        <div class="row">
            <div class="col-md-4"><label for="area">Область:</label></div>
            <div class="col-md-8"><strong class="text-info"><?php echo $row['region'] ?></strong></div>
        </div>        
        <div class="row">
            <div class="col-md-4"><label for="town">Город:</label></div>
            <div class="col-md-8"><strong class="text-info"><?php echo $row['town'] ?></strong></div>
        </div>         
        <div class="row">
            <div class="col-md-4"><label for="address">Адрес:</label></div>
            <div class="col-md-8"><strong class="text-info"><?php echo $row['address'] ?></strong></div>
        </div>
        <div class="row">
            <div class="col-md-4"><label for="lease">Категория аренды:</label></div>
            <div class="col-md-8"><strong class="text-info"><?php echo $row['lc1'] ?></strong></div>
        </div>   
        <div class="row">
            <div class="col-md-4"><label for="status">Статус:</label></div>
            <div class="col-md-8"><strong class="text-info"><?php echo $row['statname'] ?></strong></div>
        </div>   
        <div class="row">
            <div class="col-md-4"><label for="planner">№ задачи Planner:</label></div>
            <div class="col-md-8"><strong class="text-info"><?php echo $row['planerid'] ?></strong></div>
        </div>        
        <div class="row">
            <div class="col-md-4"><label for="class">Класс:</label></div>
            <div class="col-md-8"><strong class="text-info"><?php echo $row['nclass_d'] ?></strong></div>
        </div>   
      <legend>Доступ к узлу</legend>
        <div class="row">
          <div class="col-md-4"><label for="access">Режим доступа:</label></div>
          <div class="col-md-8"><strong class="text-info"><?php echo $row['access_mode'] ?></strong></div>
        </div>   
        <div class="row">
          <div class="col-md-4"><label for="note1">Примечание:</label></div>
          <div class="col-md-8"><textarea rows="3" name="note1" id="note1" class="note col-md-8"><?php echo $row['node_memo'] ?></textarea></div>
        </div>    
      <legend>Электропитание</legend>
        <div class="row">
          <div class="col-md-4"><label for="grounding">Заземление:</label></div>
          <div class="col-md-8"><?php
           switch($row['ground']) {
               case 0: echo ""; break;
               case 1: echo "<strong class='text-info'>НЕТ</strong>"; break;
               case 2: echo "<strong class='text-info'>ЕСТЬ</strong>"; break;
 		  }?></div>
        </div>   
        <div class="row">
          <div class="col-md-4"><label for="generator">Возможность подключить генератор:</label></div>
          <div class="col-md-8"><?php
           switch($row['el_generator']) {
               case 0: echo ""; break;
               case 1: echo "<strong class='text-info'>НЕТ</strong>"; break;
               case 2: echo "<strong class='text-info'>ЕСТЬ</strong>"; break;
 		  }?></div>
        </div>   
        <div class="row">
            <div class="col-md-4"><label for="battery">Возможность подключить батмассив:</label></div>
            <div class="col-md-8"><?php
           switch($row['el_battery']) {
               case 0: echo ""; break;
               case 1: echo "<strong class='text-info'>НЕТ</strong>"; break;
               case 2: echo "<strong class='text-info'>ЕСТЬ</strong>"; break;
 		  }?></div>
        </div> 
        <div class="row">
            <div class="col-md-4"><label for="acdc">Тип электропитания:</label></div>
            <div class="col-md-8"><strong class="text-info"><?php echo $row['el_type'] ?></strong></div>
        </div> 
        <div class="row">
            <div class="col-md-4"><label for="note2">Примечание:</label></div>
            <div class="col-md-8"><textarea rows="3" name="note2" id="note2" class="note col-md-8"><?php echo $row['el_equipment'] ?></textarea></div>
        </div> 
        <div class="row">
            <div class="col-md-4"><label for="power">Потребляемая мощность (Вт.):</label></div>
            <div class="col-md-8"><strong class="text-info"><?php echo $row['el_power_d'] ?></strong></div>
        </div>           
        <div class="row">
            <div class="col-md-4"><label for="autonomy">Время автономности (ч.):</label></div>
            <div class="col-md-8"><strong class="text-info"><?php echo $row['el_autonomy_d'] ?></strong></div>
        </div>
      <legend>Кондиционирование</legend>
        <div class="row">
            <div class="col-md-4"><label for="system">Система:</label></div>
            <div class="col-md-8"><strong class="text-info"><?php echo $row['cc'] ?></strong></div>
        </div>   
        <div class="row">
            <div class="col-md-4"><label for="proprietor">Владелец:</label></div>
            <div class="col-md-8"><strong class="text-info"><?php echo $row['lc2'] ?></strong></div>
        </div>   
      <legend>Система контроля и сигнализации</legend>
        <div class="row">
            <div class="col-md-4"><label for="outpower">внешнее питание:</label></div>
            <div class="col-md-8"><?php
           switch($row['m_power']) {
               case 0: echo ""; break;
               case 1: echo "<strong class='text-info'>НЕТ</strong>"; break;
               case 2: echo "<strong class='text-info'>ЕСТЬ</strong>"; break;
 		  }?></div>
 	    </div>   
        <div class="row">
            <div class="col-md-4"><label for="doors">двери:</label></div>
            <div class="col-md-8"><?php
           switch($row['m_door']) {
               case 0: echo ""; break;
               case 1: echo "<strong class='text-info'>НЕТ</strong>"; break;
               case 2: echo "<strong class='text-info'>ЕСТЬ</strong>"; break;
 		  }?></div>
        </div> 
        <div class="row">
            <div class="col-md-4"><label for="temr">температура:</label></div>
            <div class="col-md-8"><?php
           switch($row['m_temperature']) {
               case 0: echo ""; break;
               case 1: echo "<strong class='text-info'>НЕТ</strong>"; break;
               case 2: echo "<strong class='text-info'>ЕСТЬ</strong>"; break;
 		  }?></div>
        </div>             
        <div class="row">
            <div class="col-md-4"><label for="humidity">влажность:</label></div>
            <div class="col-md-8"><?php
           switch($row['m_humidity']) {
               case 0: echo ""; break;
               case 1: echo "<strong class='text-info'>НЕТ</strong>"; break;
               case 2: echo "<strong class='text-info'>ЕСТЬ</strong>"; break;
 		  }?></div>
        </div> 
        <div class="row">
            <div class="col-md-4"><label for="smoke">дым:</label></div>
            <div class="col-md-8"><?php
           switch($row['m_smoke']) {
               case 0: echo ""; break;
               case 1: echo "<strong class='text-info'>НЕТ</strong>"; break;
               case 2: echo "<strong class='text-info'>ЕСТЬ</strong>"; break;
 		  }?></div>
        </div> 
        <div class="row">
            <div class="col-md-4"><label for="water">вода:</label></div>
            <div class="col-md-8"><?php
           switch($row['m_water']) {
               case 0: echo ""; break;
               case 1: echo "<strong class='text-info'>НЕТ</strong>"; break;
               case 2: echo "<strong class='text-info'>ЕСТЬ</strong>"; break;
 		  }?></div>
        </div> 
        <div class="row">
            <div class="col-md-4"><label for="note3">Примечание:</label></div>
            <div class="col-md-8"><textarea rows="3" name="note3" id="note3" class="note col-md-8"><?php echo $row['signalling_type'] ?></textarea></div>
        </div>
      <legend>Владельцы узла и стойки</legend>
        <div class="row">
            <div class="col-md-4"><label for="note4">Примечание:</label></div>
            <div class="col-md-8"><textarea rows="3" name="note4" id="note4" class="note col-md-8"><?php echo $row['owner'] ?></textarea></div>
        </div>
  </div>
    <?php mysqli_close($mysqli); ?>
    <script src="../../js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="../../js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>