<?php
    header("Content-Type: text/html; charset=utf-8");
    if (!isset($_GET['info'])) {
        echo "Нет данных! Ошибка.";  exit();
    } else {
      switch ($_GET['info']) {
          case 1:
              $text = "Запись сохраннена успешно!";
              break;
          case 2:
              $text = "Запись изменена успешно!";
              break;
      };
    };
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Информация</title>
    <style type="text/css">
        body {
            background-color: #31802d;
        }
        #info {
            width: 500px;
            height: 100px;
            line-height: 65px;
            display: block;
            position: absolute;
            left:50%;
            top:50%;
            margin-left:-250px; /*Смещаем блок на половину всей ширины влево*/
            margin-top:-50px; /*Смещаем блок на половину высоты вверх*/
            background-color: #ffb435;
            text-align: center;
            border-radius: 6px;
            -webkit-border-radius: 6px;
            -moz-border-radius: 5px;
            -khtml-border-radius: 10px;
        }
        #exit {
            position: absolute;
            top: 0px;
            right: 0px;
        }
        p {
            font-size: 1.4em;
        }
    </style>
</head>
<body>
<div id="exit">
    <img src="../img/exit.png" alt="Закрыть окно" onclick="window.close();">
</div>
<div id="info">
    <p><?php echo $text; ?></p>
</div>
</body>
</html>