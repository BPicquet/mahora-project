<?php
$id = $_SESSION['id'];

/* Placer image prédifini si valeur == null */
function findImg($img){
    if($img == NULL){
        return "../style/img/image-predefini.png";
    } else {
        return $img;
    }
}

if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la page de login
        header("Location:index.php?action=login");
}
?>
<section class="accueil-post">
    <h2>Publications de vos amis</h2>
<?php

    /* Affichage ami mais pas affichage ses post, a changer et ajouter table user */
    $mypostsql = "SELECT * FROM ecrit
                    INNER JOIN lien ON idUtilisateur1 = ?
                    WHERE idUtilisateur2 = ecrit.idAmi
                    AND lien.etat = 'ami'
                    UNION SELECT * FROM ecrit
                    INNER JOIN lien ON idUtilisateur1 = ecrit.idAmi
                    WHERE idUtilisateur2 = ?
                    AND lien.etat = 'ami'";

    $query = $pdo->prepare($mypostsql);
    $query->execute([$_SESSION['id'], $_SESSION['id']]);
    ?>
    <?php
    while($line = $query->fetch()) {
        ?>
        <div class="div-post">
            <div>
                <img src="<?= findImg($line["avatar"]) ?>" alt="">
                <a href="index.php?action=profile&id=<?php echo $line["idAmi"] ?>"><h3><?= $line['login'] ?></h3></a>
            </div>
            <p><?= $line["contenu"]?></p>
        </div>
        <?php
    }
?>
</section>