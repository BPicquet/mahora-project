<?php
/* Placer image prédifini si valeur == null */
function findImg($img){
    if($img == NULL){
        return "../style/img/image-predefini.png";
    } else {
        return $img;
    }
}
?>

<section class="search-user">
    <?php
    $sql = "SELECT * FROM user WHERE login like '%$keyword%' OR email like '%$keyword%'";
    $keyword = $_GET['value'];

    if($keyword){
        ?>
        <h3>Voici les résultats pour la recherche: <?= $keyword ?></h3>
        <?php
        $sql = "SELECT id,email,login,avatar FROM user WHERE login like '%$keyword%' OR email like '%$keyword%'";
        $query = $pdo->prepare($sql);
        $query->execute();
        ?>
        <div class="search-user-container">
        <?php
        while($line = $query->fetch()){
            ?>
            <div class="search-user-content">
                <img src="<?= findImg($line['avatar']) ?>" alt="">
                <a href="index.php?action=profile&id=<?php echo $line["id"] ?>"><h3><?= $line['login'] ?></h3></a>
            </div>
            <?php
        }
        ?>          
        </div>
        <?php
    }else{
        echo "Veuillez rentrer un nom dans la barre de recherche";
    }
    ?>
</section>