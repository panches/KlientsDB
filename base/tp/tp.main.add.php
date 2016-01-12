<?php
// проверка на существование открытой сессии (вставлять во все новые файлы)
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location: ../../index.html");
};
ini_set('default_charset',"UTF-8");
require "../../includes/constants.php";
?>
<!DOCTYPE html>
<html>
  <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <title>Добавить Тех.Площадку</title>
      <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css" />
      <!-- style for validate: -->
      <style>  .error{ color: red; }  </style>
  </head>
  <body>
<?php
      //Open database connection
        $mysqli = mysqli_connect($host,$user,$password,$db)
                        or die("Ошибка " . mysqli_error($mysqli));
      // constant
        $listYesNo =   '<option value="0"></option>
                        <option value="2">есть</option>
                        <option value="1">нет</option>';
?>
<!-- Steps: Twitter Bootstrap Wizard-->
<div id="rootwizard">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <ul>
                    <li><a href="#tab1" data-toggle="tab">1.Адрес узла</a></li>
                    <li><a href="#tab2" data-toggle="tab">2.Все данные</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane" id="tab1">
            <div class="container">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Страна:</label>
                    <div class="col-sm-10">
                        <select name="country" id="country" class="form-control" onchange="javascript:selectRegion();">
                            <?php
                            $sql = 'SELECT * FROM tab_country ORDER BY id';
                            $res = mysqli_query($mysqli, $sql);
                            echo '<option value="0"></option>';
                            while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                echo '<option value="'.$row['id'].'">'.$row['country'].'</option>';
                            };
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Область:</label>
                    <div class="col-sm-10">
                        <div  name="selectDataRegion">
                            <select name="area" id="area" class="form-control" onchange="javascript:selectCity();" ></select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Город:</label>
                    <div class="col-sm-10">
                        <div  name="selectDataCity">
                            <select name="town" id="town" class="form-control" onchange="javascript:selectTown();"></select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Категория аренды:</label>
                    <div class="col-sm-10">
                        <select name="lease" id="lease" class="form-control" onchange="javascript:selectLease();">
                            <?php
                            $sql = 'SELECT id,lease_category FROM tab_lease_category ORDER BY id';
                            $res = mysqli_query($mysqli, $sql);
                            echo '<option value="0"></option>';
                            while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                echo '<option value="'.$row['id'].'">'.$row['lease_category'].'</option>';
                            };
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Статус:</label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control" onchange="javascript:selectStatus();">
                            <?php
                            $sql = 'SELECT id,name FROM tab_status ORDER BY id';
                            $res = mysqli_query($mysqli, $sql);
                            echo '<option value="0"></option>';
                            while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                            };
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab2">
            <div class="container">
            <form id="formadd" method="post" action="tp.main.add.sql.php">
                <legend>Адрес узла</legend>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Название:</label>
                        <div class="col-sm-9">
                            <input type="text" name="name1" id="a1" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Страна:</label>
                        <div class="col-sm-9">
                            <input type="text" name="country1" id="b1" class="form-control" value="" />
                            <input type="hidden" name="country2" id="b2" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                            <label class="col-sm-3 control-label">Область:</label>
                            <div class="col-sm-9">
                                <input type="text" name="area1" id="c1" class="form-control" value="" />
                                <input type="hidden" name="area2" id="c2" class="form-control" value="" />
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-sm-3 control-label">Город:</label>
                            <div class="col-sm-9">
                                <input type="text" name="town1" id="d1" class="form-control" value="" />
                                <input type="hidden" name="town2" id="d2" class="form-control" value="" />
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Адрес:</label>
                        <div class="col-sm-9">
                            <input type="text" name="address1" id="e1" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Категория аренды:</label>
                        <div class="col-sm-9">
                            <input type="text" name="lease1" id="f1" class="form-control" value="" />
                            <input type="hidden" name="lease2" id="f2" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Статус:</label>
                        <div class="col-sm-9">
                            <input type="text" name="status1" id="g1" class="form-control" value="" />
                            <input type="hidden" name="status2" id="g2" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">№ задачи Planner:</label>
                        <div class="col-sm-9">
                            <input type="text" name="planner1" id="h1" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Класс:</label>
                        <div class="col-sm-9">
                            <select name="class1" id="i1" class="form-control">
                                <option>0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                <legend>Доступ к узлу</legend>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Режим доступа:</label>
                        <div class="col-sm-9">
                          <select name="access1" id="j1" class="form-control" onchange="javascript:selectAccess();">
                              <?php
                              $sql = 'SELECT id,access_mode FROM tab_access_mode ORDER BY id';
                              $res = mysqli_query($mysqli, $sql);
                              echo '<option value="0"></option>';
                              while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                  echo '<option value="'.$row['id'].'">'.$row['access_mode'].'</option>';
                              };
                              ?>
                          </select>
                        </div>
                        <input type="hidden" name="access2" id="j2" class="form-control" value="0" />
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Примечание:</label>
                        <div class="col-sm-9">
                            <textarea name="note1" id="k1" class="form-control"></textarea>
                        </div>
                    </div>
                <legend>Электропитание</legend>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Заземление:</label>
                        <div class="col-sm-9">
                            <select name="grounding1" id="l1" class="form-control" onchange="javascript:selectPower('l1');">
                              <?php echo $listYesNo ?>
                            </select>
                        </div>
                        <input type="hidden" name="grounding2" id="l2" class="form-control" value="0" />
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Возможность подключить генератор:</label>
                        <div class="col-sm-8">
                            <select name="generator1" id="m1" class="form-control" onchange="javascript:selectPower('m1');" >
                                <?php echo $listYesNo ?>
                            </select>
                        </div>
                        <input type="hidden" name="generator2" id="m2" class="form-control" value="0" />
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Возможность подключить батмассив:</label>
                        <div class="col-sm-8">
                            <select name="battery1" id="n1" class="form-control" onchange="javascript:selectPower('n1');">
                                <?php echo $listYesNo ?>
                            </select>
                        </div>
                        <input type="hidden" name="battery2" id="n2" class="form-control" value="0" />
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Тип электропитания:</label>
                        <div class="col-sm-9">
                            <select name="acdc1" id="o1" class="form-control">
                                <option></option>
                                <option>AC</option>
                                <option>DC</option>
                                <option>AC/DC</option>
                                <option>нет данных</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Примечание:</label>
                        <div class="col-sm-9">
                            <textarea name="note2" id="p1" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Потребляемая мощность (Вт.):</label>
                        <div class="col-sm-9">
                            <input type="text" name="power1" id="q1" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Время автономности (ч.):</label>
                        <div class="col-sm-9">
                            <input type="text" name="autonomy1" id="r1" class="form-control" value="" />
                        </div>
                    </div>
                <legend>Кондиционирование</legend>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Система:</label>
                        <div class="col-sm-9">
                            <select name="system1" id="s1" class="form-control" onchange="javascript:selectSystem();">
                                  <?php
                                  $sql = 'SELECT id,condition_category FROM tab_condition_category ORDER BY id';
                                  $res = mysqli_query($mysqli, $sql);
                                  echo '<option value="0"></option>';
                                  while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                      echo '<option value="'.$row['id'].'">'.$row['condition_category'].'</option>';
                                  };
                                  ?>
                            </select>
                        </div>
                        <input type="hidden" name="system2" id="s2" class="form-control" value="0" />
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Владелец:</label>
                        <div class="col-sm-9">
                            <select name="proprietor1" id="t1" class="form-control" onchange="javascript:selectProprietor();">
                                  <?php
                                  $sql = 'SELECT id,lease_category FROM tab_lease_category ORDER BY id';
                                  $res = mysqli_query($mysqli, $sql);
                                  echo '<option value="0"></option>';
                                  while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                      echo '<option value="'.$row['id'].'">'.$row['lease_category'].'</option>';
                                  };
                                  ?>
                            </select>
                        </div>
                        <input type="hidden" name="proprietor2" id="t2" class="form-control" value="0" />
                    </div>
                <legend>Система контроля и сигнализации</legend>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">внешнее питание:</label>
                        <div class="col-sm-9">
                            <select name="outpower" id="outpower" class="form-control" onchange="javascript:selectControl('outpower');">
                                  <?php echo $listYesNo ?>
                            </select>
                        </div>
                        <input type="hidden" name="outpower2" id="outpower2" class="form-control" value="0" />
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">двери:</label>
                        <div class="col-sm-9">
                            <select name="doors" id="doors" class="form-control" onchange="javascript:selectControl('doors');">
                                <?php echo $listYesNo ?>
                            </select>
                        </div>
                        <input type="hidden" name="doors2" id="doors2" class="form-control" value="0" />
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">температура:</label>
                        <div class="col-sm-9">
                            <select name="temr" id="temr" class="form-control" onchange="javascript:selectControl('temr');">
                                <?php echo $listYesNo ?>
                            </select>
                        </div>
                        <input type="hidden" name="temr2" id="temr2" class="form-control" value="0" />
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">влажность:</label>
                        <div class="col-sm-9">
                            <select name="humidity" id="humidity" class="form-control" onchange="javascript:selectControl('humidity');">
                                <?php echo $listYesNo ?>
                            </select>
                        </div>
                        <input type="hidden" name="humidity2" id="humidity2" class="form-control" value="0" />
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">дым:</label>
                        <div class="col-sm-9">
                            <select name="smoke" id="smoke" class="form-control" onchange="javascript:selectControl('smoke');">
                                <?php echo $listYesNo ?>
                            </select>
                        </div>
                        <input type="hidden" name="smoke2" id="smoke2" class="form-control" value="0" />
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">вода:</label>
                        <div class="col-sm-9">
                            <select name="water" id="water" class="form-control" onchange="javascript:selectControl('water');">
                                <?php echo $listYesNo ?>
                            </select>
                        </div>
                        <input type="hidden" name="water2" id="water2" class="form-control" value="0" />
                    </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Примечание:</label>
                    <div class="col-sm-9">
                        <textarea name="note3" id="u1" class="form-control"></textarea>
                    </div>
                </div>

                <legend>Владельцы узла и стойки</legend>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Примечание:</label>
                        <div class="col-sm-9">
                            <textarea name="note4" id="v1" class="form-control"></textarea>
                        </div>
                    </div>
                <div class="form-group">
                    <div class="col-sm-13 col-sm-offset-11">
                        <button name="btnOk" id="btnOk" class="btn"><img src="../../img/ok.png"> Ok</button>
                    </div>
                </div>
            </form>
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
<!-- Close connection database -->
  <?php mysqli_close($mysqli); ?>
  <script src="../../js/jquery-1.11.0.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/jquery.bootstrap.wizard.min.js"></script>
  <script src="../../js/jquery.validate.min.js"></script>
  <!-- MyScript -->
  <script src="tp.main.add.js"></script>
</body>
</html>
