<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
	session_start();
	if(!isset($_SESSION["session_username"])) {
   		header("location: ../index.html");
	} else {
		$title = 'Тестовая base'; // Титулка страницы
		$new_links = ''; // Добавочные стили
// links: sm,a_button
    include("../includes/header.php");
//  MENU
    include("../includes/main_menu.php");
?>
<!-- main zone -->
	<div id="welcome">
 		<h2>Добро пожаловать, <span><?php echo $_SESSION['session_username']; ?></span>!</h2>
 		<a href="#" class="a_button">Комментировать</a>
 		<a href="#" class="a_button">Отвечать</a>
		<p><a href="../includes/logout.php">Выйти</a> из системы</p>
	</div>
    <br>
<?php
        require "../includes/constants.php";
        //Open database connection
        $mysqli = mysqli_connect($host,$user,$password,$db)
                    or die("Ошибка " . mysqli_error($mysqli));
        // берем время с сервера
        $sql = 'SELECT NOW() as dt';
        $temp = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_assoc($temp);
        echo $dt_str = htmlentities(mysqli_real_escape_string($mysqli, date("Y-m-d H:i:s", strtotime($row['dt']))));
        echo '<br>';
        $date_raw = (date('s') + strtotime("+13 day"));
        switch ( date('l',$date_raw) ){
            case 'Saturday':
                $str = (date('s') + strtotime("+12 day"));
                $dt_out = date('Y-m-d',$str);
                break;
            case 'Sunday':
                $str = (date('s') + strtotime("+11 day"));
                $dt_out = date('Y-m-d',$str);
                break;
            default:
                $dt_out = date('Y-m-d',$date_raw);
        };
        echo date('Y-m-d',$date_raw);
        echo date('l',$date_raw);
        echo $dt_out
?>
    <br>
<!-- footer: jQuery, SmartMenus+js -->
	<?php include("../includes/footer.php"); ?>
</body>
</html>
<?php
	}
?>