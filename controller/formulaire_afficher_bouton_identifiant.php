<?php
if (!isset($_SESSION['idUtilisateur'])) {
    echo "<div class='dropdown'>
            <button class='dropbtn'><img src='./vue/photo_specific/photo_identifiant.png' width='100px'; height='30px'; class='photo_identifiant'>
                <i class='fa fa-caret-down'></i>
            </button>
            <div class='dropdown-content'>
                <a href='./index.php?action=formulaire_connexion' >connexion</a>
                <a href='./index.php?action=formulaire_inscription' >inscription</a>
            </div>
        </div>";
} else {
    $id = $_SESSION['idUtilisateur'];
    $bdd = new PDO('mysql:host=localhost;dbname=intmarket', 'root', 'root');
    $reponde = $bdd->query("SELECT * FROM intmarket.utilisateur WHERE idUtilisateur = $id");
    while ($trouve = $reponde->fetch()) {
        $nom = $trouve['nom'];
        $prenom = $trouve['prenom'];
        $role = $trouve['role'];
    }
    if($role == "administrateur"){
        $bouton_backend = "<a href='/index.php?action=backend'>Back-end</a>";
        $_SESSION["role"] = "administrateur";
    }else{
        $bouton_backend = "";
    }
    echo "<div class='dropdown'>
            <button class='dropbtn'><img src='./vue/photo_specific/photo_identifiant.png' width='100px'; height='30px' class='photo_identifiant'>
                <i class='fa fa-caret-down'></i><br>$nom $prenom 
            </button>

            <div class='dropdown-content'>
                <a href='./controller/profil_utilisateur_courant.php?action=votre_compte' >Votre compte</a>
                <a href='./controller/profil_utcilisateur_courant.php?action=votre_commande' >Votre commande</a>
                $bouton_backend
                <a href='./controller/profil_utilisateur_courant.php?action=deconnecter' >Déconnecter <img src='./vue/photo_specific/deconnecter.png' width='15px'; height='15px'></a>
            </div>
          </div>";
}
?>