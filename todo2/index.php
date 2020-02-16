<?php
$conn = mysqli_connect('localhost','root','111111','studyphp');
$sql = "SELECT * FROM todo";
$result = mysqli_query($conn, $sql);
$list = '';

while($row = mysqli_fetch_array($result)) {
  if($row['title'] != '') {
    $escaped_title = htmlspecialchars($row['title']);
    $escaped_destext = htmlspecialchars($row['destext']);
    $list = $list."<li><a href=\"index.php?id={$row['id']}\"><p><i class=\"checkBtn fas fa-check\" aria-hidden=\"true\"></i>{$escaped_title}</p><span class='subtext'>{$escaped_destext}</span></a><a href='index.php?id={$row['id']}' class='btnbox'>
          <i class='removeBtn fas fa-edit' aria-hidden='true'></i>
        </a><form action='process_delete.php' method='post' class='delbtn'>
          <input type='hidden' name='id' value='{$row['id']}'>
          <input type='submit' class='delinput removeBtn' value='&#xf2ed'>
        </form></li>";

  }
}

$article = array(
  'title'=>'',
  'destext'=>''
);
$author ='';
if(isset($_GET['id'])) {
  $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
  $sql = "SELECT * FROM todo left join author on todo.author_id = author_id where todo.id={$filtered_id}";
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

        <?php
        $escaped = array(
          'title'=>'',
          'destext'=>''
        );

        $form_action = 'process_create.php';
        $form_id = '';
        if(isset($_GET['id'])){
          $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
          settype($filtered_id, 'integer');
          $sql = "SELECT * FROM author WHERE id = {$filtered_id}";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_array($result);
          $escaped['title'] = htmlspecialchars($row['title']);
          $escaped['destext'] = htmlspecialchars($row['destext']);
          $form_action = 'process_update.php';
          $form_id = '<input type="hidden" name="id" value="'.$_GET['id'].'">';
        }
        ?>

        <form action="<?= $form_action ?>" method="post">
          <?=$form_id?>
          <input type="text" name="title" placeholder="title" class="input1" value="<?= $article['title']?>">
          <textarea name="destext" placeholder="Description" class="input2" rows="1"><?= $article['destext'] ?></textarea>
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


    </div>


  </div>



  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="./main.js"></script>
</body>

</html>
