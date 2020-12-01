<?php
$id = $_SESSION['id'];

if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la page de login
        header("Location:index.php?action=login");
}
?>
<section class="accueil-post">
    <h2>Ecrire sur l'accueil</h2>
    <div class="add-post div-post">
        <div>
            <?php
            $addpostsql = "SELECT * FROM user WHERE id= ?";
            $query = $pdo->prepare($addpostsql);
            $query->execute([$id]);

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
            <input type="hidden" name="profile-id" value="<?= $_GET=['id'] ?>">
            <hr style="width: 200px;">
            <button class="all-button button-login" name="formsendpublication" type="submit">Publier</button>
        </form>
    </div>

<?php
    /* Placer image prédifini si valeur == null */
    function findImg($img){
        if($img == NULL){
            return "../style/img/image-predefini.png";
        } else {
            return $img;
        }
    }

    $mypostsql = "SELECT * FROM ecrit INNER JOIN user ON ecrit.idAuteur = user.id  ORDER BY dateEcrit DESC";
    $query = $pdo->prepare($mypostsql);
    $query->execute([]);
    ?>
    <?php
    while($line = $query->fetch()) {
        ?>
        <div class="div-post">
            <div>
                <img src="<?= findImg($line["avatar"]) ?>" alt="">
                <a href="index.php?action=profile&id=<?php echo $line["idAuteur"] ?>"><h3><?= $line["login"]?></h3></a>
            </div>
            <p><?= $line["contenu"]?></p>
        </div>
        <?php
    }
?>
</section>