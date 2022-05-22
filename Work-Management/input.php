<?php
//セッション開始
session_start();

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


//--------------------------------------------------
//休暇申請情報を配列にセット
//--------------------------------------------------
$result = $mysqli->query("
  select * from T_leave
  where leave_date = ".$date."
  limit 2"
);
$array_leave_ptn = array();
$array_leave_type = array();
$array_leave_msg = array();
while($row = $result->fetch_assoc()){
  array_push($array_leave_ptn,$row['leave_ptn']);   /*--休暇パターン--*/
  array_push($array_leave_type,$row['leave_type']); /*--休暇種類--*/
  array_push($array_leave_msg,$row['leave_msg']);   /*--休暇メッセージ--*/
}
$result->close();




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


<!--***************************************************************************
メッセージ（登録処理完了時のみ表示）
***************************************************************************-->
<?php if(isset($_SESSION['message'])): ?>
<div class="alert alert-<?=$_SESSION['msg_type']?>">
  <span class="h4"><?php echo $_SESSION['message'] ?></span>
</div>
<?php endif ?>


<!--***************************************************************************
休暇申請欄
***************************************************************************-->
<div class="container">
  <!--年月日-->
  <div>
    <p class="h2"><?php echo insertSlash($date) ?><span class="h5"><?php echo $weeks ?></span></p>
  </div>

  <!--休暇①-->
  <div class="row div_border pt-3 pb-3">
    <div class="col-2">休暇①</div>
    <!--区分-->
    <div class="col-3">
      <select class="form-select" name="set_leave_ptn1">
        <option value="">選択してください</option>
        <option value="1" <?php echo selectPulldown('1',$array_leave_ptn[0]) ?>>全日</option>
        <option value="2" <?php echo selectPulldown('2',$array_leave_ptn[0]) ?>>午前</option>
        <option value="3" <?php echo selectPulldown('3',$array_leave_ptn[0]) ?>>午後</option>
      </select>
    </div>
    <!--休暇種類-->
    <div class="col-5">
      <select class="form-select" name="set_leave_type1">
        <option value="">選択してください</option>
        <option value="01" <?php echo selectPulldown('01',$array_leave_type[0]) ?>>年次有給</option>
        <option value="02" <?php echo selectPulldown('02',$array_leave_type[0]) ?>>産前休暇</option>
        <option value="03" <?php echo selectPulldown('03',$array_leave_type[0]) ?>>産後休暇</option>
        <option value="04" <?php echo selectPulldown('04',$array_leave_type[0]) ?>>育児休暇</option>
        <option value="05" <?php echo selectPulldown('05',$array_leave_type[0]) ?>>誕生日休暇</option>
        <option value="06" <?php echo selectPulldown('06',$array_leave_type[0]) ?>>慶弔休暇</option>
        <option value="07" <?php echo selectPulldown('07',$array_leave_type[0]) ?>>リフレッシュ休暇</option>
      </select>
    </div>
  </div>

  <!--休暇②-->
  <div class="row div_border pt-3 pb-3">
    <div class="col-2">休暇②</div>
    <!--区分-->
    <div class="col-3">
      <select class="form-select" name="set_leave_ptn2">
        <option value="">選択してください</option>
        <option value="1" <?php echo selectPulldown('1',$array_leave_ptn[1]) ?>>全日</option>
        <option value="2" <?php echo selectPulldown('2',$array_leave_ptn[1]) ?>>午前</option>
        <option value="3" <?php echo selectPulldown('3',$array_leave_ptn[1]) ?>>午後</option>
      </select>
    </div>
    <!--休暇種類-->
    <div class="col-5">
      <select class="form-select" name="set_leave_type2">
        <option value="">選択してください</option>
        <option value="01" <?php echo selectPulldown('01',$array_leave_type[1]) ?>>年次有給</option>
        <option value="02" <?php echo selectPulldown('02',$array_leave_type[1]) ?>>産前休暇</option>
        <option value="03" <?php echo selectPulldown('03',$array_leave_type[1]) ?>>産後休暇</option>
        <option value="04" <?php echo selectPulldown('04',$array_leave_type[1]) ?>>育児休暇</option>
        <option value="05" <?php echo selectPulldown('05',$array_leave_type[1]) ?>>誕生日休暇</option>
        <option value="06" <?php echo selectPulldown('06',$array_leave_type[1]) ?>>慶弔休暇</option>
        <option value="07" <?php echo selectPulldown('07',$array_leave_type[1]) ?>>リフレッシュ休暇</option>
      </select>
    </div>
  </div>


  <!--登録メッセージ-->
  <div class="row div_border pt-3 pb-3">
    <div class="col-2">登録メッセージ</div>
    <div class="col-8">
      <textarea class="form-control" name="set_leave_msg" id="floatingTextarea2" style="height: 100px"><?php echo $array_leave_msg[1] ?></textarea>
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
<input type="hidden" id="set_date" name="set_date" value="<?php echo $date ?>"></input>
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
