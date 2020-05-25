<?php
echo "<html><head><title>accueil</title></head><body><table border='0' width='100%' ><tr><th class='left_logo' width='50%' height='650px'>
<a href='./index.php' ><img class='accueil_btn' src='./vue/photo_specific/logo_2.png' width='50%'></a><th>";
$erreur = '';
if(isset($_GET['erreur'])) {
    if($_GET['erreur'] =='connexion') {
        $erreur = "ERREUR : l'email ou le mot de pass n'est pas validé! ";
    }elseif ($_GET['erreur'] == "case_vide") {
        $erreur = "ERREUR : Il faut remplir tous les cases!";
    }elseif ($_GET['erreur'] =="reconnexion"){
        $erreur = "Reconnecter pour accèder à votre profil, s'il vous plaît!";
    }else {
        $erreur = '';
    }
}
echo "<form action='./modele/connexion.php' method='post'>";
if($erreur == "Reconnecter pour accèder à votre profil, s'il vous plaît!"){
    echo "<input type='hidden' name='reconnexion' value='reconnexion'>";
}
echo "<label class='nom_projet'><h1>I N T ' M A R K E T</h1></label>";
echo "<p class='p'>Connectez-vous, s'il vous plaît!</p>";
echo "<h4 class='erreur'>$erreur</h4>";
echo "<input type='email' name='mail' placeholder='Email' class='input'><br>";
echo "<input type='password' name='mdp' placeholder='Mot de pass' class='input'><br>";

echo "<br><input type='submit' name='valider' value='valider' class='valider_btn'>";
echo "</form>";
echo "<br><br><br><input type='hidden' name='connexion'><a href='./index.php?action=formulaire_inscription' class='retourner_btn'>N'avez-vous pas une compte? Inscirez-vous.</a></form>";
echo "</tr></table></body></html>";
?>
