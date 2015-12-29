<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location: ../index.html");
} else {
// добавить значение параметров в header.php
    $title = 'Клиенты (ССС)'; // Титулка страницы
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
                <a href="sput/sput.main.info.php" target="_blank" class="btn btn-default" id="a1">Info</a>
                <a href="sput/sput.main.add.php" target="_blank" class="btn btn-default" id="a2">New</a>
                <a href="sput/sput.main.edit.php" target="_blank" class="btn btn-default" id="a3">Edit</a>
            </div>
        </div>
        <br>
<!-- Таблица -->
        <table id="sputtab" class="display cell-border compact" cellspacing="0" width="100%"></table>
<!-- footer: jQuery, SmartMenus + js -->
        <?php include("../includes/footer.php"); ?>
    </div>
    <script>
        $(function() {
            var nTable = $('#sputtab').dataTable({
                "processing": true,
                "pagingType": "full_numbers",
                "iDisplayLength": 25,
                "ajax": "all.main.ajax.php?base=sput",
                "columns": [
                    {"title": "№"},
                    {"title": "класс"},
                    {"title": "Клиент"},
                    {"title": "Страна"},
                    {"title": "Область"},
                    {"title": "Город"},
                    {"title": "Улица"},
                    {"title": "Спутник"},
                    {"title": "Тип сети"},
                    {"title": "Станция"},
                    {"title": "Название устройства"},
                    {"title": "IP адрес"},
                    {"title": "Статус"}]
            });
            // select pressed row
            $('#sputtab tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    $("#a1").attr("href","sput/sput.main.info.php");
                }
                else {
                    nTable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    // отбор позиции строки и значение столбца
                    var aPos = nTable.fnGetPosition( this );
                    var aData = nTable.fnGetData( aPos );
                    $("#a1").attr("href","sput/sput.main.info.php?sput_id=" + aData[0]);
                    $("#a3").attr("href","sput/sput.main.edit.php?sput_id=" + aData[0]);
                };
            })
        });
    </script>
    </body>
    </html>
<?php
}
?>