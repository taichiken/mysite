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
    ,from_time
    ,to_time
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
        <th scope="col">編集<br>申請</th>
        <th scope="col">日付</th>
        <th scope="col">出勤</th>
        <th scope="col">退勤</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <th scope="row"></th>
        <td class="<?php echo getColor($row['weeks']) ?>">
          <?php echo substr($row['date'],4,2).'/'.substr($row['date'],-2).getWeek($row['weeks']) ?>
        </td>
        <td><?php echo $row['from_time'] ?></td>
        <td><?php echo $row['to_time'] ?></td>
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
