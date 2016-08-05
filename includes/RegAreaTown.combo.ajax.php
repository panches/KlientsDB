<?php

ini_set('default_charset',"UTF-8");

require "constants.php";
//Open database connection
$mysqli = mysqli_connect($host,$user,$password,$db)
                or die("Ошибка " . mysqli_error($mysqli));

switch ($_POST['action']){
                
        case "showRegionForInsert":
                switch ($_POST['flg']) {
                    case "A":
                        echo '<select name="areaA" id="areaA" class="form-control" onchange="javascript:selectCityA();" >';
                        break;
                    case  "B":
                        echo '<select name="areaB" id="areaB" class="form-control" onchange="javascript:selectCityB();" >';
                        break;
                };
                $sql = 'SELECT * FROM tab_area WHERE country_id='.$_POST['id_country'].' ORDER BY region ASC';
                $res = mysqli_query($mysqli, $sql);
                echo '<option value="0"></option>';
                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                        echo '<option value="'.$row['id'].'">'.$row['region'].'</option>';
                };
                echo '</select>';
                //echo '</div>';
                break;
                
        case "showCityForInsert":
                switch ($_POST['flg']) {
                    case "A":
                        echo '<select name="townA" id="townA" class="form-control" onchange="javascript:selectTownA();">';
                        break;
                    case  "B":
                        echo '<select name="townB" id="townB" class="form-control" onchange="javascript:selectTownB();">';
                        break;
                };
                $sql = 'SELECT * FROM tab_town WHERE country_id='.$_POST['id_country'].' AND area_id='.$_POST['id_region'].' ORDER BY town ASC';
                $res = mysqli_query($mysqli, $sql);
                echo '<option value="0"></option>';
                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                        echo '<option value="'.$row['id'].'">'.$row['town'].'</option>';
                };
                echo '</select>';
                break;
        
};
//Close database connection
mysqli_close($mysqli);
?>