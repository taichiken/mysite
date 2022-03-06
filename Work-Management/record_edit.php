<?php
//セッション開始
session_start();

echo $_SERVER['REQUEST_METHOD'].'(session)';


//DB接続
require_once('db_info.php');

//ファンクション
require_once('function.php');

//パラメータ受け取り
$date = $_GET['set_date'];


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
<title>カレンダー画面</title>
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
打刻一覧
***************************************************************************-->
<div class="container">
  <div>
    <p class="h2"><?php echo insertSlash($date) ?></p>
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
      <?php for ($i=0; $i<count($array_pattern); $i++): ?>
      <tr>
        <!--打刻パターン-->
        <td>
          <select class="form-select" name="color">
            <option value="">選択してください</option>
            <option value="1" <?php echo selectPulldown('1',$array_pattern[$i]) ?>>出勤</option>
            <option value="2" <?php echo selectPulldown('2',$array_pattern[$i]) ?>>退勤</option>
            <option value="3" <?php echo selectPulldown('3',$array_pattern[$i]) ?>>休憩開始</option>
            <option value="4" <?php echo selectPulldown('4',$array_pattern[$i]) ?>>休憩終了</option>
          </select>
        </td>

        <!--打刻時間-->
        <td>
          <input type="text" class="form-control" value="<?php echo insertColon($array_time[$i]) ?>" placeholder="hhmm" maxlength="4"
          oninput="removeNotNum(this);" onblur="insertColon(this);" onfocus="removeColon(this);">
        </td>

        <!--削除チェックボックス-->
        <td><input type="checkbox" name="" value=""></td>
      </tr>

      <!--打刻ID-->
      <input type="hidden" name="<?php echo 'set_id'.$i ?>" value="<?php echo $array_id[$i] ?>"></input>
      <input type="hidden" name="set_count" value="<?php echo $i ?>"></input>
      <?php endfor ?>
    </tbody>
  </table>
  <div>
    <button type="submit" class="btn btn-success m-0">登録</button>
  </div>
</div>
</form>

<!-- BootStrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>
<script>
  //--------------------------------------------------
  //前画面に遷移
  //--------------------------------------------------
  const backRedirect = (prm) =>{
    location.href = './timecard.php?set_date='+prm;
  }

</script>
</body>
</html>
