<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location: ../index.html");
} else {
// добавить значение параметров в header.php
    $title = 'Офисы Клиентов'; // Титулка страницы
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
                <a href="ok.main.info.php" target="_blank" class="btn btn-default" id="a1">Info</a>
                <a href="ok.main.add.php" target="_blank" class="btn btn-default" id="a2">New</a>
                <a href="ok.main.edit.php" target="_blank" class="btn btn-default" id="a3">Edit</a>
            </div>
        </div>
        <br>
<!-- Таблица -->
        <table id="oktab" class="display cell-border compact" cellspacing="0" width="100%"></table>
<!-- footer: jQuery, SmartMenus + js -->
        <?php include("../includes/footer.php"); ?>
    </div>
    <script>
        $(function() {
            var nTable = $('#oktab').dataTable({
                "processing": true,
                "pagingType": "full_numbers",
                "iDisplayLength": 25,
                "ajax": "all.main.ajax.php?base=ok",
                "columns": [
                    {"title": "№"},
                    {"title": "Клиент"},
                    {"title": "Страна"},
                    {"title": "Область"},
                    {"title": "Город"},
                    {"title": "Адрес"},
                    {"title": "Контакты"},
                    {"title": "Статус"}]
            });
            // select pressed row
            $('#oktab tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    $("#a1").attr("href","ok.main.info.php");
                }
                else {
                    nTable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    // отбор позиции строки и значение столбца
                    var aPos = nTable.fnGetPosition( this );
                    var aData = nTable.fnGetData( aPos );
                    $("#a1").attr("href","ok.main.info.php?ok_id=" + aData[0]);
                    $("#a3").attr("href","ok.main.edit.php?ok_id=" + aData[0]);
                };
            })
        });
    </script>
    </body>
    </html>
<?php
}
?>