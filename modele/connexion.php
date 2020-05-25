<?php
session_start();
session_destroy();
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=intmarket','root','root');

if(isset($_POST)){
    $donne = $_POST;
}
if(isset($donne['valider'])){
    $mail = strtolower($donne['mail']);
    $mdp = $donne['mdp'];
    $reponde = $bdd->query("SELECT mail,mdp,idUtilisateur FROM intmarket.utilisateur");
    if($donne['mdp'] == ''|| $donne['mail' == '']) {
        $erreur = "case_vide";
        $connexion = false;
        $id_utilisateur = '';
    }
    while($trouve = $reponde->fetch()){
        if($donne['mail'] == $trouve['mail'] && $donne['mdp'] == $trouve['mdp']){
            $connexion = true;
            $id_utilisateur = $trouve['idUtilisateur'];
            break;
        }else{
            $connexion = false;
            $erreur = "connexion";
            $id_utilisateur = '';
        }
    }
    if($connexion == false){
        header("location: ../index.php?action=formulaire_connexion&erreur=$erreur");
    }else{
        if(isset($donne['reconnexion'])){
            $_SESSION['idUtilisateur'] = $id_utilisateur;
            header("location: ../index.php?action=profil_utilisateur_courant");
        }else{
            $_SESSION['idUtilisateur'] = $id_utilisateur;
            header('location: ../index.php');
        }
    }
}else{
    header("location: ../index.php?action=formulaire_connexion");
}
?>