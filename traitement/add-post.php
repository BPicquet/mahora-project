<?php
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $idAmi = $_POST['profile-id'];
    $img = $_POST['add-img']['tmp_name'];

    if(!empty($titre) && !empty($contenu)){
        $query = $pdo->prepare('INSERT INTO ecrit(titre, contenu, dateEcrit, image, idAuteur, idAmi) VALUES(:titre, :contenu, :dateEcrit, :image, :idAuteur, :idAmi)');
        $query->execute(array(
            'titre' => $titre,
            'contenu' => $contenu,
            'dateEcrit' => date('d-m-y h:i:s'),
            'image' => $img,
            'idAuteur' => $_SESSION['id'],
            'idAmi' => $idAmi));
        header('Location: index.php?action=profile&id='.$idAmi);
        exit();   
    } 
    else{
        echo "Veuillez renseigner les champs";
    }
?>