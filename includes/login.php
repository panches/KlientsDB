<?php 
/* Open session */	
	session_start();
/* Open database connection*/
    require ("constants.php");
/* проверка подключения */
    $mysqli = mysqli_connect($host,$user,$password,$db);
	if (mysqli_connect_errno()) {
    	printf("Не удалось подключиться: %s\n", mysqli_connect_error());
    	exit();
	} 
// в целях проверки
	if(isset($_SESSION["session_username"])){
	// вывод "Session is set"
		header("Location: ../base/tp.main.php");
	}
// нажата кнопка?
	if(isset($_POST["login"])){
		// валидация
		if(!empty($_POST['username']) && !empty($_POST['password'])) {
			$username=$_POST['username'];
			$password=md5($_POST['password']);
			$query =mysqli_query($mysqli, "SELECT * FROM tab_access WHERE login='".$username."' AND pwd='".$password."'");
			$numrows=mysqli_num_rows($query);
			if($numrows!=0) {
				$_SESSION['session_username']=$username;	 
			 /* Перенаправление браузера */
   				header("Location: ../base/tp.main.php");
			} else {
				echo  "Invalid username or password!";
	 		}
		} else {
    		echo "All fields are required!";
		}
	};
?>