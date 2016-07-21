<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location: ../index.html");
} else {
// добавить значение параметров в header.php
    $title = 'Сервисы Субпровайдеров'; // Титулка страницы
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
            <div class="col-md-10">
                <a href="ssy/ssy.main.info.php" target="_blank" class="btn btn-default" id="a1">Info</a>
                <a href="ssy/ssy.main.add.php" target="_blank" class="btn btn-default" id="a2">New</a>
                <a href="ssy/ssy.main.edit.php" target="_blank" class="btn btn-default" id="a3">Edit</a>
            </div>
            <div class="col-md-2">
                <b>АП: </b><i class="sum"></i> грн.
            </div>
        </div>
        <br>
<!-- Таблица -->
        <table id="ssytab" class="display cell-border compact" cellspacing="0" width="200%"> </table>
<!-- footer: jQuery, SmartMenus + js -->
        <?php include("../includes/footer.php"); ?>
    </div>
    <script>
        $(function() {

            var nTable = $('#ssytab').dataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5'
                ],
                "processing": true,
                "scrollX": true,
                "pagingType": "full_numbers",
                "iDisplayLength": 10,
                "ajax": "all.main.ajax.php?base=ssy",
                "columns": [
                    {"title": "№"},
                    {"title": "Город А"},
                    {"title": "Адрес А"},
                    {"title": "Город Б"},
                    {"title": "Адрес Б"},
                    {"title": "Скорость"},
                    {"title": "Оператор"},
                    {"title": "Стоимость"},
                    {"title": "№ канала"},
                    {"title": "№ договора"},
                    {"title": "№ доп.договора"},
                    {"title": "Тип услуги"},
                    {"title": "Номер задачи"},
                    {"title": "Дата пост.задачи"},
                    {"title": "Название клиента"},
                    {"title": "Название клиента (OLD)"},
                    {"title": "Стимость включения"},
                    {"title": "corp/retail"},
                    {"title": "Дата включения"},
                    {"title": "Начало сервиса"},
                    {"title": "Подразделение"},
                    {"title": "Состояние"},
                    {"title": "Подвязан к ..."},
                    {"title": "Дата отключения"},
                    {"title": "Налоговая накладная"},
                    {"title": "Акт вып.работ"},
                    {"title": "Номер счета"},
                    {"title": "Исполнитель"}
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?  i.replace(/[\$,]/g, '')*1 :  typeof i === 'number' ?  i : 0;
                    };
                    // Total over all pages
                    //total = api.column( 7 ).data()
                    //    .reduce( function (a, b) {
                    //        return intVal(a) + intVal(b);
                    //    }, 0 );
                    // Total over this page
                    //pageTotal = api.column( 7, { page: 'current'} ).data()
                    //    .reduce( function (a, b) {
                    //        return intVal(a) + intVal(b);
                    //    }, 0 );
                    // Total over filtered pages
                    filerTotal = api.column( 7, {"filter": "applied"}  ).data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update AP
                    $( ".sum" ).html( filerTotal.toFixed(2) );
                }
            });
            // select pressed row
            $('#ssytab tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    $("#a1").attr("href","ssy/ssy.main.info.php");
                }
                else {
                    nTable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    // отбор позиции строки и значение столбца
                    var aPos = nTable.fnGetPosition( this );
                    var aData = nTable.fnGetData( aPos );
                    $("#a1").attr("href","ssy/ssy.main.info.php?ssy_id=" + aData[0]);
                    $("#a3").attr("href","ssy/ssy.main.edit.php?ssy_id=" + aData[0]);
                };
            })
        });
    </script>
    </body>
    </html>
<?php
}
?>