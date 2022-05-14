<?php
//セッション開始
session_start();

//--------------------------------------------------
//打刻時間の登録処理
//--------------------------------------------------
if($_SERVER['REQUEST_METHOD']=='POST'){
  $_SESSION['form'] = $_POST;
  header('Location: record.php');
  exit();
}
?>
<!doctype html>
<html class="no-js" lang="ja">
<head>
<meta charset="utf-8">
<title>勤務時間入力画面</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- BootStrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<!--Font Awesome-->
<link href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" rel="stylesheet">
<link href="./css/main.css" rel="stylesheet">
<meta name="theme-color" content="#fafafa">
</head>
<body>
<form action="" method="POST">
<!--***************************************************************************
ヘッダー
***************************************************************************-->
<div class="py-3 bg-dark">
  <div class="pe-3 text-right">
    <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown">
      <i class="fa fa-bars"></i>
    </button>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item" href="timecard.php">タイムカード</a></li>
    </ul>
  </div>
  <div class="text-center">
    <!--現愛日付-->
    <p><span class="text-secondary h4" id="get_date"></span></p>
    <!--現愛時間-->
    <h1><span class="text-light display-1" id="get_time"></span></h1>
  </div>
</div>

<!--***************************************************************************
出退勤ボタン
***************************************************************************-->
<div class="container">
  <div class="row g-3">
    <div class="col">
      <div class="p-5 text-center">
        <button type="submit" class="btn btn-outline-success work-btn" name="action" value="1">出勤</button>
      </div>
    </div>
    <div class="col">
      <div class="p-5 text-center">
        <button type="submit" class="btn btn-outline-danger work-btn" name="action" value="2">退勤</button>
      </div>
    </div>
  </div>
  <div class="row g-3">
    <div class="col">
      <div class="p-3 text-center">
        <button type="submit" class="btn btn-outline-dark rest-btn" name="action" value="3">休憩<br>開始</button>
      </div>
    </div>
    <div class="col">
      <div class="p-3 text-center">
        <button type="submit" class="btn btn-outline-dark rest-btn" name="action" value="4">休憩<br>終了</button>
      </div>
    </div>
  </div>
</div>

<!--***************************************************************************
メッセージ
***************************************************************************-->
<?php if(isset($_SESSION['message'])): ?>
<div class="alert alert-secondary text-center">
  <span class="text-<?=$_SESSION['msg_type']?> h3"><?php echo $_SESSION['message'] ?></span>
</div>
<?php endif ?>

<!--***************************************************************************
hidden
***************************************************************************-->
<input type="hidden" id="set_date" name="set_date"></input>
<input type="hidden" id="set_time" name="set_time"></input>
<input type="hidden" id="set_pattern" name="set_pattern"></input>
</form>

<!-- BootStrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>
<script>
  //現在時刻を取得（毎秒）
  setNowTime();
</script>
</body>
</html>
<?php
  //セッション削除
  //出退勤ボタン押下時のメッセージクリアする
  unset($_SESSION['msg_type']);
  unset($_SESSION['message']);
?>
