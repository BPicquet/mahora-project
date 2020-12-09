<?php
$sql = "SELECT * FROM user WHERE login like '%$keyword%' OR email like '%$keyword%'";
$keyword = $_POST['search'];

if($keyword){
  $sql = "SELECT id,email,login FROM user WHERE login like '%$keyword%' OR email like '%$keyword%'";
  $query = $pdo->prepare($sql);
  $query->execute();
  header('Location: index.php?action=search');
    exit();
}
?>