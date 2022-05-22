<?php
//セッション開始
session_start();

//DB接続
require_once('db_info.php');

//パラメータ受け取り
$date = $_SESSION['form']['set_date'];
$time = $_SESSION['form']['set_time'];
$pattern = $_SESSION['form']['action'];

//T_logへのinsert処理
$mysqli->query("insert into T_log(date, time, pattern) values('$date', '$time', '$pattern')");

//打刻内容をセット
if($pattern=='1'){
  $_SESSION['msg_type'] = 'success';
  $_SESSION['message'] = '出勤しました';
}elseif($pattern=='2'){
  $_SESSION['msg_type'] = 'danger';
  $_SESSION['message'] = '退勤しました';
}elseif($pattern=='3'){
  $_SESSION['msg_type'] = 'dark';
  $_SESSION['message'] = '休憩開始しました';
}elseif($pattern=='4'){
  $_SESSION['msg_type'] = 'dark';
  $_SESSION['message'] = '休憩終了しました';
}
//リダイレクト処理
header('Location: index.php');
exit();
?>
