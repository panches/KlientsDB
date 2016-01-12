<?php

ini_set('default_charset',"UTF-8");

require "../../includes/constants.php";
//Open database connection
$mysqli = mysqli_connect($host,$user,$password,$db)
                or die("Ошибка " . mysqli_error($mysqli));

switch ($_POST['action']){
                
        case "showRegionForInsert":
                echo '<select name="area" id="area" class="form-control" onchange="javascript:selectCity();" >';
                $sql = 'SELECT * FROM tab_area WHERE country_id='.$_POST['id_country'].' ORDER BY region ASC';
                $res = mysqli_query($mysqli, $sql);
                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                        echo '<option value="'.$row['id'].'">'.$row['region'].'</option>';
                };
                echo '</select>';
                //echo '</div>';
                break;
                
        case "showCityForInsert":
                echo '<select name="town" id="town" class="form-control" onchange="javascript:selectTown();">';
                $sql = 'SELECT * FROM tab_town WHERE country_id='.$_POST['id_country'].' AND area_id='.$_POST['id_region'].' ORDER BY town ASC';
                $res = mysqli_query($mysqli, $sql);
                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                        echo '<option value="'.$row['id'].'">'.$row['town'].'</option>';
                };
                echo '</select>';
                break;
        
};
//Close database connection
mysqli_close($mysqli);
?>