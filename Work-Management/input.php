<?php
//セッション開始
session_start();

//テスト
echo $_SERVER['REQUEST_METHOD'].'(session)';


//DB接続
require_once('db_info.php');

//ファンクション
require_once('function.php');

//パラメータ受け取り
$date = $_GET['set_date'];


//--------------------------------------------------
//曜日取得
//--------------------------------------------------
$result = $mysqli->query("
  select * from T_calendar
  where date=".$date."
");
$row = $result->fetch_array(MYSQLI_ASSOC);
$weeks = getWeek($row['weeks']);
$result->close();

//--------------------------------------------------
//休暇の登録処理
//--------------------------------------------------
if($_SERVER['REQUEST_METHOD']=='POST'){
  $_SESSION['form'] = $_POST;
  header('Location: update.php');
  exit();
}
?>
<!doctype html>
<html class="no-js" lang="ja">
<head>
<meta charset="utf-8">
<title>休暇登録画面</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- BootStrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
<div class="header">
  <div class="header-menu">
    <ul>
      <li><a href="./index.php"><i class="fa-solid fa-house"></i></a></li>
      <li><a href="javascript:backRedirect(<?php echo $date ?>);"><i class="fa-solid fa-angle-left"></i>&nbsp;戻る</a></li>
    </ul>
  </div>
</div>

<div class="container">
  <!--年月日-->
  <div>
    <p class="h2"><?php echo insertSlash($date) ?><span class="h5"><?php echo $weeks ?></span></p>
  </div>

  <!--休暇種類-->
  <div class="row div_border pt-3 pb-3">
    <div class="col-2">休暇種類</div>
    <div class="col-5">
      <select class="form-select" aria-label="Default select">
        <option value="">選択してください</option>
        <option value="01">年次有給</option>
        <option value="02">産前休暇</option>
        <option value="03">産後休暇</option>
        <option value="04">育児休暇</option>
        <option value="05">誕生日休暇</option>
        <option value="06">慶弔休暇</option>
        <option value="07">リフレッシュ休暇</option>
      </select>
    </div>
  </div>

  <!--期間-->
  <div class="row div_border pt-3 pb-3">
    <div class="col-2">期間</div>
    <div class="col-4">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="yyyymmdd" maxlength="8"
        oninput="removeNotNum(this);" onblur="insertSlash(this);" onfocus="removeSlash(this);">
        <select class="px-3 btn btn-outline-secondary" name="example">
          <option value="1">全日</option>
          <option value="2">午前</option>
          <option value="3">午後</option>
        </select>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="yyyymmdd" maxlength="8"
        oninput="removeNotNum(this);" onblur="insertSlash(this);" onfocus="removeSlash(this);">
        <select class="px-3 btn btn-outline-secondary" name="example">
          <option value="1">全日</option>
          <option value="2">午前</option>
          <option value="3">午後</option>
        </select>
      </div>
    </div>
  </div>

  <!--登録メッセージ-->
  <div class="row div_border pt-3 pb-3">
    <div class="col-2">登録メッセージ</div>
    <div class="col-8">
      <textarea class="form-control" id="floatingTextarea2" style="height: 100px"></textarea>
    </div>
  </div>

  <!--登録ボタン-->
  <div>
    <button type="button" class="btn btn-success m-0" onclick="updateLog()">登録</button>
  </div>
</div>

<!--***************************************************************************
hidden
***************************************************************************-->
<input type="hidden" name="set_update_ptn" value="leave"></input><!--stamp:打刻編集、leave:休暇編集-->
<input type="hidden" id="set_update_ptn" value="kyuka"></input>
</form>

<!-- BootStrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!-- sweetalert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./js/main.js"></script>
<script>
  //--------------------------------------------------
  //前画面に遷移
  //--------------------------------------------------
  const backRedirect = (prm) =>{
    location.href = './timecard.php?set_date='+prm;
  }

  //--------------------------------------------------
  //メッセージ表示後、更新処理を行う
  //--------------------------------------------------
  const updateLog = () =>{
    Swal.fire({
      title: '登録しますか?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'OK'
    }).then((result) => {
      if (result.isConfirmed) {
        document.forms[0].submit();
      }
    })
  }
</script>
</body>
</html>
