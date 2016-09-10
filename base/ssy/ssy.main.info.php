<?php
header("Content-Type: text/html; charset=utf-8");
if (!isset($_GET['ssy_id'])) {
    header("location: ../../includes/info.error.php");
}
?>
    <!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="../css/w3.css" />
        <title>info: ССу #<?php echo $_GET['ssy_id'] ?></title>
    </head>
    <body>
<?php
require "../../includes/constants.php";
//Open database connection
$mysqli = mysqli_connect($host,$user,$password,$db);
$sql = 'SELECT net_o.id_oper,tb_ta.town AS ta,net_o.side_a,tb_tb.town AS tb,net_o.side_b,net_o.speed_d,oper.client,net_o.cost,net_o.num_canal,net_o.note,
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
        LEFT JOIN  tab_catal_our_company ON net_o.our_company=tab_catal_our_company.id_our
        WHERE id_oper = '.$_GET['ssy_id'];
$res = mysqli_query($mysqli, $sql);
$ssy = mysqli_fetch_assoc($res);
?>
    <div class="w3-container">
        <div class="w3-text-red w3-col" style="width:15%">Точка А:</div>
        <div class="w3-rest"><?php echo $ssy['ta'].', '.$ssy['side_a'] ?></div>
    </div>
    <div class="w3-container">
        <div class="w3-text-pink w3-col" style="width:15%">Точка Б:</div>
        <div class="w3-rest"><?php echo $ssy['tb'].', '.$ssy['side_b'] ?></div>
    </div>
    <div class="w3-container">
        <div class="w3-text-teal w3-col" style="width:15%">Скорость:</div>
        <div class="w3-rest"><?php echo $ssy['speed_d'] ?></div>
    </div>
    <div class="w3-container">
        <div class="w3-text-deep-purple w3-col" style="width:15%">Субпровайдер:</div>
        <div class="w3-rest"><?php echo $ssy['client'] ?></div>
    </div>
    <div class="w3-container">
        <div class="w3-text-blue-grey w3-col" style="width:15%">Стоимость:</div>
        <div class="w3-rest"><?php echo $ssy['cost'] ?></div>
    </div>
    <div class="w3-container">
        <div class="w3-text-blue w3-col" style="width:15%">№ задачи:</div>
        <div class="w3-rest"><?php echo $ssy['plannerid'] ?></div>
    </div>
    <div class="w3-container">
        <div class="w3-text-deep-orange w3-col" style="width:15%">Тип услуги:</div>
        <div class="w3-rest"><?php echo $ssy['name_sk'] ?></div>
    </div>
    <div class="w3-container">
        <div class="w3-text-lime w3-col" style="width:15%">Название клиента:</div>
        <div class="w3-rest"><?php echo $ssy['nmcli'] ?></div>
    </div>
    <div class="w3-container">
        <div class="w3-text-green w3-col" style="width:15%">corp\retail:</div>
        <div class="w3-rest"><?php echo $ssy['corp_retail'] ?></div>
    </div>
    <div class="w3-container">
        <div class="w3-text-grey w3-col" style="width:15%">Дата включения:</div>
        <div class="w3-rest"><?php echo date("d.m.Y",strtotime($ssy['condition_d'])) ?></div>
    </div>
    <div class="w3-container">
        <div class="w3-text-orange w3-col" style="width:15%">Состояние:</div>
        <div class="w3-rest"><?php echo $ssy['name_s'] ?></div>
    </div>
    <div class="w3-container">
        <div class="w3-text-brown w3-col" style="width:15%">Примечание:</div>
        <div class="w3-rest"><?php echo $ssy['note'] ?></div>
    </div>
<?php
mysqli_close($mysqli);
?>
</body>
</html>