<?php

$sql = "INSERT INTO aime(idEcrit, idUtilisateur) VALUES(?, ?)";

$query = $pdo->prepare($sql);

$query->execute([$_POST['like-post-id'],$_SESSION['id']]);

header('Location: index.php?action=profile&id='.$_SESSION['id']);
exit();
?>


