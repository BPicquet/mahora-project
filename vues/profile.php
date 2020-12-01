<?php

/* Placer image prédifini si valeur == null */
function findImg($img){
    if($img == NULL){
        return "../style/img/image-predefini.png";
    } else {
        return $img;
    }
}

$id = $_GET["id"];

$sql = "SELECT * FROM user WHERE id=?";

$query = $pdo->prepare($sql);

$query->execute([$id]);

if($line = $query->fetch()) { 
   ?>
    <div class="profile-info">
        <img src="<?= findImg($line["avatar"]) ?>" alt="">
        <h2><?= $line["login"]?></h2>
        <p><?= $line["description"]?></p>
        <hr>
    </div>

    <?php
}
?>

<div class="add-post-container">
    <div>
        <h2>Publier</h2>
    </div>
    <div class="add-post div-post">
        <div>
            <?php
            $addpostsql = "SELECT * FROM user WHERE id= ?";
            $query = $pdo->prepare($addpostsql);
            $query->execute([$id]);
            
            if($line = $query->fetch()) {
                ?>
                <?php $loginProfile = $line["login"]; ?>
                <img src="<?= $_SESSION["avatar"]?>" alt="">
                <h3><?= $_SESSION["login"]?></h3>
                <?php
            }
            ?>
        </div>
        <form action="index.php?action=add-post" method="post">
            <input type="text" name="titre" placeholder="Titre" required="" autofocus="" />
            <input type="text" name="contenu" placeholder="Votre publication" required="" autofocus="" />
            <input type="hidden" name="profileId" value="<?= $_GET=['id'] ?>">
            <hr style="width: 200px;">
            <button class="all-button button-login" name="formsendpublication" type="submit">Publier</button>
        </form>
    </div>
</div>
<div class="my-post">
    <div>
        <?php
        if($_SESSION[id] == $_GET['id']){
            echo "<h2>Mes publications</h2>";
        } else{
            echo "<h2>Les publications de " . $loginProfile . "</h2>";
        }
        ?>
    </div>

    <?php
    $mypostsql = "SELECT * FROM ecrit INNER JOIN user ON ecrit.idAuteur = user.id WHERE idAuteur= ? ORDER BY dateEcrit DESC";

    $query = $pdo->prepare($mypostsql);

    $query->execute([$id]);

    while($line = $query->fetch()) {
        ?>
        <div class="div-post">
            <div>
                <img src="<?= findImg($line["avatar"]) ?>" alt="">
                <h3><?= $line["login"]?></h3>
            </div>
            <p><?= $line["contenu"]?></p>
        </div>
        <?php
    }
?>
</div>

