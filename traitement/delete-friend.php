<?php
$deleteFriendId = $_POST['delete-friend-id'];
$id = $_SESSION['id'];

$sql = "DELETE FROM lien
        WHERE (idUtilisateur1 = ? AND idUtilisateur2 = ?)
        OR (idUtilisateur2 = ? AND idUtilisateur1 = ?)";

$query = $pdo->prepare($sql);
$query->execute([$id, $deleteFriendId, $id, $deleteFriendId]);
header('Location: index.php?action=accueil&id='.$id);
exit();
?>