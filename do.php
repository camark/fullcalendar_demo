<?php
include_once('connect.php');//连接数据库

$action = $_POST['action'];
if($action=='add'){
	$events = stripslashes(trim($_POST['event']));//事件内容
	$events=mysqli_real_escape_string($link,strip_tags($events)); //过滤HTML标签，并转义特殊字符

	$isallday = isset($_POST['isallday'])?1:0;//是否是全天事件
	$isend = isset($_POST['isend'])?1:0;//是否有结束时间

	$startdate = trim($_POST['startdate']);//开始日期
	$enddate = trim($_POST['enddate']);//结束日期

	$s_time = $_POST['s_hour'].':'.$_POST['s_minute'].':00';//开始时间
	$e_time = $_POST['e_hour'].':'.$_POST['e_minute'].':00';//结束时间

	if($isallday==1 && $isend==1){
		$starttime = strtotime($startdate);
		$endtime = strtotime($enddate);
	}elseif($isallday==1 && $isend==0){
		$starttime = strtotime($startdate);
	}elseif($isallday=="" && $isend==1){
		$starttime = strtotime($startdate.' '.$s_time);
		$endtime = strtotime($enddate.' '.$e_time);
	}else{
		$starttime = strtotime($startdate.' '.$s_time);
	}

	$colors = array("#360","#f30","#06c");
	$key = array_rand($colors);
	$color = $colors[$key];

	//$isallday = $isallday?1:0;
	$query = mysqli_query($link,"insert into `calendar` (`title`,`starttime`,`endtime`,`allday`,`color`) values ('$events','$starttime','$endtime','$isallday','$color')");
	if(mysqli_insert_id($link)>0){
		echo '1';
	}else{
		echo '写入失败！';
	}
}
if ($action=="edit"){
    $id = intval($_POST['id']);
    if($id==0){
        echo '事件不存在！';
        exit;
    }
    $events = stripslashes(trim($_POST['event']));//事件内容
    $events=mysqli_real_escape_string($link,strip_tags($events)); //过滤HTML标签，并转义特殊字符

    $isallday = isset($_POST['isallday'])?1:0;//是否是全天事件
    $isend = isset($_POST['isend'])?1:0;//是否有结束时间

    $startdate = trim($_POST['startdate']);//开始日期
    $enddate = trim($_POST['enddate']);//结束日期

    $s_time = $_POST['s_hour'].':'.$_POST['s_minute'].':00';//开始时间
    $e_time = $_POST['e_hour'].':'.$_POST['e_minute'].':00';//结束时间

    if($isallday==1 && $isend==1){
        $starttime = strtotime($startdate);
        $endtime = strtotime($enddate);
    }elseif($isallday==1 && $isend==""){
        $starttime = strtotime($startdate);
        $endtime = 0;
    }elseif($isallday=="" && $isend==1){
        $starttime = strtotime($startdate.' '.$s_time);
        $endtime = strtotime($enddate.' '.$e_time);
    }else{
        $starttime = strtotime($startdate.' '.$s_time);
        $endtime = 0;
    }

    $isallday = $isallday?1:0;
    mysqli_query($link,"update `calendar` set `title`='$events',`starttime`='$starttime',`endtime`='$endtime',`allday`='$isallday' where `id`='$id'");

    //echo "go";
    if(mysqli_affected_rows($link)==1){
        echo '1';
    }else{
        echo '出错了！';
    }
}
if ($action=="del"){
    $id = intval($_POST['id']);
    header("Content-Type: text/html; charset=utf-8");
    //echo "Delete";
    if($id>0){
        mysqli_query($link,"delete from `calendar` where `id`='$id'");
        if(mysqli_affected_rows($link)==1){
            echo '1';
        }else{
            echo '出错了！';
        }
    }else{
        echo '事件不存在！';
    }
}
?>