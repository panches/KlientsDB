<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
    session_start();
    if(!isset($_SESSION["session_username"])) {
        header("location: ../index.html");
    };
?>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Добавить Аутсорсинг</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../../css/jquery.steps.css">
    <link rel="stylesheet" href="../../css/jquery.dataTables.css" />
    <link rel="stylesheet" href="../css/fieldset.css" />
    <style type="text/css">
        input:required:invalid, input:focus:invalid {
          background-image: url(../../img/invalid.png);
          background-position: right top;
          background-repeat: no-repeat;
        }
        input:required:valid {
          background-image: url(../../img/valid.png);
          background-position: right top;
          background-repeat: no-repeat;
        }
    </style>
    <script src="../../js/jquery-1.11.0.min.js"></script>
    <script src="../../js/modernizr-2.6.2.min.js"></script>
    <script src="../../js/jquery.cookie-1.3.1.js"></script>
    <script src="../../js/jquery.steps.min.js"></script>
    <script src="../../js/jquery.dataTables.min.js"></script>
  </head>
  <body>
  	<div id="wizard">
	    <h2>Абонент</h2>
    	<section>
<!-- Таблица Абонент -->
      <table id="office" class="display cell-border compact" cellspacing="0" width="100%"></table>
      <div id="ok_show"><font color="red"></font></div>
      </section>

	    <h2>Модель устройства</h2>
    	<section>
<!-- Таблица Модель устройства -->
      <table id="equip" class="display cell-border compact" cellspacing="0" width="100%"></table>
      <div id="eq_show"><font color="red"></font></div>
      </section>

	    <h2>Остальные данные</h2>
    	<section>
<!-- Форма Остальные данные -->
      <form method="post" action="outs.main.add.sql.php">
        <fieldset>
        <legend>Новая запись</legend>
        <div>
          <label for="office">Абонент:</label>
          <input type="text" name="office" id="a1" class="txt" value="" required />
          <input type="hidden" name="office2" id="a2" class="txt" value="" />
        </div>
        <div>
          <label for="name">Имя узла сети:</label>
          <input type="text" name="name" id="b" class="txt" value="" required />
        </div>
        <div>
          <label for="equip">Модель устройства:</label>
          <input type="text" name="equip" id="c1" class="txt" value="" required />
          <input type="hidden" name="equip2" id="c2" class="txt" value="" />
        </div>
        <div>
          <label for="num">Серийный номер:</label>
          <input type="text" name="num" id="d" class="txt" value="" required />
        </div>
        <div>
          <label for="license">Тип лицензии:</label>
          <input type="text" name="license" id="e" class="txt" value="" required />
        </div>
        <div>
          <label for="note">Примечание:</label>
          <textarea   cols="35" rows="3" name="note" id="f" class="note"></textarea>
        </div>
        </fieldset>
        <div>
         <button name="btnOk" id="btnOk" class="btnOk"><img src="../../img/ok.png" style="vertical-align: middle"> Ok</button>
        </div>
      </form>
      </section>
  	</div>
<!-- JS -->
    <script> // wizard
    	$(function(){
    	    $("#wizard").steps({
        		headerTag: "h2",
                bodyTag: "section"
       		});
    	});
    </script>
    <script>
    $(document).ready(function(){
    // Офисы Клиентов
      var oTable = $("#office").dataTable({
        "scrollY":        "300px",
        "scrollCollapse": true,
        "processing": true,
        "ajax": "../../includes/findOK.ajax.php",
        "columns": [
          {"title": "№"},
          {"title": "Клиент"},
          {"title": "Город"},
          {"title": "Улица"},
          {"title": "Название в NMS"},
          {"title": "Порт"},
          {"title": "ПМ"},
          {"title": "Страна"},
          {"title": "Область"}
        ]
      });
    // select entery row
      $('#office tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            oTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        };
        // отбор позиции строки и значение столбца
        var oPos = oTable.fnGetPosition( this );
        var oData = oTable.fnGetData( oPos );
        $("#ok_show").html('<font color="red">' + oData[1] + ", " + oData[2] + ", " + oData[3] + '</font>');
        $("#a1").attr("value",oData[1] + ", " + oData[2] + ", " + oData[3]);
        $("#a2").attr("value",oData[0]);
      });
    // Сетевые Устройства
      var eTable = $("#equip").dataTable({
        "scrollY":        "300px",
        "scrollCollapse": true,
        "processing": true,
        "ajax": "../../includes/findEq.ajax.php",
        "columns": [
          {"title": "№"},
          {"title": "Тип сети"},
          {"title": "IP-адрес"},
          {"title": "Название в NMS"},
          {"title": "Адрес расположения"},
          {"title": "Производитель"},
          {"title": "Модель"}
        ]
      });
    // select entery row
      $('#equip tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            eTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        };
        // отбор позиции строки и значение столбца
        var ePos = eTable.fnGetPosition( this );
        var eData = eTable.fnGetData( ePos );
        $("#eq_show").html('<font color="red">' + eData[3] + '</font>');
        $("#c1").attr("value",eData[3]);
        $("#c2").attr("value",eData[0]);
      });
    })
    </script>
  </body>
</html>