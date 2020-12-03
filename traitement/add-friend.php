<?php
    $idProfile = $_POST['profile-id'];

    $query = $pdo->prepare('INSERT INTO lien(idUtilisateur1, idUtilisateur2, etat) VALUES(:idUtilisateur1, :idUtilisateur2, :etat)');
    $query->execute(array(
        'idUtilisateur1' => $_SESSION['id'],
        'idUtilisateur2' => $idProfile,
        'etat' => "ami"));
    header('Location: index.php?action=profile&id=' . $idProfile);
    exit();   
?>