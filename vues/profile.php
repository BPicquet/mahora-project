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
    $userProfile = $line["login"];
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
$askFriend = false;

if(!isset($_GET["id"]) || $_GET["id"]==$_SESSION["id"]){
    $id = $_SESSION["id"];
    $ok = true; 
} else {
    $id = $_GET["id"];
    $verifAmiSql = "SELECT * FROM lien WHERE ((idUtilisateur1=? AND idUtilisateur2=?) OR ((idUtilisateur1=? AND idUtilisateur2=?)))";

    $query = $pdo->prepare($verifAmiSql);
    $query->execute([$_SESSION['id'], $_GET['id'], $_GET['id'], $_SESSION['id']]);
            
    if($line = $query->fetch()) {
        if(isset($line["etat"])){
            $ok = true;
            if($line["etat"] == "attente"){
                $askFriend = true;
            }
        }
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
}
elseif($ok == true AND $askFriend == true){
    echo "<h4>Demande envoyée, en attente d'une réponse de " . $userProfile . " !</h4>";
}
else {
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
                    <img src="<?= findImg($_SESSION["avatar"])?>" alt="">
                    <h3><?= $_SESSION["login"]?></h3>
                    <?php
                }
                ?>
            </div>
            <form action="index.php?action=add-post" method="post">
                <input type="text" name="titre" placeholder="Titre" required="" autofocus="" />
                <input type="text" name="contenu" placeholder="Votre publication" required="" autofocus="" />
                <input type="hidden" name="profile-id" value="<?= $_GET['id'] ?>">
                <input type="file" name="add-img" class="button-add-img">
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
        
        $mypostsql =   "SELECT *,
                            ecrit.id, 
                            auteur.avatar AS auteur_avatar, 
                            ami.avatar AS ami_avatar,
                            auteur.login AS auteur_login,
                            ami.login AS ami_login
                        FROM ecrit
                        JOIN user auteur ON auteur.id = ecrit.idAuteur
                        JOIN user ami ON ami.id = ecrit.idAmi
                        WHERE idAuteur=? AND idAmi=?
                        OR idAuteur=? AND idAmi=?
                        OR idAuteur=? AND idAmi=?
                        ORDER BY dateEcrit DESC"; 

        $query = $pdo->prepare($mypostsql);

        $query->execute([$_SESSION['id'], $_GET['id'], $_GET['id'], $_GET['id'], $_GET['id'], $_SESSION['id']]); 

        while($line = $query->fetch()) {
            ?>
            <div class="div-post">
                <div>
                    <img src="<?= findImg($line["auteur_avatar"]) ?>" alt="">
                    <?php
                    if($line["idAuteur"] == $_SESSION['id'] AND $line["idAmi"] == $_SESSION["id"]){
                        ?>
                        <a href="index.php?action=profile&id=<?php echo $line["idAuteur"] ?>"><h3><?= $line["auteur_login"] ?></h3></a>
                        <?php
                    }else{
                        ?>
                        <a href="index.php?action=profile&id=<?php echo $line["idAuteur"] ?>"><h3><?= $line["auteur_login"] ?></h3></a>
                        <p>→</p>
                        <a href="index.php?action=profile&id=<?php echo $line["idAmi"] ?>"><h3>&nbsp<?= $line["ami_login"] ?></h3></a>
                        <?php
                    }
                    ?>
                </div>
                <p><?= $line["contenu"]?></p>
                <img src=<?= $line['image'] ?> alt="">
                <div class="like-delete-container">
                    <div class="like-menu">
                        <form action="index.php?action=like-post" method="post">
                            <input type="hidden" name="like-post-id" value="<?= $line['id'] ?>">
                            <button type="submit" class="button-like-post">Aimer</button>
                        </form>
                    </div>
                <?php
                if($line["idAuteur"] == $_SESSION['id']){
                        ?>
                        <form action="index.php?action=delete-post" method="post">
                            <input type="hidden" name="delete-post-id" value="<?= $line['id'] ?>">
                            <button type="submit" class="button-delete-post">Supprimer</button>
                        </form>
                        <?php
                    }
                ?>
                </div>
            </div>
            <?php
        }
    ?>
    </div>
    <?php
}




