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
<section class="index-menu">
    <div class="header-container">
        <header class="header-index">
            <?php
            if(isset($_SESSION['id'])){
            ?>
                <div>
                    <a href="index.php?action=accueil&id=<?= $_SESSION['id'] ?>"><img class="logo-mahora" src="./style/img/logo-mahora.png" alt=""></a>
                    <a href="index.php?action=accueil&id=<?= $_SESSION['id'] ?>"><p>ahora</p></a>
                </div>

                <div class="search">
                    <form action="index.php?action=search-friend" method="post">
                        <input type="text" name="search" placeholder="Rechercher">
                        <button type="submit"><img src="./style/img/search.png" alt=""></button>
                    </form>
                </div>
            <?php
            }
            ?>
        </header>
    
    
        <?php
        if (isset($_SESSION['info'])) {
            echo "<div>
            <strong>Information : </strong> " . $_SESSION['info'] . "</div>";
            unset($_SESSION['info']);
        }
        ?>

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
    </div>

    <?php
    if(isset($_SESSION['id'])){
    ?>
    <div class="menu-profile">
            <div class="info-user">
                <img src="<?= findImg($_SESSION["avatar"])?>" alt="">
                <div>   
                    <a href="index.php?action=profile&id=<?php echo $_SESSION['id'] ?>"><h3><?= $_SESSION['login'] ?></h3></a>
                    <a href='index.php?action=deconnexion'>Deconnexion</a>
                </div>
            </div>

            <div class="friends-online">
                <p>Tous mes amis</p>
                <?php
                $friendsql = "SELECT * FROM user WHERE id 
                                IN (SELECT user.id FROM user 
                                INNER JOIN lien ON idUtilisateur1=user.id 
                                AND etat='ami' AND idUtilisateur2=? 
                                UNION SELECT user.id FROM user 
                                INNER JOIN lien ON idUtilisateur2=user.id 
                                AND etat='ami' AND idUtilisateur1=?)";
                $query = $pdo->prepare($friendsql);
                $query->execute([$_SESSION['id'], $_SESSION['id']]);

                while($line = $query->fetch()) {
                ?>
                    <div>
                        <img src="<?= findImg($line["avatar"]) ?>" alt="">
                        <div>
                            <a href="index.php?action=profile&id=<?php echo $line["id"] ?>"><h4><?= $line["login"] ?></h4></a>
                            <form action="index.php?action=delete-friend" method="post">
                                <input type="hidden" name="delete-friend-id" value="<?= $line['id'] ?>">
                                <button type="submit" class="delete-friend">Supprimer</button>
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="invit-friends">
                <p>Invitations</p>
                <?php
                $invitesql = "SELECT * FROM user
                                WHERE id IN(SELECT idUtilisateur1 FROM lien 
                                WHERE idUtilisateur2=? AND etat='attente')";
                $query = $pdo->prepare($invitesql);
                $query->execute([$_SESSION['id']]);

                while($line = $query->fetch()) {
                ?>
                    <div>
                        <img src="<?= findImg($line["avatar"]) ?>" alt="">
                        <div>   
                            <a href="index.php?action=profile&id=<?php echo $line["id"] ?>"><h4><?= $line["login"] ?></h4></a>
                            <div class="form-add-delete">
                                <form action="index.php?action=accept-friend" method="post">
                                    <input type="hidden" name="accept-friend-id" value="<?= $line['id'] ?>">
                                    <button type="submit" class="button-accept-friend">Accepter</button>
                                </form>
                                <form action="index.php?action=delete-friend" method="post">
                                    <input type="hidden" name="delete-friend-id" value="<?= $line['id'] ?>">
                                    <button type="submit" class="button-delete-friend">Refuser</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    <?php 
    }
    ?>

</section>    
</body>
</html>
