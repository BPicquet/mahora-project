<?php
$deletePostID = $_POST['delete-post-id'];
$id = $_SESSION['id'];

$sql = "DELETE FROM ecrit
        WHERE id = ?";

$query = $pdo->prepare($sql);
$query->execute([$deletePostID]);
header('Location: index.php?action=profile&id='.$id);
exit();
?>