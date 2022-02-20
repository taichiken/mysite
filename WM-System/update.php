<?php
//DB接続
require_once('db_info.php');

//セッション開始
session_start();

//パラメータ受け取り
$date = $_SESSION['form']['set_date'];
$time = $_SESSION['form']['set_time'];
$pattern = $_SESSION['form']['action'];

//T_logへのinsert処理
$mysqli->query("insert into T_log(date, time, pattern) values('$date', '$time', '$pattern')");

//打刻内容をセット
if($pattern=='1'){
  $_SESSION['msg_type'] = "success";
  $_SESSION['message'] = "出勤しました";
}else{
  $_SESSION['msg_type'] = "danger";
  $_SESSION['message'] = "退勤しました";
}

//リダイレクト処理
header('Location: index.php');
exit();
?>
