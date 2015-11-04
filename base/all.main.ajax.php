<?php
if(!isset($_GET["base"])) {
    //Return result to
    $out = array('data' => []);
    echo json_encode($out);
} else {
    require "../includes/constants.php";
//Open database connection
    $mysqli = mysqli_connect($host,$user,$password,$db);
    /* проверка подключения */
    if (mysqli_connect_errno()) {
        printf("Не удалось подключиться: %s\n", mysqli_connect_error());
        exit();
    };
// SQL запрос
    switch($_GET["base"]) {
        case "tp":
            $sql = 'SELECT t.inv_id,t.node_old,c.country,a.region,w.town,t.address
                    FROM tblinform2 t, tab_town w, tab_country c, tab_area a
                    WHERE t.town_id=w.id and t.country_id=c.id and t.area_id=a.id';
            break;

        case "cy":
            $sql = 'SELECT e.id_equip,n.net,e.ip_address,e.name_nms,concat_WS(" ",t.town,i.address) as addr,concat_WS(" ",b.brend,b.model) as brend_model
                    FROM klients.net_equip e, klients.tblinform2 i, klients.tab_town t, tab_nets n, tab_equip b
                    WHERE e.linkage="0" AND e.num_node=i.inv_id AND i.town_id=t.id AND i.town_id=t.id AND e.net=n.id AND e.num_equip=b.id
                    UNION ALL
                    SELECT e.id_equip,n.net,e.ip_address,e.name_nms,concat_WS(" ",k.client,o.street) as addr,concat_WS(" ",b.brend,b.model) as brend_model
                    FROM klients.net_equip e, klients.office_kli o, klients.tab_klients k, tab_nets n, tab_equip b
                    WHERE e.linkage="1" AND e.num_node=o.id_kli AND o.klient=k.id AND e.net=n.id AND e.num_equip=b.id
                    ORDER BY id_equip ASC';
                    break;

        case "ss":
            $sql = 'SELECT id_link,sign_net,name,flag_link,planerid,status_d,equip_a,equip_b FROM net_links ORDER BY id_link';
            break;

        case "ok":
            $sql = 'SELECT o.id_kli,k.client,c.country,a.region,t.town,o.street,o.kont_tel,s.name
                    FROM office_kli o, tab_klients k, tab_town t, tab_country c, tab_area a, tab_status s
                    WHERE o.klient=k.id and t.id=o.town_id and o.country_id=c.id and o.area_id=a.id and o.status_d=s.id
                    ORDER BY o.id_kli';
                    break;

        case "sk":
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
            break;

        case "outs":
            $sql = 'SELECT outs.outs_id,k.client,outs.hostname,a.region,t.town,kli.street,concat(teq.brend,"  ",teq.model) as brend_model,outs.serial,outs.license,ac.nik,outs.last_change
                    FROM outs_hardware outs, office_kli kli, net_equip neq, tab_klients k, tab_town t, tab_area a, tab_equip teq, tab_access ac
                    WHERE outs.clients=kli.id_kli AND outs.hardware=neq.id_equip AND kli.klient=k.id AND kli.town_id=t.id AND kli.area_id=a.id AND neq.num_equip=teq.id AND outs.change_login=ac.id';
            break;

    };
//Get records from database
    $result = mysqli_query($mysqli, $sql);
//Add all records to an array
    while ($row = mysqli_fetch_array($result, MYSQL_NUM)) {
        $rows[] = $row;
    };
    mysqli_free_result($result);
//Return result to
    $out = array('data' => $rows);
    echo json_encode($out);

}
?>