<?php
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $id = $_GET["id"];

    if(!empty($titre) && !empty($contenu)){
        $query = $pdo->prepare('INSERT INTO ecrit(titre, contenu, idAuteur, idAmi) VALUES(:titre, :contenu, :idAuteur, :idAmi)');
        $query->execute(array(
            'titre' => $titre,
            'contenu' => $contenu,
            'idAuteur' => $id,
            'idAmi' => $id));
        echo "Votre compte à été créé";
        header('Location: index.php?action=accueil');
        exit();   
        
    } 
    else{
        echo "Veuillez renseigner les champs";
    }
?>