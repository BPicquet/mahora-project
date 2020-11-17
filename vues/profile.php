<?php

$id = $_GET["id"];

$sql = "SELECT * FROM user WHERE id=?";

$query = $pdo->prepare($sql);

$query->execute([$id]);

if($line = $query->fetch()) { 
   ?>
    <div>
        <div><?= $line["login"]?></div>
        <div><?= $line["avatar"]?></div>
        <div><?= $line["description"]?></div>
    </div>
    <?php
}