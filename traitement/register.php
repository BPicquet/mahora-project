<?php
$pseudo = $_POST['login'];
$password = $_POST['mdp'];
$cpassword = $_POST['cmdp'];
$email = $_POST['email'];

if(!empty($pseudo) && !empty($password) && !empty($cpassword) && !empty($email)){
    if($password == $cpassword){
        $query = $pdo->prepare('INSERT INTO user(login, mdp, email) VALUES(:login, :mdp, :email)');
        $query->execute(array(
            'login' => $pseudo,
            'mdp' => sha1($password),
            'email' => $email));
        echo "Votre compte à été créé";
    } 
    else{
        echo "Les mots de passes ne sont pas identiques";
    }
} 
else{
    echo "Veuillez renseigner les champs";
}

?>