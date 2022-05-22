<?php
//セッション開始
session_start();

//DB接続
require_once('db_info.php');

//ファンクション
require_once('function.php');

//パラメータ受け取り
$update_ptn = $_SESSION['form']['set_update_ptn']; /*--stamp:打刻編集、leave:休暇編集--*/
$date = $_SESSION['form']['set_date'];
$current_date = date('Ymd');

//画面表示メッセージ用パラメータ
$dsp_msgtype='success';
$dsp_message='登録しました！！';

//--------------------------------------------------
//「打刻編集画面」からの遷移
//--------------------------------------------------
if($update_ptn=='stamp'){

  //パラメータ受け取り
  $count = $_SESSION['form']['set_count'];

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
  $_SESSION['msg_type'] = $dsp_msgtype;
  $_SESSION['message'] = $dsp_message;

  //リダイレクト処理
  header('Location: record_edit.php?set_date='.$date);
  exit();


//--------------------------------------------------
//「休暇登録画面」からの遷移
//--------------------------------------------------
}elseif($update_ptn=='leave'){
  //パラメータ受け取り
  $leave_type1 = removeSlash($_SESSION['form']['set_leave_type1']);  /*--休暇種類１--*/
  $leave_ptn1 = removeSlash($_SESSION['form']['set_leave_ptn1']);    /*--休暇パターン１--*/
  $leave_type2 = removeSlash($_SESSION['form']['set_leave_type2']);  /*--休暇種類１--*/
  $leave_ptn2 = removeSlash($_SESSION['form']['set_leave_ptn2']);    /*--休暇パターン2--*/
  $leave_msg = removeSlash($_SESSION['form']['set_leave_msg']);      /*--休暇メッセージ--*/

  //--------------------------------------------------
  //休暇登録処理
  //--------------------------------------------------

  //エラーチェック
  if(($leave_type1!='' && $leave_ptn1=='')||($leave_type1=='' && $leave_ptn1!='')){
    $dsp_msgtype='danger';
    $dsp_message='1行目の入力内容に不備があります';
  }elseif(($leave_type2!='' && $leave_ptn2=='')||($leave_type2=='' && $leave_ptn2!='')){
    $dsp_msgtype='danger';
    $dsp_message='2行目の入力内容に不備があります';
  }elseif($leave_ptn1!='' && $leave_ptn2!=''){
    if(($leave_ptn1==$leave_ptn2)||($leave_ptn1=='1' || $leave_ptn2=='1')){
      $dsp_msgtype='danger';
      $dsp_message='休暇単位に不備があります';
    }
  }

  //エラーがない場合の更新処理
  if($dsp_msgtype=='success'){
    //T_leaveから対象日の休暇をdelete
    $mysqli->query("delete from T_leave where leave_date = $date");

    //T_leaveへのinsert処理
    if($leave_ptn1!=''&&$leave_type1!=''){
      $mysqli->query("
        insert into T_leave(leave_date, leave_ptn, leave_type, leave_msg, appl_date)
        values('$date','$leave_ptn1','$leave_type1','$leave_msg','$current_date')
      ");
    }
    if($leave_ptn2!=''&&$leave_type2!=''){
      $mysqli->query("
        insert into T_leave(leave_date, leave_ptn, leave_type, leave_msg, appl_date)
        values('$date','$leave_ptn2','$leave_type2','$leave_msg','$current_date')
      ");
    }
  }

  //セッション書き込み
  $_SESSION['msg_type'] = $dsp_msgtype;
  $_SESSION['message'] = $dsp_message;

  //リダイレクト処理
  header('Location: input.php?set_date='.$date);
  exit();
}
?>
