<?php

$id = $_GET["id"];

$sql = "SELECT * FROM user WHERE id=?";

$query = $pdo->prepare($sql);

$query->execute([$id]);

if($line = $query->fetch()) { 
   ?>
    <div class="profile-info">
        <img href="<?= $line["avatar"]?>"/>
        <h2><?= $line["login"]?></h2>
        <p><?= $line["description"]?></p>
    </div>

    <?php
}
?>
<section class="my-post">
    <h2>Mes publications</h2>

    <?php
    $mypostsql = "SELECT * FROM ecrit WHERE id=idAuteur";

    $query = $pdo->prepare($mypostsql);

    $query->execute([$id]);

    if($line = $query->fetch()) {
        ?>
        <div>
            <div>
                <img src="" alt="">
                <h2></h2>
            </div>
            <p></p>
        </div>
        <?php
    }
?>
</section>

