<?php
//セッション開始
session_start();

//DB接続
require_once('db_info.php');

//ファンクション
require_once('function.php');

//パラメータ受け取り
$count = $_SESSION['form']['set_count'];
$date = $_SESSION['form']['set_date'];

for ($i=0; $i<=$count; $i++){

  //パラメータ受け取り
  $id = $_SESSION['form']['set_id'.$i];
  $pattern = $_SESSION['form']['set_pattern'.$i];
  $time = removeColon($_SESSION['form']['set_time'.$i]);
  $delete = $_SESSION['form']['set_delete'.$i];

    //--------------------------------------------------
    //T_logへのinsert処理
    //--------------------------------------------------
  if($id==''){
    if($pattern!='' && $time!='' && $delete==''){
      $mysqli->query("insert into T_log(date, time, pattern) values('$date', '$time', '$pattern')");
    }

  //--------------------------------------------------
  //T_logへのdelete処理
  //--------------------------------------------------
  }elseif($delete=='on'){
    $mysqli->query("delete from T_log where id = $id");

  //--------------------------------------------------
  //T_logへのupdate処理
  //--------------------------------------------------
  }else{
    $mysqli->query("
      update T_log
      set
        time = $time,
        pattern = $pattern
      where id = $id
      and not (
        left(right(concat('000000',time),6),4) = left(right(concat('000000',$time),6),4) and
        pattern = $pattern
      )
    ");
  }
}

//セッション書き込み
$_SESSION['msg_type'] = "success";
$_SESSION['message'] = "登録しました！！";

//リダイレクト処理
header('Location: record_edit.php?set_date='.$date);
exit();
?>
