<?php
$conn = mysqli_connect(
  'localhost',
  'root',
  '111111',
  'studyphp');
$filtered = array(
  'title'=>mysqli_real_escape_string($conn, $_POST['title']),
  'destext'=>mysqli_real_escape_string($conn, $_POST['destext']),
  'id'=>mysqli_real_escape_string($conn,$_POST['id'])
);
$sql = "
  UPDATE todo
    SET
      title = '{$filtered['title']}',
      destext = '{$filtered['destext']}'
    WHERE
      id = {$filtered['id']}
";

$result = mysqli_query($conn, $sql);
if($result === false){
  echo '수정하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
  error_log(mysqli_error($conn));
} else {
  echo '성공했습니다. <a href="index.php">돌아가기</a>';
}
?>
