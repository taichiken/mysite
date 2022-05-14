<?php
//セッション開始
session_start();

//テスト
//echo $_SERVER['REQUEST_METHOD'].'(session)';


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
//現在月の打刻ID、パターン、時間を配列にセット
//--------------------------------------------------
$result = $mysqli->query("
  select * from T_log
  where date = ".$date."
  order by date,time
");
$array_id = array();
$array_pattern = array();
$array_time = array();
while($row = $result->fetch_assoc()){
  array_push($array_id,$row['id']);
  array_push($array_pattern,$row['pattern']);
  array_push($array_time,$row['time']);
}


//--------------------------------------------------
//打刻時間の登録処理
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
<title>打刻編集画面</title>
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
<div class="alert alert-success">
  <span class="h4"><?php echo $_SESSION['message'] ?></span>
</div>
<?php endif ?>


<!--***************************************************************************
打刻一覧
***************************************************************************-->
<div class="container">
  <!--年月日-->
  <div>
    <p class="h2"><?php echo insertSlash($date) ?><span class="h5"><?php echo $weeks ?></span></p>
  </div>

  <table class="table table-bordered align-middle">
    <thead class="bg-dark text-light">
      <tr>
        <th scope="col" width="45%">打刻種別</th>
        <th scope="col" width="45%">打刻時刻</th>
        <th scope="col" width="10%">削除</th>
      </tr>
    </thead>
    <tbody>
      <?php
        //ログ件数分表示（※最低4行表示）
        $cnt=4;
        if(count($array_pattern) > $cnt){
          $cnt=count($array_pattern);
        }
        for ($i=0; $i<$cnt; $i++):
      ?>
      <tr>
        <!--打刻パターン-->
        <td>
          <select class="form-select" name="<?php echo 'set_pattern'.$i ?>">
            <option value="">選択してください</option>
            <option value="1" <?php echo selectPulldown('1',$array_pattern[$i]) ?>>出勤</option>
            <option value="2" <?php echo selectPulldown('2',$array_pattern[$i]) ?>>退勤</option>
            <option value="3" <?php echo selectPulldown('3',$array_pattern[$i]) ?>>休憩開始</option>
            <option value="4" <?php echo selectPulldown('4',$array_pattern[$i]) ?>>休憩終了</option>
          </select>
        </td>

        <!--打刻時刻-->
        <td>
          <input type="text" class="form-control" value="<?php echo insertColon($array_time[$i]) ?>"
          name="<?php echo 'set_time'.$i ?>" placeholder="hhmm" maxlength="4"
          oninput="removeNotNum(this);" onblur="insertColon(this);" onfocus="removeColon(this);">
        </td>

        <!--削除チェックボックス-->
        <td><input type="checkbox" name="<?php echo 'set_delete'.$i ?>"></td>
      </tr>

      <!--打刻ID-->
      <input type="hidden" name="<?php echo 'set_id'.$i ?>" value="<?php echo $array_id[$i] ?>"></input>
      <input type="hidden" name="set_count" value="<?php echo $i ?>"></input>
      <?php endfor ?>
    </tbody>
  </table>

  <!--登録ボタン-->
  <div>
    <button type="button" class="btn btn-success m-0" onclick="updateLog()">登録</button>
  </div>
</div>

<!--***************************************************************************
hidden
***************************************************************************-->
<input type="hidden" name="set_update_ptn" value="stamp"></input><!--stamp:打刻編集、leave:休暇編集-->
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
<?php
  //セッション削除
  unset($_SESSION['msg_type']);
  unset($_SESSION['message']);
?>
