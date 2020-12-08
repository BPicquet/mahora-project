<?php
if(!isset($_SESSION["id"])) {
    // On n est pas connecté, il faut retourner à la pgae de login
    header("Location:index.php?action=login");
}

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
$ok = false;

if(!isset($_GET["id"]) || $_GET["id"]==$_SESSION["id"]){
    $id = $_SESSION["id"];
    $ok = true; 
} else {
    $id = $_GET["id"];
    $verifAmiSql = "SELECT * FROM lien WHERE etat='ami' 
            AND ((idUtilisateur1=? AND idUtilisateur2=?) OR ((idUtilisateur2=? AND idUtilisateur1=?)))";

    $query = $pdo->prepare($verifAmiSql);
    $query->execute([$_SESSION['id'], $_GET['id'], $_GET['id'], $_SESSION['id']]);
            
    if(!isset($line["etat"])) {
        $ok = true;
    }
}

if($ok == false) {
    echo "<h4>Vous n'êtes pas encore ami, vous ne pouvez voir son mur !</h4>";
    ?>

    <form action="index.php?action=add-friend" method="post">
        <input type="hidden" name="profile-id" value="<?= $_GET['id'] ?>">
        <button class="all-button button-invit" type="submit">Envoyer invitation</button>
    </form>

    <?php   
} else {
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
                <input type="hidden" name="profile-id" value="<?= $_GET['id'] ?>">
                <hr style="width: 200px;">
                <button class="all-button button-login" name="formsendpublication" type="submit">Publier</button>
            </form>
        </div>
    </div>
    <div class="my-post">
        <div>
            <?php
            if($_SESSION['id'] == $_GET['id']){
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
    <?php
}




