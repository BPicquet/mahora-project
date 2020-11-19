<?php

include("config/config.php");
include("config/bd.php"); // commentaire
include("divers/balises.php");
include("config/actions.php");
session_start();
ob_start(); // Je démarre le buffer de sortie : les données à afficher sont stockées


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahora Project</title>
    <link rel="icon" type="image/png" href="./style/img/logo-mahora.png" />

    <!-- Ma feuille de style à moi -->
    <link rel="stylesheet" href="./style/style.css">
    <script src="js/jquery-3.2.1.min.js"></script>
</head>

<body>
    <header>
        <div>
            <a href="index.php?action=accueil&id=<?php echo $_SESSION['id'] ?>"><img class="logo-mahora" src="./style/img/logo-mahora.png" alt=""></a>
            <a href="index.php?action=accueil&id=<?php echo $_SESSION['id'] ?>"><p>ahora</p></a>
        </div>    
        <div class="search">
            <img src="./style/img/search.png" alt="">
            <input type="text" placeholder="Rechercher">
        </div>

        <div class="notification">
            <img src="./style/img/notification.png" alt="">
        </div>
    </header>
    <?php
        if (isset($_SESSION['info'])) {
            echo "<div>
            <strong>Information : </strong> " . $_SESSION['info'] . "</div>";
            unset($_SESSION['info']);
        }
    ?>

    <nav>
        <ul>
            <?php
            if (isset($_SESSION['id'])) {
                echo "<li>Tu es connecté " . $_SESSION['login'] . " <a href='index.php?action=deconnexion'>Deconnexion</a></li>";
            ?>
                <li><a href="index.php?action=profile&id=<?php echo $_SESSION['id'] ?>"><?php echo $_SESSION['login'] ?></a></li>
                <li><a href="index.php?action=page3">404 page</a></li>
            <?php
            } else {
                echo "<li><a href='index.php?action=login'>Login</a></li>";
            }
            ?>
        </ul>
    </nav>
        <?php
            // Quelle est l'action à faire ?
            if (isset($_GET["action"])) {
                $action = $_GET["action"];
            } else {
                $action = "accueil";
            }

            // Est ce que cette action existe dans la liste des actions
            if (array_key_exists($action, $listeDesActions) == false) {
                include("vues/404.php"); // NON : page 404
            } else {
                include($listeDesActions[$action]); // Oui, on la charge
            }

            ob_end_flush(); // Je ferme le buffer, je vide la mémoire et affiche tout ce qui doit l'être
        ?>
</body>
</html>
