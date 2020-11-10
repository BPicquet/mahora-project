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
    <title>Ma super application</title>
    <link rel="icon" type="image/png" href="./style/img/logo-mahora.png" />

    <!-- Ma feuille de style à moi -->
    <link rel="stylesheet" href="./style/style.css">
    <script src="js/jquery-3.2.1.min.js"></script>
</head>

<body>
    <?php
        if (isset($_SESSION['info'])) {
            echo "<div>
            <strong>Information : </strong> " . $_SESSION['info'] . "</div>";
            unset($_SESSION['info']);
        }
    ?>

    <header>    
        <div class="search">
            <img src="./style/img/search.png" alt="">
            <input type="text" placeholder="Rechercher">
        </div>

        <div class="notification">
            <img src="./style/img/notification.png" alt="">
        </div>
    </header>
    <nav>
    <ul>
        <li><a href="index.php?action=accueil">Va voir la page 2</a></li>

        <?php
        if (isset($_SESSION['id'])) {
            echo "<li>Bonjour " . $_SESSION['login'] . " <a href='index.php?action=deconnexion'>Deconnexion</a></li>";
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
