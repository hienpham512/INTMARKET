<?php
echo "<html><head><title>accueil</title></head><body><table border='0' width='100%' ><tr><th class='left_logo' width='50%' height='650px'>
<a href='/index.php'><img class='accueil_btn' src='./vue/photo_specific/logo_2.png' width='50%'></a><th>";
$erreur ='';
if(isset($_GET['erreur'])) {
    if ($_GET['erreur'] == "case_vide") {
        $erreur = "ERREUR : Il faut remplir tous les cases!";
    } elseif ($_GET['erreur'] == 'email_pris') {
        $erreur = "ERREUR : le mail a été utilisé par un autre utilisateur!";
    } elseif ($_GET['erreur'] == 'comf_mdp') {
        $erreur = "ERREUR : La comfirmation de mot de pass n'est pas dupliqué!";
    } else {
        $erreur = '';
    }
}
echo "<form action='./modele/inscription.php' method='POST'>";
echo "<label class='nom_projet'><h1>I N T ' M A R K E T</h1></label>";
echo "<p class='p'>Completer pour nous rejoindre, s'il vous plaît!</p>";
echo "<h4 class='erreur'>$erreur</h4>";
echo "<input type='text' name='nom'  placeholder='Nom' class='input' >             ";
echo "<input type='text' name='prenom' placeholder='Prénom' class='input'><br>";
echo "<input type='email' name='mail' placeholder='Email' class='input'><br>";
echo "<input type='text' name='addresse' placeholder='Addresse' class='input'><br>";
echo "<input type='password' name='mdp' placeholder='Mot de pass' class='input'><br>";
echo "<input type='password' name='comf_mdp' placeholder='Comfirmer mot de pass' class='input'><br>";
echo "<br><input type='submit' name='valider' value='valider' class='valider_btn'>";
echo "</form>";
echo "<br><br><br>
       <a href='./index.php?action=formulaire_connexion' class='retourner_btn'>Avez-vous déjà une compte? Connectez-vous.</a></form>";
echo "</tr></table></body></html>";
?>