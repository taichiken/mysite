<!doctype html>
<html class="no-js" lang="ja">
<head>
<meta charset="utf-8">
<title>CRUD</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- BootStrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!--Font Awesome-->
<link href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" rel="stylesheet">
<meta name="theme-color" content="#fafafa">
</head>
<body>
  <?php require_once('db_info.php'); ?>
  <?php require_once('process.php'); ?>

  <!--**********************************************************************
  処理に対するメッセージを表示
  **********************************************************************-->
  <?php if(isset($_SESSION['message'])): ?>
  <div class="alert alert-<?=$_SESSION['msg_type']?>">
    <?php
      echo $_SESSION['message'];
      unset($_SESSION['message']);
    ?>
  </div>
  <?php endif ?>

  <div class="container">
    <!--**********************************************************************
    テーブルの値をリスト形式で表示
    **********************************************************************-->
    <?php
      $result = $mysqli->query("select * from data");
    ?>
    <div>
      <table class="table">
        <tr>
          <th>Name</th>
          <th>Cost</th>
          <th>Color</th>
          <th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['name'] ?></td>
          <td><?php echo $row['cost'] ?></td>
          <td><?php echo $row['color'] ?></td>
          <td>
            <a href="main.php?edit=<?php echo $row['id'] ?>" class="btn btn-info">Edit</a>
            <a href="process.php?delete=<?php echo $row['id'] ?>" class="btn btn-danger">Delete</a>
          </td>
        </tr>
        <?php endwhile ?>
      </table>
    </div>

    <!--**********************************************************************
    入力エリア
    **********************************************************************-->
    <div class="d-flex justify-content-center">
      <form action="process.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <div class="mt-3 mb-3">
          <label>Name</label>
          <input type="text" class="form-control" name="name" value="<?php echo $name ?>" placeholder="例）スライム">
        </div>
        <div class="mb-3">
          <label>Cost</label>
          <input type="text" class="form-control" name="cost" value="<?php echo $cost ?>" placeholder="例）3">
        </div>
        <div class="mb-3">
          <label>Color</label>
          <input type="text" class="form-control" name="color" value="<?php echo $color ?>" placeholder="例）黄">
        </div>
        <div>
          <!--ボタン制御-->
          <?php if($update == true): ?>
          <button type="submit" class="btn btn-info" name="update">Update</button>
          <?php else: ?>
          <button type="submit" class="btn btn-primary" name="save">Save</button>
          <?php endif ?>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
