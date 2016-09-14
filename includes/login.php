<?php 
// Open session
	session_start();
// в целях проверки
	if(isset($_SESSION["session_username"])){
    /* Перенаправление браузера */
		header("Location: ../base/tp.main.php");
	}
// Open database connection
    require ("constants.php");
// проверка подключения
    $mysqli = mysqli_connect($host,$user,$password,$db)
                or die("Ошибка " . mysqli_error($mysqli));
// нажата кнопка?
	if(isset($_POST["login"])){
		// валидация
		if(!empty($_POST['username']) && !empty($_POST['password'])) {
			$username=$_POST['username'];
			$password=md5($_POST['password']);
			$query =mysqli_query($mysqli, "SELECT * FROM tab_access WHERE login='".$username."' AND pwd='".$password."'");
			$numrows=mysqli_num_rows($query);
			if($numrows!=0) {
                $access = mysqli_fetch_assoc($query);
				$_SESSION['session_userid']=$access['id'];
                $_SESSION['session_userlogin']=$access['login'];
                $_SESSION['session_username']=$access['nik'];
			 /* Перенаправление браузера */
   				header("Location: ../base/tp.main.php");
			} else {
				echo  "Invalid username or password!";
	 		}
		} else {
    		echo "All fields are required!";
		}
	};
// закрываем подключение
    mysqli_close($mysqli);
?>