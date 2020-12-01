<?php

$sql = "SELECT * FROM user WHERE login=? AND mdp=?";

$query = $pdo->prepare($sql);

$query->execute([$_POST['login'],sha1($_POST['mdp'])]);

if($line = $query->fetch()) { 
    // sinon on crée les variables de session $_SESSION['id'] et $_SESSION['login'] et on va à la page d'accueil
    $_SESSION["id"]=$line["id"];
    $_SESSION["login"]=$line["login"];
    $_SESSION["avatar"]=$line["avatar"];
    header('Location: index.php?action=profile&id='.$line['id']);
    exit();
}
else{
    // Si $line est faux le couple login mdp est mauvais, on retourne au formulaire
    echo "Pseudo ou mot de passe incorrect";
    header("Location: index.php?action=login");
    exit();
}

?>