<?php
session_start();

include "../configuration/connect.class.php";
$db = new database();
$db->connect();

$cYear = '2013';
$cMonth = '01';

if(isset($_GET['month'])){ $cMonth = $_GET['month']; }
if(isset($_GET['year'])){ $cYear = $_GET['year']; }


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="description" content="Score Board" />

    <title>Welcome to Scoreboard</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="../assets/img/favicons/apple-touch-icon.png" />
    <link rel="icon" href="../assets/img/favicons/favicon.ico" />

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Kanit:200,300,400,500" rel="stylesheet">

    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="../assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="../assets/js/plugins/select2/select2.min.css" />
    <link rel="stylesheet" href="../assets/js/plugins/dropzonejs/dropzone.min.css" />
    <link rel="stylesheet" href="../assets/js/plugins/select2/select2-bootstrap.css" />
    <link rel="stylesheet" href="../assets/js/plugins/datatables/jquery.dataTables.min.css" />

    <!-- AppUI CSS stylesheets -->
    <link rel="stylesheet" id="css-font-awesome" href="../assets/css/font-awesome.css" />
    <link rel="stylesheet" id="css-ionicons" href="../assets/css/ionicons.css" />
    <link rel="stylesheet" id="css-bootstrap" href="../assets/css/bootstrap.css" />
    <link rel="stylesheet" id="css-app" href="../assets/css/app.css" />
    <link rel="stylesheet" id="css-app-custom" href="../assets/css/app-custom.css" />

  </head>
  <body>
    <div class="navigation-bar">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-5" style="padding-top: 10px;">
            <h1><span class="site-title">ScoreBoard</span></h1>
          </div>
          <div class="col-sm-7 text-right" style="padding-top: 25px;">
            <button class="btn btn-app-red" type="button" id="btn-signout">ออกจากระบบ</button>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid" style="padding-top: 20px;">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header bg-red bg-inverse">
                <h4><i class="fa fa-search"></i> ค้นหาข้อมูลตามเงื่อนไขที่กำหนด</h4>
                <ul class="card-actions">
                    <li>
                        <button type="button" data-toggle="card-action" data-action="content_toggle"></button>
                    </li>
                </ul>
            </div>
            <div class="card-block">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                      <label class="col-xs-12" for="login1-username">ข้อมูลประจำเดือน</label>
                      <div class="col-xs-12">
                        <select class="form-control" name="txt-month" id="txt-month">
                          <option value="01" selected="">มกราคม</option>
                          <option value="02">กุมภาพันธ์</option>
                          <option value="03">มีนาคม</option>
                          <option value="04">เมษายน</option>
                          <option value="05">พฤษภาคม</option>
                          <option value="06">มิถุนายน</option>
                          <option value="07">กรกฏาคม</option>
                          <option value="08">สิงหาคม</option>
                          <option value="09">กันยายน</option>
                          <option value="10">ตุลาคม</option>
                          <option value="11">พฤศจิกายน</option>
                          <option value="12">ธันวาคม</option>
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                      <label class="col-xs-12" for="login1-username">ปี พ.ศ.</label>
                      <div class="col-xs-12">
                        <select class="form-control" name="txt-year" id="txt-year">
                          <!-- <option value="" selected="">-- เลือกปี พ.ศ. -- </option> -->
                          <option value="2556" selected="">2556</option>
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                      <label class="col-xs-12" for="login1-username">โรงพยาบาลปลายทาง</label>
                      <div class="col-xs-12">
                        <select class="form-control" name="">
                          <option value="" selected="">-- เลือกโรงพยาบาล -- </option>
                          <option value="10670" <?php if($_SESSION['ISCBsessHcode']=='10670'){ print "selected"; } ?>>โรงพยาบาลขอนแก่น</option>
                        </select>
                      </div>
                  </div>
                </div>

                <!-- <div class="col-sm-3">
                  <div class="form-group">
                      <label class="col-xs-12" for="login1-username">ประเภทการส่งต่อ</label>
                      <div class="col-xs-12">
                        <select class="form-control" name="">
                          <option value="" selected="">ทุกประเภท</option>
                          <option value="1">เฉพาะรายการส่งต่อทันที่</option>
                          <option value="2">เฉพาะรายการที่มีการ admit ที่ ร.พ.</option>
                        </select>
                      </div>
                  </div>
                </div> -->

                <div class="col-sm-2">
                  <div class="form-group" style="padding-top: 25px;">
                    <button class="btn btn-app-red btn-block" type="button" id="btnGen">แสดงข้อมูล</button>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <!-- End card -->
        </div>
        <!-- End col-sm-12 -->
      </div>
      <!-- End row -->
    </div>
    <!-- End container fluid -->

    <?php
    $strSQL = "SELECT * FROM items_tmp_2013 a
              WHERE a.eventdatetime like '".(intval($cYear)-543)."-".$cMonth."-%'
              ORDER BY a.eventdatetime ";
    $result = $db->select($strSQL,false,true);

    // print $strSQL;
    ?>

    <div class="container-fluid">

      <div class="row">
        <div class="col-sm-12">
          <div class="table-responsive">
            <!-- <table class="table  table-striped table-condensed table-bordered table-hover">-->
            <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
                  <tr>
                      <th class="text-center" style="width: 50px;">#</th>
                      <th >เลขที่เหตุการณ์</th>
                      <th style="width: 400px;">เวลาเกิดเหตุ</th>
                      <th style="width: 400px;">รับแจ้ง</th>
                      <th>D1</th>
                      <th style="width: 500px;">ออกปฏิบัติการณ์</th>
                      <th>D2</th>
                      <th style="width: 500px;">ถึงจุดเกิดเหตุ</th>
                      <th>D3</th>
                      <th style="width: 500px;">ถึง รพ.1</th>
                      <th>D4</th>
                      <!-- <th style="width: 500px;">ออกจาก รพ.1</th>
                      <th>D5</th>
                      <th style="width: 500px;">ถึง รพ.2</th>
                      <th>D6</th> -->
                      <!-- <th style="width: 500px;">ออกจาก รพ.2</th>
                      <th>D7</th>
                      <th style="width: 500px;">ถึง รพ.3</th>
                      <th>D8</th> -->
                      <th>รวม</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                if($result){
                  $c = 1;
                  foreach ($result as  $value) {
                    $event = $value['eventdatetime'];
                    if($value['items_part']=='als'){
                      $strSQL = "SELECT * FROM items_als_2013 WHERE ID = '".$value['items_id']."' AND NAME_TH = 'โรงพยาบาลขอนแก่น'";
                    }else if($value['items_part']=='bls'){
                      $strSQL = "SELECT * FROM items_bls_2013 WHERE ID = '".$value['items_id']."' AND NAME_TH = 'โรงพยาบาลขอนแก่น'";
                    }else if($value['items_part']=='fr'){
                      $strSQL = "SELECT * FROM items_fr_2013 WHERE ID = '".$value['items_id']."' AND NAME_TH = 'โรงพยาบาลขอนแก่น'";
                    }

                    $resultEach = $db->select($strSQL,false,true);

                    $operationID = $value['items_tmp_id'];
                    if($resultEach){


                      foreach ($resultEach as $value) {
                        $sumOfTime = 0;
                        ?>
                        <tr>
                            <td class="text-center"><?php print $c; $c++; ?></td>
                            <td><a href="event_info.php?evt_id=<?php print $operationID; ?>"><?php print $value['OPE_ID']; ?></a></td>
                            <td class="hidden-xs">
                              <?php
                              $e0 = $event;
                              print $event;
                              ?>
                            </td>
                            <td class="hidden-xs">
                              <?php
                              print $value['A2_1_1'];
                              ?>
                            </td>
                            <td class="hidden-xs">
                              <?php
                              $to_time = strtotime($value['A2_1_1']);
                              $from_time = strtotime($e0);
                              echo round(abs($to_time - $from_time) / 60,2);
                              $sumOfTime += floatval(round(abs($to_time - $from_time) / 60,2));
                              ?>
                            </td>
                            <td class="hidden-xs">
                              <?php
                              // if($resultEach){
                                print $value['A2_1_3'];
                              // }
                              ?>
                            </td>
                            <td class="hidden-xs">
                              <?php
                              $to_time = strtotime($value['A2_1_3']);
                              $from_time = strtotime($value['A2_1_1']);
                              echo round(abs($to_time - $from_time) / 60,2);
                              $sumOfTime += floatval(round(abs($to_time - $from_time) / 60,2));
                              ?>
                            </td>
                            <td class="hidden-xs">
                              <?php
                              if($resultEach){
                                print $value['A2_1_4'];
                              }
                              ?>
                            </td>
                            <td class="hidden-xs">
                              <?php
                              $to_time = strtotime($value['A2_1_4']);
                              $from_time = strtotime($value['A2_1_3']);
                              echo round(abs($to_time - $from_time) / 60,2);
                              $sumOfTime += floatval(round(abs($to_time - $from_time) / 60,2));
                              ?>
                            </td>
                            <td class="hidden-xs">
                              <?php
                            if($resultEach){
                              print $value['A2_1_6'];
                            }
                            ?></td>
                            <td class="hidden-xs">
                              <?php
                              $to_time = strtotime($value['A2_1_6']);
                              $from_time = strtotime($value['A2_1_4']);
                              echo round(abs($to_time - $from_time) / 60,2);
                              $sumOfTime += floatval(round(abs($to_time - $from_time) / 60,2));
                              ?>
                            </td>
                            <!-- <td class="hidden-xs">-</td>
                            <td class="hidden-xs">NA</td>
                            <td class="hidden-xs">-</td>
                            <td class="hidden-xs">NA</td> -->
                            <!-- <td class="hidden-xs">-</td>
                            <td class="hidden-xs">-</td>
                            <td class="hidden-xs">-</td>
                            <td class="hidden-xs">-</td> -->
                            <td class="hidden-xs" style="color: red; font-weight: 400;"><?php print $sumOfTime; ?></td>
                        </tr>
                        <?php
                      }
                    }

                    //
                    // switch($value['items_part']){
                    //     case 'als': $strSQL = "SELECT * FROM items_als_2013 WHERE ID = '".$value['items_id']."'"; break;
                    //     case 'bls': $strSQL = "SELECT * FROM items_bls_2013 WHERE ID = '".$value['items_id']."'"; break;
                    //     case 'fr': $strSQL = "SELECT * FROM items_fr_2013 WHERE ID = '".$value['items_id']."'"; break;
                    // }
                    //
                    // $resultEach = $db->select($strSQL,false,true);
                    // $sumOfTime = 0;
                  }
                }
                ?>
              </tbody>
            </table>
            <!-- End table   -->
          </div>

        </div>
        <!-- End col-sm-12 -->

      </div>
      <!-- End row -->


      <div class="row">
        <div class="col-sm-12">
          จำนวนปฏิบัติการ : <?php print sizeof($result); ?>
        </div>
      </div>

    </div>
    <!-- End container fluid -->

    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/core/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/core/jquery.scrollLock.min.js"></script>
    <script src="../assets/js/core/jquery.placeholder.min.js"></script>
    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/app-custom.js"></script>

    <!-- Page JS Plugins -->
    <script src="../assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="../assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <!-- <script src="../assets/js/plugins/select2/select2.full.min.js"></script> -->
    <!-- <script src="../assets/js/plugins/dropzonejs/dropzone.min.js"></script> -->
    <!-- <script src="../assets/js/plugins/masked-inputs/jquery.maskedinput.min.js"></script> -->

    <!-- Include JS custom code -->
    <script src="../dist/page/main.js"></script>
    <script src="../dist/page/board/index.js"></script>
    <script src="../assets/js/pages/base_tables_datatables.js"></script>
    <!-- <script src="../dist/page/signin/forms_validation.js"></script> -->
    <!-- Page JS Code -->
    <!-- <script>
        $(function(){
            App.initHelpers(['datepicker', 'select2', 'masked-inputs']);
        });
    </script> -->
    <!-- <script>
        $(function(){
            App.initHelpers(['datepicker', 'select2', 'masked-inputs']);
        });
    </script> -->

  </body>
</html>
