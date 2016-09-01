<?php
$input = $_GET['pwd'];

$salt = 'W54mnFMEVPcHLiDQwbwG44#is0Sr*dkxX';
$hash = hash_hmac('md5', $input, $salt);

print $hash;
?>
