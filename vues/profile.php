<?php

$id = $_GET["id"];

$sql = "SELECT * FROM user WHERE id=?";

$query = $pdo->prepare($sql);

$query->execute([$id]);

if($line = $query->fetch()) { 
   ?>
    <div class="profile-info">
        <img src="<?= $line["avatar"]?>"/>
        <h2><?= $line["login"]?></h2>
        <p><?= $line["description"]?></p>
        <hr>
    </div>

    <?php
}
?>

<section class="my-post">
    <div>
        <h2>Mes publications</h2>
    </div>

    <?php
    $mypostsql = "SELECT * FROM ecrit WHERE idAuteur= ?";

    $query = $pdo->prepare($mypostsql);

    $query->execute([$id]);

    while($line = $query->fetch()) {
        ?>
        <div class="div-post">
            <div>
                <img src="" alt="">
                <h3><?= $line["titre"]?></h3>
            </div>
            <p><?= $line["contenu"]?></p>
        </div>
        <?php
    }
?>
</section>

