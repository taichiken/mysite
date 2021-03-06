<?php
//--------------------------------------------------
//コロンセット
//--------------------------------------------------
function insertColon($prm){
  if($prm!=''){
    //6桁補正
    $prm = substr('000000'.$prm,-6);
    $prm = substr($prm,0,2).':'.substr($prm,2,2);
  }
  return $prm;
}

//--------------------------------------------------
//コロン外す
//--------------------------------------------------
function removeColon($prm){
  if($prm!=''){
    $prm = str_replace(':','',$prm);
    //6桁補正
    $prm = substr($prm.'00',0,6);
  }
return $prm;
}


//--------------------------------------------------
//スラッシュセット
//--------------------------------------------------
function insertSlash($prm){
  if(mb_strlen($prm)==4){
    $insertSlash = substr($prm,4,2).'/'.substr($prm,-2);
  }else{
    $insertSlash = substr($prm,0,4).'/'.substr($prm,4,2).'/'.substr($prm,-2);
  }
  return $insertSlash;
}


//--------------------------------------------------
//スラッシュ外す
//--------------------------------------------------
function removeSlash($prm){
  if($prm!=''){
    $prm = str_replace('/','',$prm);
  }
return $prm;
}


//--------------------------------------------------
//労働時間取得
//--------------------------------------------------
function getWorkTime($prm1,$prm2,$prm3,$prm4){
  $work_total=0;
  $rest_total=0;
  if($prm1!=''&&$prm2!=''){
    $prm1 = substr('000000'.$prm1,-6);
    $prm2 = substr('000000'.$prm2,-6);
    $work_total = ((substr($prm2,0,2)*60)+substr($prm2,2,2)) - ((substr($prm1,0,2)*60)+substr($prm1,2,2));
  }
  if($prm3!=''&&$prm4!=''){
    $prm3 = substr('000000'.$prm3,-6);
    $prm4 = substr('000000'.$prm4,-6);
    $rest_total = ((substr($prm4,0,2)*60)+substr($prm4,2,2)) - ((substr($prm3,0,2)*60)+substr($prm3,2,2));
  }
  $total = $work_total-$rest_total;
  if($total>0){
    $getWorkTime = insertColon(substr('00'.floor($total/60),-2).substr('00'.floor($total%60),-2).'00');
  }

  return $getWorkTime;
}


//--------------------------------------------------
//色取得
//--------------------------------------------------
function getColor($prm){
  $getColor='';
  if($prm=='7'){
    $getColor = 'text-primary';
  }elseif($prm=='1'){
    $getColor = 'text-danger';
  }
  return $getColor;
}


//--------------------------------------------------
//曜日取得
//--------------------------------------------------
function getWeek($prm){
  $getWeek='';
  if($prm=='1'){
    $getWeek = '（日）';
  }elseif($prm=='2'){
    $getWeek = '（月）';
  }elseif($prm=='3'){
    $getWeek = '（火）';
  }elseif($prm=='4'){
    $getWeek = '（水）';
  }elseif($prm=='5'){
    $getWeek = '（木）';
  }elseif($prm=='6'){
    $getWeek = '（金）';
  }elseif($prm=='7'){
    $getWeek = '（土）';
  }
  return $getWeek;
}


//--------------------------------------------------
//プルダウン初期表示値の選択
//  prm1:プルダウン値（固定値）
//  prm2:プルダウン値（変動値）
//--------------------------------------------------
function selectPulldown($prm1,$prm2){
  $selectPulldown='';
  if($prm1==$prm2){
    $selectPulldown = 'selected';
  }
  return $selectPulldown;
}
?>
