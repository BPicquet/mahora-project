<?php
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $id = $_SESSION['id'];
    $date = date('d-m-y h:i:s');

    if(!empty($titre) && !empty($contenu)){
        $query = $pdo->prepare('INSERT INTO ecrit(titre, contenu, dateEcrit, idAuteur, idAmi) VALUES(:titre, :contenu, :dateEcrit, :idAuteur, :idAmi)');
        $query->execute(array(
            'titre' => $titre,
            'contenu' => $contenu,
            'dateEcrit' => $date,
            'idAuteur' => $id,
            'idAmi' => $id));
        header('Location: index.php?action=accueil');
        exit();   
    } 
    else{
        echo "Veuillez renseigner les champs";
    }
?>