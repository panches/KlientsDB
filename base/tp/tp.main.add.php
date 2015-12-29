<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location: ../../index.html");
};
ini_set('default_charset',"UTF-8");
require "../../includes/constants.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Добавить Тех.Площадку</title>
    <link rel="stylesheet" type="text/css" href="../css/fieldset.css" />
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css" />
  </head>
  <body>
      <?php
      //Open database connection
        $mysqli = mysqli_connect($host,$user,$password,$db)
                    or die("Ошибка " . mysqli_error($mysqli));
      ?>
  <div class="container-fluid">
    <form method="post" action="tp.main.add.sql.php">
      <fieldset>
        <legend>Адрес узла</legend>
        <div>
          <label for="name">Название &#10033;:</label>
          <input type="text" name="name" id="name" class="txt" required />
        </div>
        <div>
          <label for="country">Страна &#10033;:</label>
          <select size="1" name="country" id="country" onchange="javascript:selectRegion();" class="txt" required>
            <option value="0">Все страны</option>
            <optgroup label="Выберите страну">
                <?php
                $sql = 'SELECT * FROM tab_country ORDER BY id';
                $res = mysqli_query($mysqli, $sql);
                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                    echo '<option value="'.$row['id'].'">'.$row['country'].'</option>';
                };
                ?>
            </optgroup>
            </select>
        </div>  
        <div  name="selectDataRegion"> 
            <label for="area">Область &#10033;:</label>
            <select name="area" id="area" class="txt" required></select>
        </div>
        <div  name="selectDataCity"> 
          <label for="town">Город &#10033;:</label>
          <select name="town" id="town" class="txt" required></select>
        </div>         
        <div>
          <label for="address">Адрес &#10033;:</label>
          <input type="text" name="address" id="address" class="txt" required />
        </div>
        <div> 
          <label for="lease">Категория аренды &#10033;:</label>
          <select name="lease" id="lease" class="txt" required>
              <?php
              $sql = 'SELECT id,lease_category FROM tab_lease_category ORDER BY id';
              $res = mysqli_query($mysqli, $sql);
              while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                  echo '<option value="'.$row['id'].'">'.$row['lease_category'].'</option>';
              };
              ?>
          </select>
        </div>   
        <div> 
          <label for="status">Статус &#10033;:</label>
          <select name="status" id="status" class="txt" required>
              <?php
              $sql = 'SELECT id,name FROM tab_status ORDER BY id';
              $res = mysqli_query($mysqli, $sql);
              while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                  echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
              };
              ?>
          </select>
        </div>   
        <div>
          <label for="planner">№ задачи Planner:</label>
          <input type="password" name="planner" id="planner" class="txt" />
        </div>        
        <div> 
          <label for="class">Класс:</label>
          <select name="class" id="class" class="txt">
            <option>0</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
          </select>
        </div>   
      </fieldset>
      <fieldset>
        <legend>Доступ к узлу</legend>
        <div> 
          <label for="access">Режим доступа:</label>
          <select name="access" id="acess" class="txt">
              <?php
              $sql = 'SELECT id,access_mode FROM tab_access_mode ORDER BY id';
              $res = mysqli_query($mysqli, $sql);
              while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                  echo '<option value="'.$row['id'].'">'.$row['access_mode'].'</option>';
              };
              ?>
          </select>
        </div>   
        <div>
          <label for="note1">Примечание:</label>
          <textarea   cols="69" rows="3" name="note1" id="note1" class="note"></textarea>
        </div>    
      </fieldset>
      <fieldset>
        <legend>Электропитание</legend>
        <div> 
          <label for="grounding">Заземление:</label>
          <select name="grounding" id="grounding" class="txt">
            <option value="0"></option>
            <option value="2">есть</option>
            <option value="1">нет</option>
          </select>
        </div>   
        <div> 
          <label for="generator">Возможность подключить генератор:</label>
          <select name="generator" id="generator" class="txt">
            <option value="0"></option>
            <option value="2">есть</option>
            <option value="1">нет</option>
          </select>
        </div>   
        <div> 
          <label for="battery">Возможность подключить батмассив:</label>
          <select name="battery" id="battery" class="txt">
            <option value="0"></option>
            <option value="2">есть</option>
            <option value="1">нет</option>
          </select>
        </div> 
        <div> 
          <label for="acdc">Тип электропитания:</label>
          <select name="acdc" id="acdc" class="txt">
            <option value=""></option>
            <option value="AC">AC</option>
            <option value="DC">DC</option>
            <option value="AC/DC">AC/DC</option>
            <option value="нет данных">нет данных</option>
          </select>
        </div> 
        <div>
          <label for="note2">Примечание:</label>
          <textarea   cols="69" rows="3" name="note2" id="note2" class="note"></textarea>
        </div> 
        <div>
          <label for="power">Потребляемая мощность (Вт.):</label>
          <input type="text" name="power" id="power" class="txt" />
        </div>           
        <div>
          <label for="autonomy">Время автономности (ч.):</label>
          <input type="text" name="autonomy" id="autonomy" class="txt" />
        </div>
      </fieldset>
      <fieldset>
        <legend>Кондиционирование</legend>
        <div> 
          <label for="system">Система:</label>
          <select name="system" id="system" class="txt">
              <?php
              $sql = 'SELECT id,condition_category FROM tab_condition_category ORDER BY id';
              $res = mysqli_query($mysqli, $sql);
              while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                  echo '<option value="'.$row['id'].'">'.$row['condition_category'].'</option>';
              };
              ?>
          </select>
        </div>   
        <div> 
          <label for="proprietor">Владелец:</label>
          <select name="proprietor" id="proprietor" class="txt">
              <?php
              $sql = 'SELECT id,lease_category FROM tab_lease_category ORDER BY id';
              $res = mysqli_query($mysqli, $sql);
              while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                  echo '<option value="'.$row['id'].'">'.$row['lease_category'].'</option>';
              };
              ?>
          </select>
        </div>   
      </fieldset>      
      <fieldset>
        <legend>Система контроля и сигнализации</legend>
        <div> 
          <label for="outpower">внешнее питание:</label>
          <select name="outpower" id="outpower" class="txt">
              <option value="0"></option>
              <option value="2">есть</option>
              <option value="1">нет</option>
          </select>
        </div>   
        <div> 
          <label for="doors">двери:</label>
          <select name="doors" id="doors" class="txt">
              <option value="0"></option>
              <option value="2">есть</option>
              <option value="1">нет</option>
          </select>
        </div> 
        <div> 
          <label for="temr">температура:</label>
          <select name="temr" id="temr" class="txt">
              <option value="0"></option>
              <option value="2">есть</option>
              <option value="1">нет</option>
          </select>
        </div>             
        <div> 
          <label for="humidity">влажность:</label>
          <select name="humidity" id="humidity" class="txt">
              <option value="0"></option>
              <option value="2">есть</option>
              <option value="1">нет</option>
          </select>
        </div> 
        <div> 
          <label for="smoke">дым:</label>
          <select name="smoke" id="smoke" class="txt">
              <option value="0"></option>
              <option value="2">есть</option>
              <option value="1">нет</option>
          </select>
        </div> 
        <div> 
          <label for="water">вода:</label>
          <select name="water" id="water" class="txt">
              <option value="0"></option>
              <option value="2">есть</option>
              <option value="1">нет</option>
          </select>
        </div> 
        <div>
          <label for="note3">Примечание:</label>
          <textarea   cols="69" rows="3" name="note3" id="note3" class="note"></textarea>
        </div>                            
      </fieldset> 
      <fieldset>
        <legend>Владельцы узла и стойки</legend>
        <div>
          <label for="note4">Примечание:</label>
          <textarea   cols="69" rows="10" name="note4" id="note4" class="note"></textarea>
        </div>    
      </fieldset>       
        <div class="col-md-12">
          <button name="btnOk" id="btnOk" class="btn btn-default"><img src="../../img/ok.png" style="vertical-align: middle"> Ok</button>
        </div>
    </form>
  </div>
<?php mysqli_close($mysqli); ?>
    <script src="../../js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="../../js/bootstrap.min.js" type="text/javascript"></script>
    <script>

      function selectRegion(){
            var id_country = $('select[name="country"]').val();
            if(!id_country){
                    $('div[name="selectDataRegion"]').html('<label for="area">Область:</label><select name="area" id="area" class="txt"></select>');
                    $('div[name="selectDataCity"]').html('<label for="town">Город:</label><select name="town" id="town" class="txt"></select>');
            }else{
                    $.ajax({
                            type: "POST",
                            url: "tp.main.combo.ajax.php",
                            data: { action: 'showRegionForInsert', id_country: id_country },
                            cache: false,
                            success: function(responce){ $('div[name="selectDataRegion"]').html(responce); }
                    });
                    $('div[name="selectDataCity"]').html('<label for="town">Город:</label><select name="town" id="town" class="txt"></select>');
            };
      };
      function selectCity(){
            var id_region = $('select[name="area"]').val();
            var id_country = $('select[name="country"]').val();
            $.ajax({
                    type: "POST",
                    url: "tp.main.combo.ajax.php",
                    data: { action: 'showCityForInsert', id_country: id_country, id_region: id_region },
                    cache: false,
                    success: function(responce){ $('div[name="selectDataCity"]').html(responce); }
            });
      };
  </script>
</body>
</html>
