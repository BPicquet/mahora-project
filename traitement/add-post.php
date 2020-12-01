<?php
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $idAmi = $_POST['profileId'];


    if(!empty($titre) && !empty($contenu)){
        $query = $pdo->prepare('INSERT INTO ecrit(titre, contenu, dateEcrit, idAuteur, idAmi) VALUES(:titre, :contenu, :dateEcrit, :idAuteur, :idAmi)');
        /* Post bug */
        $query->execute(array(
            'titre' => $titre,
            'contenu' => $contenu,
            'dateEcrit' => date('d-m-y h:i:s'),
            'idAuteur' => $_SESSION['id'],
            'idAmi' => $idAmi));
        header('Location: index.php?action=profile&id='.$idAmi);
        exit();   
    } 
    else{
        echo "Veuillez renseigner les champs";
    }
?>