<?php
require "../includes/constants.php";
//Open database connection
$mysqli = mysqli_connect($host,$user,$password,$db) or die("Ошибка " . mysqli_error($mysqli));
// SQL запрос
$sql = 'SELECT id_link,sign_net,`name`,
              CASE
                  WHEN flag_link=0 THEN "сетевое"
                  WHEN flag_link=1 THEN "сервисное"
                  WHEN flag_link=2 THEN "межсетевое"
                  WHEN flag_link=3 THEN "сервис провайдера"
                  ELSE null
              END AS dLink
        FROM net_links
        ORDER BY id_link';
//Get records from database
$result = mysqli_query($mysqli, $sql);
//Add all records to an array
while ($row = mysqli_fetch_array($result, MYSQL_NUM)) {
    $rows[] = $row;
}
mysqli_free_result($result);
//Return result to
$out = array('data' => $rows);
echo json_encode($out);
?>