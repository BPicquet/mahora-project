<?php
$acceptFriendId = $_POST['accept-friend-id'];
$id = $_SESSION['id'];

$sql = "UPDATE lien
        SET etat = 'ami'
        WHERE (idUtilisateur1 = ? AND idUtilisateur2 = ?)
        OR (idUtilisateur2 = ? AND idUtilisateur1 = ?)";

$query = $pdo->prepare($sql);
$query->execute([$id, $acceptFriendId, $id, $acceptFriendId]);
header('Location: index.php?action=accueil&id='.$id);
exit();
?>