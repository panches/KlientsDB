<?php
    require "../../includes/constants.php";
    //Open database connection
    $mysqli = mysqli_connect($host, $user, $password, $db) or die("Ошибка " . mysqli_error($mysqli));

    if(isset($_GET['f'])) {
        switch($_GET['f']) {
            case 1:
                if (is_numeric($_POST['speed'])) {
                    echo $error = 'true';
                } else {
                    echo $error = 'false';
                };
                break;
            case 2:
                $kli = $_POST['kli1'];
                $sql = "select count(*) as num from tab_klients where client = '$kli'";
                $res = mysqli_query($mysqli, $sql);
                $row = mysqli_fetch_assoc($res);
                if($row['num'] == 0){
                    echo $error = 'false';
                } else {
                    echo $error = 'true';
                };
                break;
            case 3:
                $cid = $_POST['cid'];
                $sk_id = $_GET['id'];
                $sql = 'SELECT CONCAT("CID: ",CID,", ",GetNameOfClient(7,net_data.id_data)) AS info FROM net_data
                        WHERE CID like "'.$cid.'" AND CID NOT LIKE "" AND status_d = "2" AND id_data <> "' . $sk_id .'"';
                $res = mysqli_query($mysqli, $sql) or die("ERROR: " . mysql_error());
                $num = mysqli_num_rows($res);
                if($num == 0){
                    echo $error = 'false';
                } else {
                    echo $error = 'true';
                };
                break;
        }
    };

    // закрываем подключение
    mysqli_close($mysqli);

?>