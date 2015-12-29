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
        <link rel="stylesheet" type="text/css" href="../css/fieldset.css" />
        <title>info: Офис Клиента #<?php echo $_GET['ssy_id'] ?></title>
    </head>
    <body>
<?php
require "../../includes/constants.php";
//Open database connection
$mysqli = mysqli_connect($host,$user,$password,$db);
echo '<div class="container-fluid">';
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
                    LEFT JOIN  tab_catal_our_company ON net_o.our_company=tab_catal_our_company.id_our
                    where id_oper = '.$_GET['ssy_id'];
$res = mysqli_query($mysqli, $sql);
$ssy = mysqli_fetch_assoc($res);
echo '<div>Точка А: '.$ssy['ta'].', '.$ssy['side_a'].'</div>';
echo '<div>Точка Б: '.$ssy['tb'].', '.$ssy['side_b'].'</div>';
echo '<div>Скорость: '.$ssy['speed_d'].'</div>';
echo '<div>Субпровайдер: '.$ssy['client'].'</div>';
echo '<div>Стоимость: '.$ssy['cost'].'</div>';
echo '<div>№ задачи: '.$ssy['plannerid'].'</div>';
echo '<div>Тип услуги: '.$ssy['name_sk'].'</div>';
echo '<div>Название клиента: '.$ssy['nmcli'].'</div>';
echo '<div>corp\retail: '.$ssy['corp_retail'].'</div>';
echo '<div>Дата включения: '.date("d.m.Y",strtotime($ssy['condition_d'])).'</div>';
echo '<div>Состояние: '.$ssy['name_s'].'</div>';
$sql = 'SELECT note FROM net_operators WHERE id_oper='.$_GET['ssy_id'];
$res = mysqli_query($mysqli, $sql);
$temp = mysqli_fetch_assoc($res);
echo '<div>Примечание: '.$temp['note'].'</div>';
echo '</div>';
mysqli_close($mysqli);
?>
</body>
</html>