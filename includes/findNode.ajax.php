<?php
    require "../includes/constants.php";
    //Open database connection
    $mysqli = mysqli_connect($host,$user,$password,$db);
    /* проверка подключения */
    if (mysqli_connect_errno()) {
        printf("Не удалось подключиться: %s\n", mysqli_connect_error());
        exit();
    }
    // SQL запрос
    $sql = 'SELECT t.inv_id, t.node_old, c.country, a.region, w.town, t.address
              FROM tblinform2 t, tab_town w, tab_country c, tab_area a
              WHERE t.town_id=w.id and t.country_id=c.id and t.area_id=a.id
              ORDER BY town, inv_id';
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