<?php
$host="10.10.10.101";
$db_user="root";
$db_pass="123@abc";
$db_name="mrbs";
$timezone="Asia/Shanghai";

$link=mysqli_connect($host,$db_user,$db_pass);
mysqli_select_db($link,$db_name);
mysqli_query($link,"SET names UTF8");

//header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set($timezone); //北京时间
?>
