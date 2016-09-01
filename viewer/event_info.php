<?php
session_start();

include "../configuration/connect.class.php";
$db = new database();
$db->connect();

$evt_id = '';
if(isset($_GET['evt_id'])){
  $evt_id = $_GET['evt_id'];
}else{
  header('Location: index.php');
  exit();
}



$strSQL = "SELECT * FROM items_tmp_2013 WHERE items_tmp_id = '".$evt_id."'";
$result = $db->select($strSQL,false,true);

if(!$result){
  header('Location: index.php');
  exit();
}

$event = $result[0]['eventdatetime'];

if($result[0]['items_part']=='als'){
  $strSQL = "SELECT * FROM items_als_2013 WHERE ID = '".$result[0]['items_id']."' ";
}else if($result[0]['items_part']=='bls'){
  $strSQL = "SELECT * FROM items_bls_2013 WHERE ID = '".$result[0]['items_id']."' ";
}else if($result[0]['items_part']=='fr'){
  $strSQL = "SELECT * FROM items_fr_2013 WHERE ID = '".$result[0]['items_id']."' ";
}

$resultInfo = $db->select($strSQL,false,true);
if(!$resultInfo){
  header('Location: index.php');
  exit();
}

$sumOfTime = 0;
$d0 = 0;
$d1 = 0;

$to_time = strtotime($resultInfo[0]['A2_1_4']);
$from_time = strtotime($event);
$d0 = round(abs($to_time - $from_time) / 60,2);
$sumOfTime += floatval(round(abs($to_time - $from_time) / 60,2));


$to_time = strtotime($resultInfo[0]['A2_1_6']);
$from_time = strtotime($event);
$d1 = round(abs($to_time - $from_time) / 60,2);
$sumOfTime += floatval(round(abs($to_time - $from_time) / 60,2));


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
          <button class="btn btn-app-red" type="button" id="btn-back1"><i class="ion-android-arrow-dropleft"></i> กลับสู่หน้าหลัก</button>
        </div>
      </div>
      <div class="row" style="padding-top: 10px;">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header bg-red bg-inverse">
                <h4 style="font-weight: 400;">ข้อมูลปฏิบัติการ</h4>
                <ul class="card-actions">
                    <li>
                        <button type="button" data-toggle="card-action" data-action="content_toggle"></button>
                    </li>
                </ul>
            </div>
            <div class="card-block">
              <div class="row">
                <div class="col-sm-1">
                  &nbsp;
                </div> <!-- End col-sm-2 -->
                <div class="col-sm-11">
                  <div class="row" style="padding-bottom: 20px;">
                    <div class="col-sm-2">
                      ศูนย์รับแจ้ง
                    </div>
                    <div class="col-sm-2">
                      ถึงจุดเกิดเหตุ
                    </div>
                    <div class="col-sm-8 text-right">
                      ถึงโรงพยาบาลขอนแก่น
                    </div>
                  </div>
                  <div class="row" style="background: url('../images/line-bg.png'); margin-left: 10px; margin-right: 10px;">
                    <div class="col-sm-2" style="padding: 0px;">
                      <i class="fa fa-circle fa-2x" style="color: #27D392; margin-top: -3px; padding: 0px;"></i>
                    </div>
                    <div class="col-sm-2" style="padding: 0px;">
                      <i class="fa fa-circle fa-2x" style="color: #27D392; margin-top: -3px; padding: 0px;"></i>
                    </div>
                    <div class="col-sm-8 text-right" style="padding: 0px;">
                      <i class="fa fa-circle fa-2x" style="color: #27D392; margin-top: -3px; padding: 0px;"></i>
                    </div>
                  </div>
                  <div class="row" style="padding-bottom: 20px;">
                    <div class="col-sm-2" style="padding-left: 32px;">
                      0
                    </div>
                    <div class="col-sm-2" style="padding-left: 19px;">
                      <?php print $d0; ?> นาที
                    </div>
                    <div class="col-sm-8 text-right">
                      <?php print $d1; ?> นาที
                    </div>
                  </div>
                </div> <!-- End col-sm-10-->
              </div> <!-- End row -->
              <div class="row">
                <div class="col-sm-1">
                  <strong style="color: red; font-weight: 400; font-size: 1.5em;">Event</strong>
                </div>
                <div class="col-sm-11">
                  <div class="col-sm-2" >
                    <button type="button" name="button" class="btn btn-app-light" style="color: #000;">GIS</button> <i class="ion-android-arrow-forward"></i>
                  </div>
                  <div class="col-sm-2" style="padding-left: 19px;">
                    <button type="button" name="button" class="btn btn-app-light" style="color: #000;">Event</button> <i class="ion-android-arrow-forward"></i>
                  </div>
                  <div class="col-sm-8 text-right">
                    &nbsp;
                  </div>
                </div>
              </div> <!-- End row -->

              <div class="row" style="padding-top: 10px;">
                <div class="col-sm-1">
                  <strong style="color: red; font-weight: 400; font-size: 1.5em;">Person</strong>
                </div>
                <div class="col-sm-11">
                  <div class="col-sm-2" >
                    <button type="button" name="button" class="btn btn-app-light" style="color: #000;">Personal</button> <i class="ion-android-arrow-forward"></i>
                  </div>
                  <div class="col-sm-2" style="padding-left: 19px;">
                    <button type="button" name="button" class="btn btn-app-light" style="color: #000;">Risk factor</button> <i class="ion-android-arrow-forward"></i>
                  </div>
                  <div class="col-sm-8 text-right">
                    <button type="button" name="button" class="btn btn-app-light" style="color: #000;">HIS: Past.Hx</button>
                  </div>
                </div>
              </div> <!-- End row -->

              <div class="row" style="padding-top: 10px;">
                <div class="col-sm-1">
                  <strong style="color: red; font-weight: 400; font-size: 1.5em;">Care</strong>
                </div>
                <div class="col-sm-11">
                  <div class="col-sm-2" >
                    <button type="button" name="button" class="btn btn-app-light" style="color: #000;">Dispatch</button> <i class="ion-android-arrow-forward"></i>
                  </div>
                  <div class="col-sm-2" style="padding-left: 19px;">
                    <button type="button" name="button" class="btn btn-app-light" style="color: #000;">FR/BLS/ALS</button> <i class="ion-android-arrow-forward"></i>
                  </div>
                  <div class="col-sm-8 text-right">
                    <button type="button" name="button" class="btn btn-app-light" style="color: #000;">IS / TR</button>
                  </div>
                </div>
              </div> <!-- End row -->


            </div> <!-- End card block -->
          </div>
          <!-- End card -->
        </div>
        <!-- End col-sm-12 -->
      </div>
      <!-- End row -->
    </div>
    <!-- End container fluid -->

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">

        </div>
        <!-- End col-sm-12 -->

      </div>
      <!-- End row -->
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
    <!-- <script src="../assets/js/plugins/select2/select2.full.min.js"></script> -->
    <!-- <script src="../assets/js/plugins/dropzonejs/dropzone.min.js"></script> -->
    <!-- <script src="../assets/js/plugins/masked-inputs/jquery.maskedinput.min.js"></script> -->

    <!-- Include JS custom code -->
    <script src="../dist/page/main.js"></script>
    <script src="../dist/page/signin/index.js"></script>
    <script src="../dist/page/signin/forms_validation.js"></script>
    <!-- Page JS Code -->
    <script>
        $(function(){
            $('#btn-back1').click(function(){
              window.location = "./";
            });
        });
    </script>
    <!-- <script>
        $(function(){
            App.initHelpers(['datepicker', 'select2', 'masked-inputs']);
        });
    </script> -->

  </body>
</html>
