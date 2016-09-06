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
    <link rel="stylesheet" href="../../css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="../../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../css/dataTables.bootstrap.min.css" />
    <!-- style for validate: -->
    <style>  .error{ color: red; }  </style>


</head>
<body>
  <div id="rootwizard">
      <div class="navbar">
          <div class="navbar-inner">
              <div class="container">
                  <ul>
                      <li><a href="#tab1" data-toggle="tab">1.Абонент</a></li>
                      <li><a href="#tab2" data-toggle="tab">2.Модель устройства</a></li>
                      <li><a href="#tab3" data-toggle="tab">3.Все поля</a></li>
                  </ul>
              </div>
          </div>
      </div>
      <div class="tab-content">
          <div class="tab-pane" id="tab1">
              <div  class="container">
              <!-- офис -->
                  <label for="office">Название:</label>
                  <table id="office" class="display cell-border compact" cellspacing="0" width="100%"></table>
                  <div id="office_show"><font color="red"></font></div>
              </div>
          </div>
          <div class="tab-pane" id="tab2">
              <div  class="container">
              <!-- устройства -->
                  <label for="equip">Название:</label>
                  <table id="equip" class="display cell-border compact" cellspacing="0" width="100%"></table>
                  <div id="equip_show"><font color="red"></font></div>
              </div>
          </div>
          <div class="tab-pane" id="tab3">
              <div  class="container">
                  <div class="form-group">
                      <form id="formadd" method="post" action="outs.main.add.sql.php">
                          <label class="col-sm-3 control-label">Абонент:</label>
                          <div class="col-sm-9">
                              <input type="text" name="office" id="a1" class="form-control" value="" readonly />
                              <input type="hidden" name="office2" id="a2" class="txt" value="" />
                          </div>
                          <label class="col-sm-3 control-label">Имя узла сети:</label>
                          <div class="col-sm-9">
                            <input type="text" name="name" id="b" class="form-control" value="" />
                          </div>
                          <label class="col-sm-3 control-label">Модель устройства:</label>
                          <div class="col-sm-9">
                            <input type="text" name="equip" id="c1" class="form-control" value="" readonly />
                            <input type="hidden" name="equip2" id="c2" class="txt" value="" />
                          </div>
                          <label class="col-sm-3 control-label">Серийный номер:</label>
                          <div class="col-sm-9">
                            <input type="text" name="num" id="d" class="form-control" value="" />
                          </div>
                          <label class="col-sm-3 control-label">Тип лицензии:</label>
                          <div class="col-sm-9">
                            <input type="text" name="license" id="e" class="form-control" value="" />
                          </div>
                          <label class="col-sm-3 control-label">Примечание:</label>
                          <div class="col-sm-9">
                            <textarea   cols="35" rows="3" name="note" id="f" class="form-control"></textarea>
                          </div>
                          <legend></legend>
                          <div class="col-sm-13 col-sm-offset-11">
                              <button name="btnOk" id="btnOk" class="btn"><img src="../../img/ok.png"> Ok</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
          <ul class="pager wizard">
              <li class="previous first" style="display:none;"><a href="#">First</a></li>
              <li class="previous"><a href="#">Previous</a></li>
              <li class="next last" style="display:none;"><a href="#">Last</a></li>
              <li class="next"><a href="#">Next</a></li>
          </ul>
      </div>
  </div>
  <!-- Скрипты -->
  <script src="../../js/jquery-1.12.4.min.js"></script>
  <script src="../../js/jquery.dataTables.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/jquery.bootstrap.wizard.min.js"></script>
  <script src="../../js/dataTables.bootstrap.min.js"></script>
  <script src="../../js/jquery.bootstrap.wizard.min.js"></script>
  <script src="../../js/jquery.validate.min.js"></script>
  <script> // wizard
    $(function(){
        // формирование закладок (Визарда)
        $('#rootwizard').bootstrapWizard();
    });

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
        $("#office_show").html('<font color="red">' + oData[1] + ", " + oData[2] + ", " + oData[3] + '</font>');
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
        $("#equip_show").html('<font color="red">' + eData[3] + '</font>');
        $("#c1").attr("value",eData[3]);
        $("#c2").attr("value",eData[0]);
      });
        // валидация формы
        $("#formadd").validate({
            rules: {
                office: {
                    required: true
                },
                equip: {
                    required: true
                }
            },
            messages: {
                office: {
                    required: "Вернитесь на закладку №1 и сделайте выбор"
                },
                equip: {
                    required: "Вернитесь на закладку №2 и сделайте выбор"
                }
            }
        });
    })
    </script>
  </body>
</html>