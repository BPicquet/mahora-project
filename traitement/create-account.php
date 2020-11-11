<?php
$sql = "INSERT INTO user(pseudo, pass, email) VALUES(:pseudo, :pass, :email)";

$req = $bdd->prepare($sql);

$req->execute(array(
    'pseudo' => $_POST['login'],
    'pass' => $_POST['mdp'],
    'email' => $_POST['email']));

if(isset($_POST))
?>