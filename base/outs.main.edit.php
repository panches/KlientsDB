<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
    session_start();
    if(!isset($_SESSION["session_username"])) {
        header("location: ../index.html");
    };
    header("Content-Type: text/html; charset=utf-8");
    if (!isset($_GET['outs_id'])) {
        echo "Не выбрана запись!";  exit();
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>edit: Аутсорсинг #<?php echo $_GET['outs_id'] ?></title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="../css/jquery.steps.css">
    <link rel="stylesheet" href="../css/jquery.dataTables.css" />
    <link rel="stylesheet" href="css/fieldset.css" />
    <style type="text/css">
      input:required:invalid, input:focus:invalid {
        background-image: url(../img/invalid.png);
        background-position: right top;
        background-repeat: no-repeat;
      }
      input:required:valid {
        background-image: url(../img/valid.png);
        background-position: right top;
        background-repeat: no-repeat;
      }
    </style>
    <script src="../js/jquery-1.11.0.min.js"></script>
    <script src="../js/modernizr-2.6.2.min.js"></script>
    <script src="../js/jquery.cookie-1.3.1.js"></script>
    <script src="../js/jquery.steps.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
  </head>
  <body>
<?php
  require "../includes/constants.php";
  //Open database connection
  $mysqli = mysqli_connect($host,$user,$password,$db);
  $sql = 'SELECT outs.outs_id,outs.clients,k.client,outs.hostname,outs.hardware,neq.name_nms,outs.serial,outs.license,outs.info,a.region,t.town,kli.street,concat(teq.brend,"  ",teq.model) as brend_model 
          FROM outs_hardware outs, office_kli kli, net_equip neq, tab_klients k, tab_town t,  tab_area a, tab_equip teq, tab_access ac 
          WHERE outs.clients=kli.id_kli AND outs.hardware=neq.id_equip AND kli.klient=k.id AND kli.town_id=t.id AND kli.area_id=a.id AND neq.num_equip=teq.id AND outs.change_login=ac.id AND outs.outs_id='.$_GET['outs_id'];
  $res = mysqli_query($mysqli, $sql);
  $outs = mysqli_fetch_array($res, MYSQLI_ASSOC);

  echo	'<div id="wizard">';
	echo  '<h2>Абонент</h2>';
  echo  '<section>';
// Таблица Абонент
  echo  ' <table id="office" class="display cell-border compact" cellspacing="0" width="100%"></table>';
  echo  '  <div id="ok_show"><font color="red">'.$outs['client'].' '.$outs['town'].' '.$outs['street'].'</font></div>';
  echo  '</section>';
 
	echo  '<h2>Модель устройства</h2>';
  echo  '<section>';
// Таблица Модель устройства
  echo  ' <table id="equip" class="display cell-border compact" cellspacing="0" width="100%"></table>';
  echo  '  <div id="eq_show"><font color="red">'.$outs['name_nms'].'</font></div>';
  echo  '</section>';

	echo  '<h2>Остальные данные</h2>';
  echo  '<section>';
// Форма Остальные данные
  echo  '<form method="post" action="outs.main.edit.sql.php">';
  echo  ' <fieldset>';
  echo  '  <legend>Запись №'.$outs['outs_id'].'</legend>';  
  echo  '  <div>';
  echo  '    <input type="hidden" name="id_outs" id="a0" class="txt" value="'.$outs['outs_id'].'" />';
  echo  '    <label for="office">Абонент:</label>';
  echo  '    <input type="text" name="office" id="a1" class="txt" value="'.$outs['client'].'" required />';
  echo  '    <input type="hidden" name="office2" id="a2" class="txt" value="'.$outs['clients'].'" />';
  echo  '  </div>';
  echo  '  <div>';
  echo  '    <label for="name">Имя узла сети:</label>';
  echo  '    <input type="text" name="name" id="b" class="txt" value="'.$outs['hostname'].'" required />';
  echo  '  </div>';
  echo  '  <div>';
  echo  '    <label for="equip">Модель устройства:</label>';
  echo  '    <input type="text" name="equip" id="c1" class="txt" value="'.$outs['name_nms'].'" required />';
  echo  '    <input type="hidden" name="equip2" id="c2" class="txt" value="'.$outs['hardware'].'" />';
  echo  '  </div>';
  echo  '  <div>';
  echo  '    <label for="num">Серийный номер:</label>';
  echo  '    <input type="text" name="num" id="d" class="txt" value="'.$outs['serial'].'" required />';
  echo  '  </div>';
  echo  '  <div>';
  echo  '    <label for="license">Тип лицензии:</label>';
  echo  '    <input type="text" name="license" id="e" class="txt" value="'.$outs['license'].'" required />';
  echo  '  </div>';
  echo  '  <div>';
  echo  '    <label for="note">Примечание:</label>';
  echo  '    <textarea   cols="35" rows="3" name="note" id="f" class="note">'.$outs['info'].'></textarea>';
  echo  '  </div>';
  echo  ' </fieldset>';
?>  
        <div>
         <button name="btnOk" id="btnOk" class="btnOk"><img src="../img/ok.png" style="vertical-align: middle"> Ok</button>
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
        "ajax": "../includes/findOK.ajax.php",
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
    // select pressed row
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
        $("#ok_show").html('<font color="red">' + oData[1] + ", " + oData[2] + ", " + oData[3] + '</font');
        $("#a1").attr("value",oData[1] + ", " + oData[2] + ", " + oData[3]);
        $("#a2").attr("value",oData[0]);
      });  
    // Сетевые Устройства
      var eTable = $("#equip").dataTable({
        "scrollY":        "300px",
        "scrollCollapse": true,
        "processing": true,
        "ajax": "../includes/findEq.ajax.php",
        //"bAutoWidth": false,
        "columns": [
          {"title": "№", "width": "5%"},
          {"title": "Тип сети", "width": "10%"},
          {"title": "IP-адрес", "width": "10%"},
          {"title": "Название в NMS", "width": "25%"},
          {"title": "Адрес расположения", "width": "25%"},
          {"title": "Производитель", "width": "15%"},
          {"title": "Модель", "width": "15%"}
        ] 
      });   
    // select pressed row
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
        $("#eq_show").html('<font color="red">' + eData[3] + '</font');        
        $("#c1").attr("value",eData[3]);
        $("#c2").attr("value",eData[0]);
      });             
    })
    </script>
  </body>
</html>    