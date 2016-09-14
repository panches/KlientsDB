<?php
// уничтожении сессии
	session_start();
    $_SESSION = array();
    // уничтожение куки с идентификатором сессии
    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');
	session_destroy();
    // перенаправить на страницу ввхода
    header("location: ../index.html");
?>