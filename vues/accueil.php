<?php
if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la page de login
        header("Location:index.php?action=login");
}
?>
<section class="accueil-post">
    <div class="add-post div-post">
        <div>
            <?php
            $addpostsql = "SELECT * FROM ecrit INNER JOIN user ON ecrit.idAuteur = user.id  ORDER BY dateEcrit DESC";
            $query = $pdo->prepare($addpostsql);
            $query->execute([]);

            if($line = $query->fetch()) {
                ?>
                <img src="<?= $line["avatar"]?>" alt="">
                <h3><?= $line["login"]?></h3>
                <?php
            }
            ?>
        </div>
        <form action="index.php?action=add-post" method="post">
            <input type="text" name="titre" placeholder="Titre" required="" autofocus="" />
            <input type="text" name="contenu" placeholder="Votre publication" required="" autofocus="" />
            <button class="all-button button-login" name="formsendpublication" type="submit">Publier</button>
        </form>
    </div>

<?php
    $mypostsql = "SELECT * FROM ecrit INNER JOIN user ON ecrit.idAuteur = user.id  ORDER BY dateEcrit DESC";
    $query = $pdo->prepare($mypostsql);
    $query->execute([]);

    while($line = $query->fetch()) {
        ?>
        <div class="div-post">
            <div>
                <img src="<?= $line["avatar"]?>" alt="">
                <h3><?= $line["login"]?></h3>
            </div>
            <p><?= $line["contenu"]?></p>
        </div>
        <?php
    }
?>
</section>