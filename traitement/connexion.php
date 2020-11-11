<?php

$sql = "SELECT * FROM user WHERE login=? AND mdp=PASSWORD(?)";

// Etape 1  : preparation
$query = $pdo->prepare($sql);

// Etape 2 : execution : 2 paramètres dans la requêtes !!
$query->execute([$_POST['login'],$_POST['mdp']]);

// Etape 3 : ici le login est unique, donc on sait que l'on peut avoir zero ou une  seule ligne.
if($line = $query->fetch()) { 
    // sinon on crée les variables de session $_SESSION['id'] et $_SESSION['login'] et on va à la page d'accueil
    $_SESSION["id"]=$line["id"];
    $_SESSION["login"]=$line["login"];
    header('Location: index.php?action=accueil&id='.$line['id']);
    exit();
}
else{
    // Si $line est faux le couple login mdp est mauvais, on retourne au formulaire
    echo "<p>Pseudo ou mot de passe incorrect</p>";
    header("Location: index.php?action=login");
    exit();
}

?>