<?php
//DB接続
require_once('db_info.php');

//現在日付
$current_date = date('Ymd');

//現在月で絞り込み
$result = $mysqli->query("
  select
    main.date
    ,main.weeks
    ,left(right(CONCAT('000000',from_time),6),4) as from_time
    ,left(right(CONCAT('000000',to_time),6),4) as to_time
  from T_calendar as main
  left join(
    select date,min(time) as from_time from T_log where pattern='1' group by date
  ) as frlog on frlog.date=main.date
  left join(
    select date,max(time) as to_time from T_log where pattern='2' group by date
  ) as tolog on tolog.date=main.date
  where left(main.date,6) = ".substr($current_date,0,6)."
  order by main.date;
");

//--------------------------------------------------
//コロンセット
//--------------------------------------------------
function insertColon($prm){
  if($prm!=''){
    $prm = substr($prm,0,2).':'.substr($prm,2,2);
  }
  return $prm;
}


//--------------------------------------------------
//コロンセット
//--------------------------------------------------
function insertSlash($prm){
  return substr($prm,4,2).'/'.substr($prm,-2);
}


//--------------------------------------------------
//コロンセット
//--------------------------------------------------
function getWorkTime($prm1,$prm2){
  $total = '';
  if($prm1!=''&&$prm2!=''){
    $total = ((substr($prm2,0,2)*60)+substr($prm2,2,2)) - ((substr($prm1,0,2)*60)+substr($prm1,2,2));
    $total = insertColon(substr('00'.floor($total/60),-2).substr('00'.floor($total%60),-2));
  }
  return $total;
}

//--------------------------------------------------
//色取得
//--------------------------------------------------
function getColor($prm){
  if($prm=='7'){
    $color = 'text-primary';
  }elseif($prm=='1'){
    $color = 'text-danger';
  }
  return $color;
}

//--------------------------------------------------
//曜日取得
//--------------------------------------------------
function getWeek($prm){
  if($prm=='1'){
    $dayofweek = '（日）';
  }elseif($prm=='2'){
    $dayofweek = '（月）';
  }elseif($prm=='3'){
    $dayofweek = '（火）';
  }elseif($prm=='4'){
    $dayofweek = '（水）';
  }elseif($prm=='5'){
    $dayofweek = '（木）';
  }elseif($prm=='6'){
    $dayofweek = '（金）';
  }elseif($prm=='7'){
    $dayofweek = '（土）';
  }
  return $dayofweek;
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
<link href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" rel="stylesheet">
<link href="./css/main.css" rel="stylesheet">
<meta name="theme-color" content="#fafafa">
</head>
<body>
<div class="container">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col" width="5%">編集<br>申請</th>
        <th scope="col" width="15%">日付</th>
        <th scope="col" width="5%">締</th>
        <th scope="col" width="35%">スケジュール</th>
        <th scope="col" width="10%">出勤</th>
        <th scope="col" width="10%">退勤</th>
        <th scope="col" width="10%">実働時間</th>
        <th scope="col" width="10%">労働時間<br>有給含</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <th scope="row"></th>
        <td class="<?php echo getColor($row['weeks']) ?>">
          <?php echo insertSlash($row['date']).getWeek($row['weeks']) ?>
        </td>
        <td></td>
        <td></td>
        <td><?php echo insertColon($row['from_time']) ?></td>
        <td><?php echo insertColon($row['to_time']) ?></td>
        <td><?php echo getWorkTime($row['from_time'],$row['to_time']) ?></td>
        <td></td>
      </tr>
      <?php endwhile ?>
    </tbody>
  </table>
</div>
<!-- BootStrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>
</body>
</html>
