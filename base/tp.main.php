<?php
    ini_set('default_charset',"UTF-8");
// проверка на существование открытой сессии (вставлять во все новые файлы)
    session_start();
    if(!isset($_SESSION["session_username"])) {
        header("location: ../index.html");
    } else {
// добавить значение параметров в header.php
    $title = 'Tex.Площадки'; // Титулка страницы
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
                <button type="button" class="btn btn-default" onclick="window.open('tp.main.info.php');" id="a1">Info</button>
                <button type="button" class="btn btn-default" onclick="window.open('tp.main.add.php');" id="a2">New</button>
                <button type="button" class="btn btn-default" onclick="window.open('tp.main.edit.php');" id="a3">Edit</button>
            </div>
        </div>
        <br>
<!-- Таблица -->
        <table id="nodes" class="display cell-border compact" cellspacing="0" width="100%"></table>
<!-- footer: jQuery, SmartMenus + js -->
        <?php include("../includes/footer.php"); ?>
    </div>
    <script>
        $(function() {
            var nTable = $('#nodes').dataTable({
                "processing": true,
                "pagingType": "full_numbers",
                "iDisplayLength": 25,
                "ajax": "all.main.ajax.php?base=tp",
                "columns": [
                    {"title": "№"},
                    {"title": "Название"},
                    {"title": "Страна"},
                    {"title": "Область"},
                    {"title": "Город"},
                    {"title": "Адрес"}]
            });
            // select pressed row
            $('#nodes tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    $("#a1").attr("onclick","window.open('tp.main.info.php');");
                }
                else {
                    nTable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    // отбор позиции строки и значение столбца
                    var aPos = nTable.fnGetPosition( this );
                    var aData = nTable.fnGetData( aPos );
                    $("#a1").attr("onclick","window.open('tp.main.info.php?tp_id=" + aData[0] + "');");
                    $("#a3").attr("onclick","window.open('tp.main.edit.php?tp_id=" + aData[0] + "');");
                };
            })
        });
    </script>
</body>
</html>
<?php
}
?>