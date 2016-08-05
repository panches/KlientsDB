<?php
require "../includes/constants.php";
//Open database connection
$mysqli = mysqli_connect($host,$user,$password,$db) or die("Ошибка " . mysqli_error($mysqli));
// SQL запрос
$sql = 'SELECT d.id_data,k.client,t.name,d.speed AS sp,concat_WS(", ",k1.client,t1.town,o1.street) AS o_a,concat_WS(", ",k2.client,t2.town,o2.street) AS o_b,s.name AS status
                    FROM net_data d
                    LEFT JOIN tab_klients k ON d.client=k.id
                    LEFT JOIN tab_katal_sk_type t ON d.type_serv_d=t.id
                    LEFT JOIN tab_status s ON d.status_d=s.id
                    LEFT JOIN office_kli o1 ON d.office_a=o1.id_kli
                    LEFT JOIN tab_klients k1 ON o1.klient=k1.id
                    LEFT JOIN tab_town t1 ON o1.town_id=t1.id
                    LEFT JOIN office_kli o2 ON d.office_b=o2.id_kli
                    LEFT JOIN tab_klients k2 ON o2.klient=k2.id
                    LEFT JOIN tab_town t2 ON o2.town_id=t2.id
                    LEFT JOIN zaporozhie z ON d.zaporozhie=z.inv_number
                    ORDER BY d.id_data';
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