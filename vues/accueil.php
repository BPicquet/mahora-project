<?php
if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la page de login
        header("Location:index.php?action=login");
}


?>

<?php
    $mypostsql = "SELECT * FROM ecrit INNER JOIN user ON ecrit.idAuteur = user.id  ORDER BY dateEcrit DESC";

    $query = $pdo->prepare($mypostsql);

    $query->execute([$id]);

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