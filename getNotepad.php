<?php
/**
 * Created by PhpStorm.
 * User: Gongming
 * Date: 2019/3/15
 * Time: 16:07
 */
include_once "connect.php";

$result=mysqli_query($link,"select id,title,starttime as start,endtime as end,allday,color from calendar");
$arr = mysqli_fetch_all($result,MYSQLI_ASSOC);

header('Content-type: application/json');
echo json_encode($arr);