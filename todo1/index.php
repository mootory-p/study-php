<?php
$conn = mysqli_connect('localhost','root','111111','studyphp');
$sql = "SELECT * FROM todo";
$result = mysqli_query($conn, $sql);
$list = '';
while($row = mysqli_fetch_array($result)) {
  if($row['title'] != '') {
    $escaped_title = htmlspecialchars($row['title']);
  $list = $list."<li><a href=\"index.php?id={$row['id']}\"><p><i class=\"checkBtn fas fa-check\" aria-hidden=\"true\"></i>{$escaped_title}</p></a></li>";
  }
}

$article = array(
  'title'=>'',
  'destext'=>''
);
if(isset($_GET['id'])) {
  $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
  $sql = "SELECT * FROM todo WHERE id={$filtered_id}";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $article['title'] = htmlspecialchars($row['title']);
  $article['destext'] = htmlspecialchars($row['destext']);


}


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>firsr</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR:300,400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./style.css">


</head>

<body>
  <div class="wrap">
    <div class="card m-3 p-2">
      <h2 class="text-center my-4"><a href="./index.php">PHP Todo</a></h2>
      <div class="inputbox">
        <form action="process_create.php" method="post">
          <input type="text" name="title" placeholder="title" class="input1" required>
          <textarea name="destext" placeholder="Description" class="input2" rows="1"></textarea>
          <button type="submit" class="addBtn"><i class="fas fa-plus"></i></button>
        </form>
      </div>
      <div class="listbox">
        <ul>
          <?= $list ?>
        </ul>
      </div>
      <div class="readbox">
        <p class="title"><?= $article['title'] ?></p>
        <p class="destext"><?= $article['destext'] ?></p>

      </div>
      <?php if(isset($_GET['id'])) { ?>


      <div class="inputbox updatebox">
        <a href='process_update.php?id=<?= $_GET['id'] ?>' class="btnbox"><i class='removeBtn fas fa-edit' aria-hidden='true'></i></a>
        <form action="process_delete.php" method="post" class="delbtn">
          <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
          <input type="submit" class="delinput removeBtn" value="&#xf2ed">
        </form>
        <form action="process_update.php" method="post">
          <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
          <input type="text" name="title" placeholder="title" class="input1" value="<?= $article['title']?>">
          <textarea name="destext" placeholder="Description" class="input2" rows="1"><?= $article['destext'] ?></textarea>
          <button type="submit" class="addBtn"><i class="fas fa-plus"></i></button>
        </form>
      </div>
      <?php } ?>
    </div>


  </div>



  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="./main.js"></script>
</body>

</html>
