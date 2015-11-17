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
<!-- footer: jQuery, SmartMenus+js -->
	<?php include("../includes/footer.php"); ?>
</body>
</html>
<?php
	}
?>