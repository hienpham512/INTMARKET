<?php
session_start();
session_destroy();
session_start();
var_dump($_SESSION);
if (isset($_GET)) {
    if ($_GET['action'] == "deconnecter") {
        session_destroy();
        header("location: ../index.php");
    } elseif ($_GET['action'] == "votre_compte") {
        if (!isset($_SESSION['idUtilisateur'])) {
            header("location: ../index.php?action=formulaire_connexion&erreur=reconnexion");
        } else {

        }
    }

}
?>