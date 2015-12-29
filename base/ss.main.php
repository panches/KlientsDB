<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location: ../index.html");
} else {
// добавить значение параметров в header.php
    $title = 'Сетевые Соединения'; // Титулка страницы
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
            <div class="col-md-12 btn-group" role="group" aria-label="eeeee">
                <a href="ss.main.info.php" target="_blank" class="btn btn-default" id="a1">Info</a>
                <div class="btn-group" role="group">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">New
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="ss.main.add1.php" target="_blank">сетевое</a></li>
                        <li><a href="ss.main.add2.php" target="_blank">межсетевое</a></li>
                        <li><a href="ss.main.add3.php" target="_blank">сервис провайдера</a></li>
                    </ul>
                </div>
                <a href="ss.main.edit.php" target="_blank" class="btn btn-default" id="a3">Edit</a>
            </div>
        </div>
        <br>
<!-- Таблица -->
        <table id="sstab" class="display cell-border compact" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Тип сети</th>
                    <th>Link / Соединение</th>
                    <th>Соединение</th>
                </tr>
            </thead>
        </table>
<!-- footer: jQuery, SmartMenus + js -->
        <?php include("../includes/footer.php"); ?>
    </div>
    <script>
        $(function() {
            var nTable = $('#sstab').dataTable({
                "processing": true,
                "pagingType": "full_numbers",
                "iDisplayLength": 25,
                "ajax": "all.main.ajax.php?base=ss"
            });
            // select pressed row
            $('#sstab tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    $("#a1").attr("href","ss.main.info.php");
                }
                else {
                    nTable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    // отбор позиции строки и значение столбца
                    var aPos = nTable.fnGetPosition( this );
                    var aData = nTable.fnGetData( aPos );
                    $("#a1").attr("href","ss.main.info.php?ss_id=" + aData[0]);
                    $("#a3").attr("href","ss.main.edit.php?ss_id=" + aData[0] + '&ss_link=' + aData[3]);
                };
            });
        });
    </script>
    </body>
    </html>
<?php
}
?>