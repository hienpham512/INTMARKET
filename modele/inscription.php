<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=intmarket', 'root', 'root');

$donne = $_POST;
if (isset($donne['valider'])) {
    $mail = strtolower($donne['mail']);
    $mdp = $donne['mdp'];
    $nom = $donne['nom'];
    $prenom = $donne['prenom'];
    $addresse = $donne['addresse'];

    $inscription = true;

    $reponde = $bdd->query("SELECT mail FROM intmarket.utilisateur");
    if ($donne['mail'] == '' || $donne['mdp'] == '' || $donne['comf_mdp'] == '' || $donne['nom'] == '' || $donne['addresse'] == '' || $donne['nom'] == '' || $donne['prenom' == '']) {
        $erreur = "case_vide";
        $inscription = false;
    }else{
        while ($trouve = $reponde->fetch()) {
            if ($donne['mail'] == $trouve['mail']) {
                $erreur = "email_pris";
                $inscription = false;
                break;
            } elseif ($donne['mdp'] !== $donne['comf_mdp']) {
                $erreur = 'comf_mdp';
                $inscription = false;
                break;
            } elseif ($donne['mail'] !== $trouve['mail'] && $donne['mdp'] == $donne['comf_mdp']) {
                $inscription = true;
            }
        }
    }

    if ($inscription == false) {

        header("location: ../index.php?action=formulaire_inscription&erreur=$erreur");
    } else {
        $requete = $bdd->prepare("INSERT INTO intmarket.utilisateur(`nom`,`prenom`,`mail`,`mdp`,`addresse`,`panier`,`role`) VALUES (?,?,?,?,?,?,?)");
        $requete->execute(array($nom, $prenom, $mail, $mdp, $addresse, '', "client"));
        $reponde = $bdd->query("SELECT idUtilisateur,mail FROM intmarket.utilisateur");
        while ($trouve = $reponde->fetch()) {
            if ($trouve['mail'] == $mail) {
                $_SESSION['idUtilisateur'] = $trouve['idUtilisateur'];
            }
        }
        header('location: ../index.php?');
    }
} else {
    header("location: ../index.php?action=formulaire_inscription");
}
?>