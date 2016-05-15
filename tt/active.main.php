<?php
    ini_set('default_charset',"UTF-8");
// проверка на существование открытой сессии (вставлять во все новые файлы)
	session_start();
	if(!isset($_SESSION["session_username"])) {
   		header("location: ../index.html");
	} else {
		$title = 'Активные TT'; // Титулка страницы
		$new_links = ''; // Добавочные стили
?>
<!-- links: sm -->
    <?php include("../includes/header.php"); ?>
    <div class="container-fluid">
<!--  MENU -->
    	<?php include("../includes/main_menu.php"); ?>
        <br>
<!--Кнопки вверху таблицы-->
        <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn btn-default" onclick="window.open('active.info.php');" id="a1">Info</button>
                <button type="button" class="btn btn-default" onclick="window.open('active.closeTT.php');" id="a2">Закрыть</button>
                <button type="button" class="btn btn-default" onclick="window.open('active.putAsideTT.php');" id="a3">Отложить</button>
                <button type="button" class="btn btn-default" onclick="window.open('active.addTT.php');" id="a4">Добавить запись</button>
            </div>
            <div class="col-md-6">
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="rm1">Рабочее место:</label>
                        <select id="rm1" class="rm form-control" name="sector" onchange="selectWorkers();">
                            <option value="0">Все</option>
                            <option value="1000000">РУ</option>
                            <option value="2000000">Дежурная смена</option>
                            <option value="3000000">Дежурная смена (СШС)</option>
                            <option value="4000000">Дежурная смена (ССС)</option>
                            <option value="5000000">Дежурная смена (ДЦ)</option>
                            <option value="6000000">Тестовая эксплуатация</option>
                            <option value="7000000">Подчиненные ТТ</option>
                            <option value="8000000">ТОП НЕТ</option>
                            <option value="9000000">Сектор И.Доступа</option>
                        </select>
                        <select class="rm form-control" name="workers">
                            <option value="0">Все</option>
                            <option value="1000000">РУ</option>
                            <option value="2000000">Дежурная смена</option>
                            <option value="3000000">Дежурная смена (СШС)</option>
                            <option value="4000000">Дежурная смена (ССС)</option>
                            <option value="5000000">Дежурная смена (ДЦ)</option>
                            <option value="6000000">Тестовая эксплуатация</option>
                            <option value="7000000">Подчиненные ТТ</option>
                            <option value="8000000">ТОП НЕТ</option>
                            <option value="9000000">Сектор И.Доступа</option>
                            <option value="-1">-</option>
                        </select>
                    </div>
                    <input type="button" value="Ok" class="btn" onclick="clickWorkers();" /><br>
                </form>
            </div>
        </div>
        <br>
 <!-- Таблица main -->
        <table id="active" class="display cell-border compact" cellspacing="0" width="135%">
            <thead>
            <tr>
                <th>№</th>
                <th>S</th>
                <th>pri</th>
                <th>Клиент</th>
                <th>Дата</th>
                <th>Время</th>
                <th>Причина открытия</th>
                <th>Открыл</th>
                <th>Ответственный</th>
                <th>в работе (часов)</th>
                <th>Тип ТТ</th>
            </tr>
            </thead>
        </table>
<!-- Таблица записей -->
        <p>Записи:</p>
        <table id="records" class="display cell-border compact" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>№</th>
                <th>Дата</th>
                <th>Время</th>
                <th>Контактировал с</th>
                <th>Выполнено</th>
                <th>Внес</th>
            </tr>
            </thead>
        </table>
<!-- footer: jQuery, SmartMenus+js -->
	    <?php include("../includes/footer.php"); ?>
    </div>
    <script>
        $(document).ready(function() {
            aTable = $("#active").dataTable({
                "scrollX": true
            });
            var rTable = $("#records").dataTable({
                "columnDefs": [
                    {"targets": [0], "visible": false},
                    {"targets": [1], "width": "6%"},
                    {"targets": [2], "width": "6%"},
                    {"targets": [3], "width": "20%"},
                    {"targets": [4], "width": "58%"},
                    {"targets": [5], "width": "8%"}
                ]
            });
            $.ajax({
                type: 'POST',
                url: 'active.ajax.sql.action.php',
                data: { action: 'showAllRecords' },
                dataType: 'json',
                success: function(s){
                    aTable.fnClearTable();
                    for(var i = 0; i < s.length; i++) {
                        aTable.fnAddData([
                            s[i][0],s[i][1],s[i][2],s[i][3],s[i][4],s[i][5],s[i][6],s[i][7],s[i][8],s[i][9],s[i][10]
                        ]);
                    } // End For
                },
                error: function(e){
                    console.log(e.responseText);
                }
            });
            // select entery row
            $('#active tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    $("#a1").attr("onclick","window.open('active.info.php');");
                }
                else {
                    aTable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    // отбор позиции строки и значение столбца
                    var aPos = aTable.fnGetPosition( this );
                    var aData = aTable.fnGetData( aPos );
                    $("#a1").attr("onclick","window.open('active.info.php?tt_id=" + aData[0] + "');");
                    rTable.fnClearTable();
                    $.ajax({
                        type: "POST",
                        url: "active.ajax.sql.action.php",
                        data: { action: 'showSlaveTable', idNum: aData[0] },
                        dataType: 'json',
                        success: function(s) {
                            for(var i = 0; i < s.length; i++) {
                                rTable.fnAddData([
                                    s[i][0],s[i][1],s[i][2],s[i][3],s[i][4],s[i][5]
                                ]);
                            } // End For
                        },
                        error: function(e){
                            console.log(e.responseText);
                        }
                    });
                };
            });
        });
        function selectWorkers() {
            var num = $('select[name="sector"]').val();
            $.ajax({
                type: "POST",
                url: "active.ajax.sql.action.php",
                data: { action: 'showWorkers', num: num },
                cache: false,
                success: function(responce) { $('select[name="workers"]').html(responce); }
            });
        };
        function clickWorkers() {
            var num1 = $('select[name="sector"]').val();
            var num2 = $('select[name="workers"]').val();
            aTable.fnClearTable();
            $.ajax({
                type: "POST",
                url: "active.ajax.sql.action.php",
                data: { action: 'showSelectedRecords', sector: num1, workers: num2 },
                dataType: 'json',
                success: function(s) {
                    for(var i = 0; i < s.length; i++) {
                        aTable.fnAddData([
                            s[i][0],s[i][1],s[i][2],s[i][3],s[i][4],s[i][5],s[i][6],s[i][7],s[i][8],s[i][9],s[i][10]
                        ]);
                    } // End For
                },
                error: function(e){
                    console.log(e.responseText);
                }
            });
        };
    </script>
</body>
</html>
<?php
	}
?>