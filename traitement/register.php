<?php
$pseudo = $_POST['login'];
$password = $_POST['mdp'];
$cpassword = $_POST['cmdp'];
$email = $_POST['email'];

if(!empty($pseudo) && !empty($password) && !empty($cpassword) && !empty($email)){
    if($password == $cpassword){
        $query = $pdo->prepare('INSERT INTO user(id, login, mdp, email, remember, avatar) VALUES(:id, :login, :mdp, :email, :remember, :avatar)');
        $query->execute(array(
            'id' => '',
            'login' => $pseudo,
            'mdp' => $password,
            'email' => $email,
            'remember' => '',
            'avatar' => ''));
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