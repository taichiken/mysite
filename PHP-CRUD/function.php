<?php
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
