<?php
if(!isset($_GET["base"])) {
    //Return result to
    $out = array('data' => []);
    echo json_encode($out);
} else {
    require "../includes/constants.php";
//Open database connection
    $mysqli = mysqli_connect($host,$user,$password,$db)
                or die("Ошибка " . mysqli_error($mysqli));
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

        case "ssy":
            $sql = 'SELECT net_o.id_oper,tb_ta.town AS ta,net_o.side_a,tb_tb.town AS tb,net_o.side_b,net_o.speed_d,oper.client,net_o.cost,net_o.num_canal,
                    tab_catal_dogovor.dogovor,tab_catal_dogovor_dop.dop_dogovor,
                    CONCAT(tab_catal_dogovor.dogovor," от ",DATE_FORMAT(tab_catal_dogovor.dt_dogovor,"%d.%m.%Y")) AS dogovor_dt,CONCAT(tab_catal_dogovor_dop.dop_dogovor," от ",DATE_FORMAT(tab_catal_dogovor_dop.dt_dogovor_dop,"%d.%m.%Y")) AS dop_dogovor_dt,
                    net_o.contract_main,net_o.contract,tab_catal_sreda_peredachi.name_sredi,tab_katal_sk_type.name AS name_sk,net_o.plannerid,net_o.in_date,nmclient.client AS nmcli,net_o.nameclient_gridin,net_o.capex,
                    net_o.corp_retail,net_o.condition_d,net_o.d_stServ_clientu,tab_catal_podrazd.name_p,tab_status.name AS name_s,tab_catal_our_company.name_our,
                    GetNameOfClient(net_o.num_tab,net_o.data_id) AS index_str,
                    net_o.date_end,net_o.tax_doc,net_o.act_compl,net_o.acc_num,
                    concat(tab_access.nik," ",net_o.last_change) AS last_user
                    FROM net_operators net_o
                    LEFT JOIN  tab_town tb_ta ON net_o.town_a=tb_ta.id
                    LEFT JOIN  tab_area tb_ara ON tb_ta.area_id=tb_ara.id
                    LEFT JOIN  tab_town tb_tb ON net_o.town_b=tb_tb.id
                    LEFT JOIN  tab_area tb_arb ON tb_tb.area_id=tb_arb.id
                    LEFT JOIN  tab_klients oper ON net_o.operator=oper.id
                    LEFT JOIN  tab_katal_sk_type  ON net_o.for_what=tab_katal_sk_type.id
                    LEFT JOIN  tab_klients nmclient ON net_o.nameclient_id=nmclient.id
                    LEFT JOIN  tab_status ON net_o.status_d=tab_status.id
                    LEFT JOIN  tab_catal_podrazd ON net_o.podrazd=tab_catal_podrazd.id
                    LEFT JOIN  tab_access ON net_o.change_login=tab_access.id
                    LEFT JOIN  tab_catal_sreda_peredachi ON net_o.sreda_peredachi=tab_catal_sreda_peredachi.id
                    LEFT JOIN  tab_catal_dogovor ON net_o.contract_main_d=tab_catal_dogovor.id
                    LEFT JOIN  tab_catal_dogovor_dop ON net_o.dop_dogovor_d=tab_catal_dogovor_dop.id
                    LEFT JOIN  tab_catal_our_company ON net_o.our_company=tab_catal_our_company.id_our';
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
// закрываем подключение
    mysqli_close($mysqli);
//Return result to
    $out = array('data' => $rows);
    echo json_encode($out);

}
?>