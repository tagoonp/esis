<?php
session_start();

include "../configuration/connect.class.php";
$db = new database();
$db->connect();

$salt = 'W54mnFMEVPcHLiDQwbwG44#is0Sr*dkxX';
$hashPWD = hash_hmac('md5', $_POST['password'], $salt);

$strSQL = sprintf("SELECT * FROM iscb_account INNER JOIN iscb_userinfo ON iscb_account.username = iscb_userinfo.username WHERE iscb_account.username = '%s' AND iscb_account.password = '%s' AND iscb_account.active_status = '%s'", mysql_real_escape_string($_POST['username']), mysql_real_escape_string($hashPWD), mysql_real_escape_string('Yes'));
$result = $db->select($strSQL,false,true);

if($result){
  $_SESSION['ISCBsessID'] = session_id();
  $_SESSION['ISCBsessUsername'] = $result[0]['username'];
  $_SESSION['ISCBsessUtype'] = $result[0]['usertype_id'];
  $_SESSION['ISCBsessHcode'] = $result[0]['hospital_id'];
  session_write_close();

  $ip = $_SERVER['REMOTE_ADDR'];;

  $strSQL = sprintf("INSERT INTO iscb_log_access (ip_address, date_time, username, status) VALUE ('%s', '%s', '%s', '%s')", mysql_real_escape_string($ip), mysql_real_escape_string(date('Y-m-d H:i:s')), mysql_real_escape_string($_POST['username']), mysql_real_escape_string('success'));
  $result = $db->insert($strSQL,false,true);

  print "Y";
}else{

  $ip = $_SERVER['REMOTE_ADDR'];;


  // print "N";
  print $strSQL;

  $strSQL = sprintf("INSERT INTO iscb_log_access (ip_address, date_time, username, status) VALUE ('%s', '%s', '%s', '%s')", mysql_real_escape_string($ip), mysql_real_escape_string(date('Y-m-d H:i:s')), mysql_real_escape_string($_POST['username']), mysql_real_escape_string('fail'));
  $result = $db->insert($strSQL,false,true);
}

$db->disconnect();

function get_client_ip_env() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}
?>
