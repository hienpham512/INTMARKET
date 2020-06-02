<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=intmarket', 'root', 'root');

if(isset($_POST) && isset($_SESSION['role']) && $_SESSION['role'] == 'administrateur'){
    //mettre le numéro pour les tables.
    if($_SESSION['table_courant'] == "article"){
        $table = 1;
    }elseif ($_SESSION['table_courant'] == "categorie"){
        $table = 2;
    }elseif ($_SESSION['table_courant'] == "commande"){
        $table = 3;
    }elseif ($_SESSION['table_courant'] == "utilisateur"){
        $table = 4;
    }
    echo "<br>";
    //si la table qu'il veux modifier est "article".
    if(isset($_POST['modifier']) && $_SESSION["table_courant"] == "article") {
        $idArticle = intval($_POST['idArticle']);
        $nomArticle = $_POST['nomArticle'];
        $prixArticle = intval($_POST['prixArticle']);
        $descriptionArticle = $_POST['descriptionArticle'];
        $imageArticle = $_POST['imageArticle'];
        $quantite = intval($_POST['quantite']);
        $categorie_idCategorie = intval($_POST['categorie_idCategorie']);

        //$donne = $bdd -> query("SELECT * FROM intmarket.article");


        $sql = "UPDATE intmarket.article SET nomArticle = '$nomArticle',
                             prixArticle = '$prixArticle',
                             descriptionArticle = '$descriptionArticle',
                             imageArticle = '$imageArticle',
                             quantite = '$quantite',
                             categorie_idCategorie = '$categorie_idCategorie'
                            WHERE article.idArticle = '$idArticle';";

        //Verifier si la requete "update" a été correctement executée.
    if($bdd ->exec($sql) == true){
            $status = "succes";
        }else{
            $status = "erreur";
        }
//si la table qu'il veux modifier est "categorie".
    }elseif (isset($_POST['modifier']) && $_SESSION["table_courant"] == "categorie"){
        $idCategorie = intval($_POST['idCategorie']);
        $nomCategorie = $_POST['nomCategorie'];
        $sousCategorie = $_POST['sousCategorie'];

        //vérifier s'il a choisi correct le sousCategori avec nomCategorie
        $donne = $bdd ->query("SELECT * FROM intmarket.categorie");
        while ($trouve = $donne -> fetch()){
            if($trouve['idCategorie'] == $idCategorie){
                $sql = "UPDATE intmarket.categorie SET
                               nomCategorie = '$nomCategorie',
                               sousCategorie = '$sousCategorie'
                               WHERE categorie.idCategorie = '$idCategorie';";
                if($bdd ->exec($sql) == true){
                    $status = "succes";
                }else{
                    $status = "erreur";
                }
                break;
            }
        }
        //si la table qu'il veux modifier est "commande".
    }elseif (isset($_POST['modifier']) && $_SESSION["table_courant"] == "commande"){
        $idCommande = intval($_POST['idCommande']);
        $dateCommande = $_POST['dateCommande'];
        $utilisateur_idUtilisateur = intval($_POST['utilisateur_idUtilisateur']);
        $sql = "UPDATE intmarket.commande SET
                               dateCommande = '$dateCommande',
                               utilisateur_idUtilisateur = '$utilisateur_idUtilisateur'
                               WHERE commande.idCommande = '$idCommande';";
        if($bdd ->exec($sql) == true){
            $status = "succes";
        }else{
            $status = "erreur";
        }
        //si la table qu'il veux modifier est "utilisatuer".
    }elseif (isset($_POST['modifier']) && $_SESSION["table_courant"] == "utilisateur"){
        $idUtilisateur = intval($_POST['idUtilisateur']);
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];
        $mdp = $_POST['mdp'];
        $panier = $_POST['panier'];
        $role = $_POST['role'];
        $addresse = $_POST['addresse'];

        //verifier si le mail est été pris par un autre utilisateur.
        $donne = $bdd ->query("SELECT * FROM intmarket.utilisateur");
        while ($trouve = $donne ->fetch()){
            if($trouve['mail'] == $mail && intval($trouve['idUtilisateur']) !== intval($idUtilisateur)){
                $status = false;
                $erreur = "mail";
                break;
            }
        }
        if (!isset($status)){
            $sql = "UPDATE intmarket.utilisateur SET 
                                 nom = '$nom',
                                 prenom = '$prenom',
                                 mail = '$mail',
                                 mdp = '$mdp',
                                 panier = '',
                                 addresse = '$addresse',
                                 role = '$role'
                                 WHERE utilisateur.idUtilisateur = '$idUtilisateur';";
            if($bdd ->exec($sql) == true){
                $status = "succes";
            }else{
                $status = "erreur";
            }
        }
    }elseif (isset($_POST['supprimer']) && $_SESSION['table_courant'] == "article"){
        $idArticle = intval($_POST["idArticle"]);
        $sql = "DELETE FROM intmarket.article WHERE idArticle = '$idArticle';";
        if($bdd ->exec($sql) == true){
            $status = "succes";
        }else{
            $status = "erreur";
        }
        //il y a encore de faut , ne peut pas de supprimer, $idCategorie est tj 2.
    }elseif (isset($_POST['supprimer']) && $_SESSION['table_courant'] == "categorie"){
        $idCategorie = intval($_POST["idCategorie"]);
        $sql = "DELETE FROM intmarket.categorie WHERE idCategorie = '$idCategorie';";
        if($bdd ->exec($sql) == true){
            $status = "succes";
        }else{
            $status = "erreur";
        }
    }elseif (isset($_POST['supprimer']) && $_SESSION['table_courant'] == "commande"){
        $idCommande = intval($_POST["idCommande"]);
        $sql = "DELETE FROM intmarket.commande WHERE idCommande = '$idCommande';";
        if($bdd ->exec($sql) == true){
            $status = "succes";
        }else{
            $status = "erreur";
        }
    }elseif (isset($_POST['supprimer']) && $_SESSION['table_courant'] == "utilisateur"){
        $idUtilisateur = intval($_POST["idUtilisateur"]);
        $sql = "DELETE FROM intmarket.utilisateur WHERE idUtilisateur = '$idUtilisateur';";
        if($bdd ->exec($sql) == true){
            $bdd ->query($sql);
            $status = "succes";
        }else{
            $status = "erreur";
        }

    }elseif (isset($_POST['ajouter']) && $_SESSION['table_courant'] == 'article'){
        foreach ($_POST as $key => $value) {
            $value = str_split($value);
            $compteur = 0;
            for($i = 0; $i < count($value); $i++){
                if($value[$i] !== " " || $value[$i] !== "   "){
                    $compteur++;
                }
            }
            if($compteur == 0){
                $erreur = "case_vide";
                break;
            }
        }
        if(!isset($erreur)){
            $nomArticle = $_POST['nomArticle'];
            $prixArticle = intval($_POST['prixArticle']);
            $descriptionArticle = $_POST['descriptionArticle'];
            $imageArticle = $_POST['imageArticle'];
            $quantite = intval($_POST['quantite']);
            $nomCategorie = $_POST['nomCategorie'];
            $sousCategorie = $_POST['sousCategorie'];

            $donne = $bdd ->query("SELECT * FROM intmarket.categorie");
            while ($trouve = $donne ->fetch()){
                if($trouve['sousCategorie'] == $sousCategorie && $trouve['nomCategorie'] == $nomCategorie){
                    $categorie_idCategorie = $trouve['idCategorie'];
                    $idCategorie_trouve = true;
                    $sql = "INSERT INTO intmarket.article
                            (nomArticle, prixArticle, imageArticle, descriptionArticle, quantite, categorie_idCategorie) VALUES 
                            ('$nomArticle','$prixArticle','$imageArticle','$descriptionArticle','$quantite','$categorie_idCategorie')";
                    if($bdd ->exec($sql) == true){
                        $status = "succes";
                    }else{
                        $status = "erreur";
                    }
                    break;
                }else{
                    $idCategorie_trouve = false;
                    $status = 'erreur';
                }
            }
        }
    }elseif (isset($_POST['ajouter']) && $_SESSION['table_courant'] == 'categorie'){
        foreach ($_POST as $key => $value) {
            $value = str_split($value);
            $compteur = 0;
            for($i = 0; $i < count($value); $i++){
                if($value[$i] !== " " || $value[$i] !== "   "){
                    $compteur++;
                }
            }
            if($compteur == 0){
                $erreur = "case_vide";
                break;
            }
        }
        if(!isset($erreur)){
            $nomCategorie = $_POST['nomCategorie'];
            $sousCategorie = $_POST['sousCategorie'];
            $sql = "INSERT INTO intmarket.categorie(nomCategorie, sousCategorie) VALUES ('$nomCategorie','$sousCategorie')";
            if($bdd ->exec($sql) == true){
                $status = "succes";
            }else{
                $status = "erreur";
            }
        }
    }elseif (isset($_POST['ajouter']) && $_SESSION['table_courant'] == 'commande'){
        foreach ($_POST as $key => $value) {
            $value = str_split($value);
            $compteur = 0;
            for($i = 0; $i < count($value); $i++){
                if($value[$i] !== " " || $value[$i] !== "   "){
                    $compteur++;
                }
            }
            if($compteur == 0){
                $erreur = "case_vide";
                break;
            }
        }
        if(!isset($erreur)){
            $dateCommande = $_POST['date'];
            $idUtilisateur = $_POST['idUtilisateur'];
            $sql = "INSERT INTO intmarket.commande(dateCommande, utilisateur_idUtilisateur) VALUES ('$dateCommande', '$idUtilisateur')";
            if($bdd ->exec($sql) == true){
                $status = "succes";
            }else{
                $status = "erreur";
            }
        }

    }elseif (isset($_POST['ajouter']) && $_SESSION['table_courant'] == 'utilisateur'){
        foreach ($_POST as $key => $value) {
            $value = str_split($value);
            $compteur = 0;
            for($i = 0; $i < count($value); $i++){
                if($value[$i] !== " " || $value[$i] !== "   "){
                    if($key !== 'panier'){
                        $compteur++;
                    }
                }
            }
            if($compteur == 0){
                $erreur = "case_vide";
                break;
            }
        }
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];
        $mdp = $_POST['mdp'];
        $panier = $_POST['panier'];
        $role = $_POST['role'];
        $addresse = $_POST['addresse'];
        $donne = $bdd ->query("SELECT * FROM intmarket.utilisateur");
        while ($trouve = $donne ->fetch()){
            if($trouve['mail'] == $mail){
                $status = false;
                $erreur = "mail";
                break;
            }
        }
        if(!isset($erreur) || !isset($status)){
            $sql = "INSERT INTO intmarket.utilisateur
                (nom, prenom, mail, mdp, addresse, panier, role)
                 VALUES ('$nom','$prenom','$mail','$mdp','$addresse','$panier','$role');";
            if($bdd ->exec($sql) == true){
                $status = "succes";
            }else{
                $status = "erreur";
            }
        }

    }
    var_dump($status);
    if($status == 'succes'){
        header("location: ../index.php?action=backend");
    }elseif ($status == 'erreur'){

    }
}
?>