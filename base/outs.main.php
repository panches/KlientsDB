<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
	session_start();
	if(!isset($_SESSION["session_username"])) {
   		header("location: ../index.html");
	} else {
    // добавить значение параметров в header.php
		$title = 'Аутсорсинг'; // Титулка страницы
		$new_links = ''; // Добавочные стили
?>
<!-- links: sm,a_button -->
    <?php include("../includes/header.php"); ?>
    <div class="container-fluid">
<!--  MENU -->
        <?php include("../includes/main_menu.php"); ?>
        <br>
<!-- Кнопки вверху -->
        <div class="row">
            <div class="col-md-12">
                <a href="outs.main.info.php" target="_blank" class="btn btn-default" id="a1">Info</a>
                <a href="outs.main.add.php" target="_blank" class="btn btn-default" id="a2">New</a>
                <a href="outs.main.edit.php" target="_blank" class="btn btn-default" id="a3">Edit</a>
            </div>
        </div>
        <br>
<!-- Таблица -->
        <table id="equipments" class="display cell-border compact" cellspacing="0" width="135%"></table>
<!-- footer: jQuery, SmartMenus+js -->
        <?php include("../includes/footer.php"); ?>
    </div>
	<script>
		$(function() {
            var oTable = $('#equipments').dataTable({
                "scrollX": true,
                "processing": true,
                "pagingType": "full_numbers",
                "ajax": "all.main.ajax.php?base=outs",
		    	"columns": [
          		{"title": "№"},
          		{"title": "Абонент"},
          		{"title": "Имя узла"},
          		{"title": "Область"},
          		{"title": "Город"},
          		{"title": "Улица"},
          		{"title": "Модель усторйства"},
          		{"title": "Серийный номер"},
          		{"title": "Тип лицензии"},
          		{"title": "Изменение внес"},
          		{"title": "время"} ] 
          	});
            // select pressed row
            $('#equipments tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    $("#a1").attr("href","outs.main.info.php");
                }
                else {
                    oTable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    // отбор позиции строки и значение столбца
                    var aPos = oTable.fnGetPosition( this );
                    var aData = oTable.fnGetData( aPos );
                    $("#a1").attr("href","outs.main.info.php?outs_id=" + aData[0]);
                    $("#a3").attr("href","outs.main.edit.php?outs_id=" + aData[0]);
                };
            })
		});
  </script>	  	
</body>
</html>
<?php
	}
?>