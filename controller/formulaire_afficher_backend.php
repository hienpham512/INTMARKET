<div class='table_bdd'>
    <div class='table_bdd_contient' >
        <button onclick='afficher(1)'>ARTICLE</button>
        <button onclick='afficher(2)'>CATEGORIE</button>
        <button onclick='afficher(3)'>COMMANDE</button>
        <button onclick='afficher(4)'>UTILISATEUR</button>
    </div>
</div>

<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=intmarket', 'root', 'root');
if(isset($_SESSION["role"]) && $_SESSION["role"] == "administrateur") {
    if (isset($_GET['q'])) {
        $_SESSION['action_administrateur'] = $_GET['q'];
    } elseif (isset($_GET['table'])) {
        $table = $_GET['table'];
    }
}
if(isset($_SESSION['action_administrateur']) && isset($table)){
    $action_administrateur = $_SESSION['action_administrateur'];
    if($action_administrateur == 1 && $table == 1){
        $donne = $bdd -> query("SELECT * FROM intmarket.article");
        echo"<table border='1'><tr><th>idArticle<th>nomArticle<th>prixArticle<th>imageArticle<th>descriptionArticle<th>quantite<th>categorie_idCategorie</th></tr>";
        while ($trouve = $donne ->fetch() ){
            echo "<tr><td>". $trouve["idArticle"]. "<td>" .$trouve["nomArticle"]. "<td>" .$trouve["prixArticle"]."<td>" .$trouve["imageArticle"]."<td>" .$trouve["descriptionArticle"]."<td>" .$trouve["quantite"]."<td>" .$trouve["categorie_idCategorie"]."</td></tr>";
        }
    }elseif ($action_administrateur == 1 && $table == 2) {
        $donne = $bdd->query("SELECT * FROM intmarket.categorie");
        echo "<table border='1'><tr><th>idCategorie<th>nomCategorie<th>sousCategorie</th></tr>";
        while ($trouve = $donne->fetch()) {
            echo "<tr><td>" . $trouve["idCategorie"] . "<td>" . $trouve["nomCategoriecol"] . "<td>" . $trouve["sousCategorie"] ."</td></tr>";
        }
    }elseif ($action_administrateur == 1 && $table == 3) {
        $donne = $bdd->query("SELECT * FROM intmarket.commande");
        echo "<table border='1'><tr><th>idCommande<th>dateCommande<th>utilisateur_idUtilisateur</th></tr>";
        while ($trouve = $donne->fetch()) {
            echo "<tr><td>" . $trouve["idCommande"] . "<td>" . $trouve["dateCommande"] . "<td>" . $trouve["utilisateur_idUtilisateur"] ."</td></tr>";
        }
    }elseif($action_administrateur == 1 && $table == 4){
        $donne = $bdd -> query("SELECT * FROM intmarket.utilisateur");
        echo"<table border='1'><tr><th>idUtilisateur<th>nom<th>prenom<th>mail<th>mdp<th>addresse<th>panier<th>role</th></tr>";
        while ($trouve = $donne ->fetch() ){
            echo "<tr><td>". $trouve["idUtilisateur"]. "<td>" .$trouve["nom"]. "<td>" .$trouve["prenom"]."<td>" .$trouve["mail"]."<td>" .$trouve["mdp"]."<td>" .$trouve["addresse"]."<td>" .$trouve["panier"]."<td>" .$trouve["role"]."</td></tr>";
        }
        echo "</table>";
    }elseif ($action_administrateur == 2 && $table == 1){
        $donne = $bdd->query("SELECT * FROM intmarket.categorie");
        $nomCategories = array();
        $sousCategories = array();

        while ($trouve = $donne ->fetch()){
            $i = 0;
            while($i < count($nomCategories)){
                if($trouve['nomCategorie'] == $nomCategories[$i] ){
                    break;
                }else{
                    $i++;
                    continue;
                }
            }
            if($i >= count($nomCategories)) {
                $nomCategories[count($nomCategories)] = $trouve['nomCategoriecol'];
            }
            $j = 0;
            while ($j < count($sousCategories)){
                if($trouve['sousCategorie'] == $sousCategories[$j]){
                    break;
                }else{
                    $j++;
                    continue;
                }
            }
            if ($j >= count($sousCategories)){
                $sousCategories[count($sousCategories)] = $trouve['sousCategorie'];
            }
        }
        $select_sousCategorie = "<select name='idCategorie' >";
        $select_nomCategorie = "<select name='nomCategorie' >";
        for ($i = 0; $i < count($nomCategories); $i++){
            $select_nomCategorie .= "<option value='$nomCategories[$i]'>$nomCategories[$i]</option>";
        }
        for ($i = 0; $i < count($sousCategories); $i++){
            $select_sousCategorie .= "<option value='$sousCategories[$i]'>$sousCategories[$i]</option>";
        }
        $select_sousCategorie .= "</select>";
        $select_nomCategorie .= "</select>";
        echo "<div>
                <form action='/modele/backend.php' method='post'><br>
                <label>nomArticle : </label></label><input type='text' name='nomArticle'><br>
                <label>prixArticle : </label><input type='number' min='1' name='prixArticle'><br>
                <label>imageArticle: </label><input type='text' name='imageArticle'><br>
                <label>descriptionArticle: </label><input type='text' name='descriptionArticle'><br>
                <label>quantite: </label><input type='number' min='1' name='quantite'><br>
                <label>nomCategorie: </label>$select_nomCategorie
                <label>sousCategorie: </label>$select_sousCategorie<br>
                <input type='submit' name='action' value='insérer'>
                <input type='hidden' name='table' value='article'>
</form>
</div>";
    }elseif ($action_administrateur == 2 && $table == 2){
        echo "<div>
                <form action='/modele/backend.php' method='post'>
                <select name='nomCategorie'>
                <option value='courses'>COURSES</option>
                <option value='mode'>MODE</option>
                <option value='maison_loisir'>MAISON ET LOISIR</option>
                <option value='animal'>ANIMAL</option>
                </select>
                <input type='text' name='sousCategorie'>
                <input type='submit' name='action' value='insérer'>
                <input type='hidden' name='table' value='categorie'>
</form>
</div>";
    }elseif ($action_administrateur == 2 && $table == 3){
        echo "<div>
                <form action='/modele/backend.php' method='post'>
                <label>dateCommande</label><input type='date'>
                <input type='number' name='idUtilisateur' min='1'>
                <input type='submit' name='action' value='insérer'>
                <input type='hidden' name='table' value='commande'>
                </form>
</div>";
    }elseif ($action_administrateur == 2 && $table == 4){
        echo "<div>
                <form action='/modele/backend.php' method='post'>
                <label>nom : </label><input type='text' name='nom'><br>
                <label>prenom : </label><input type='text' name='prenom'><br>
                <label>email : </label><input type='text' name='mail'><br>
                <label>mot de pass : </label><input type='text' name='mdp'><br>
                <label>addresse : </label><input type='text' name='addresse'><br>
                <label>panier : </label><input type='text' name='panier'><br>
                <label>role : </label><input type='text' name='role'><br>
                <input type='hidden' name='table' value='utilisateur'>
                <input type='submit' name='action' value='insérer'>

</div>";
    }elseif ($action_administrateur == 3 && $table == 1){
        $donne = $bdd -> query("SELECT * FROM intmarket.article");
        echo"<table border='1'><tr><th>idArticle<th>nomArticle<th>prixArticle<th>imageArticle<th>descriptionArticle<th>quantite<th>categorie_idCategorie<th>action</th></tr>";
        while ($trouve = $donne ->fetch() ){
            echo "<tr><td>". $trouve["idArticle"]. "<td>" .$trouve["nomArticle"]. "<td>" .$trouve["prixArticle"]."<td>" .$trouve["imageArticle"]."<td>" .$trouve["descriptionArticle"]."<td>" .$trouve["quantite"]."<td>" .$trouve["categorie_idCategorie"]."<td>"."<a href='/modele/backend.php'>modifier</a>"."</td></tr>";
        }
    }elseif ($action_administrateur == 3 && $table == 2) {
        $donne = $bdd->query("SELECT * FROM intmarket.categorie");
        echo "<table border='1'><tr><th>idCategorie<th>nomCategorie<th>sousCategorie<th>action</th></tr>";
        while ($trouve = $donne->fetch()) {
            echo "<tr><td>" . $trouve["idCategorie"] . "<td>" . $trouve["nomCategoriecol"] . "<td>" . $trouve["sousCategorie"] ."<td>"."<a href='/modele/backend.php'>modifier</a>"."</td></tr>";
        }
    }elseif ($action_administrateur == 3 && $table == 3) {
        $donne = $bdd->query("SELECT * FROM intmarket.commande");
        echo "<table border='1'><tr><th>idCommande<th>dateCommande<th>utilisateur_idUtilisateur<th>action</th></tr>";
        while ($trouve = $donne->fetch()) {
            echo "<tr><td>" . $trouve["idCommande"] . "<td>" . $trouve["dateCommande"] . "<td>" . $trouve["utilisateur_idUtilisateur"] ."<td>"."<a href='/modele/backend.php'>modifier</a>"."</td></tr>";
        }
    }elseif($action_administrateur == 3 && $table == 4) {
        $donne = $bdd->query("SELECT * FROM intmarket.utilisateur");
        echo "<table border='1'><tr><th>idUtilisateur<th>nom<th>prenom<th>mail<th>mdp<th>addresse<th>panier<th>role<th>action</th></tr>";
        while ($trouve = $donne->fetch()) {
            echo "<tr><td>" . $trouve["idUtilisateur"] . "<td>" . $trouve["nom"] . "<td>" . $trouve["prenom"] . "<td>" . $trouve["mail"] . "<td>" . $trouve["mdp"] . "<td>" . $trouve["addresse"] . "<td>" . $trouve["panier"] . "<td>" . $trouve["role"] . "<td>" . "<a href='/modele/backend.php'>supprimer</a>" . "</td></tr>";
        }
    }elseif ($action_administrateur == 4 && $table == 1){
        $donne = $bdd -> query("SELECT * FROM intmarket.article");
        echo"<table border='1'><tr><th>idArticle<th>nomArticle<th>prixArticle<th>imageArticle<th>descriptionArticle<th>quantite<th>categorie_idCategorie<th>action</th></tr>";
        while ($trouve = $donne ->fetch() ){
            echo "<tr><td>". $trouve["idArticle"]. "<td>" .$trouve["nomArticle"]. "<td>" .$trouve["prixArticle"]."<td>" .$trouve["imageArticle"]."<td>" .$trouve["descriptionArticle"]."<td>" .$trouve["quantite"]."<td>" .$trouve["categorie_idCategorie"]."<td>"."<a href='/modele/backend.php'>supprimer</a>"."</td></tr>";
        }
    }elseif ($action_administrateur == 4 && $table == 2) {
        $donne = $bdd->query("SELECT * FROM intmarket.categorie");
        echo "<table border='1'><tr><th>idCategorie<th>nomCategorie<th>sousCategorie<th>action</th></tr>";
        while ($trouve = $donne->fetch()) {
            echo "<tr><td>" . $trouve["idCategorie"] . "<td>" . $trouve["nomCategoriecol"] . "<td>" . $trouve["sousCategorie"] ."<td>"."<a href='/modele/backend.php'>supprimer</a>"."</td></tr>";
        }
    }elseif ($action_administrateur == 4 && $table == 3) {
        $donne = $bdd->query("SELECT * FROM intmarket.commande");
        echo "<table border='1'><tr><th>idCommande<th>dateCommande<th>utilisateur_idUtilisateur<th>action</th></tr>";
        while ($trouve = $donne->fetch()) {
            echo "<tr><td>" . $trouve["idCommande"] . "<td>" . $trouve["dateCommande"] . "<td>" . $trouve["utilisateur_idUtilisateur"] ."<td>"."<a href='/modele/backend.php'>supprimer</a>"."</td></tr>";
        }
    }elseif($action_administrateur == 4 && $table == 4) {
        $donne = $bdd->query("SELECT * FROM intmarket.utilisateur");
        echo "<table border='1'><tr><th>idUtilisateur<th>nom<th>prenom<th>mail<th>mdp<th>addresse<th>panier<th>role<th>action</th></tr>";
        while ($trouve = $donne->fetch()) {
            echo "<tr><td>" . $trouve["idUtilisateur"] . "<td>" . $trouve["nom"] . "<td>" . $trouve["prenom"] . "<td>" . $trouve["mail"] . "<td>" . $trouve["mdp"] . "<td>" . $trouve["addresse"] . "<td>" . $trouve["panier"] . "<td>" . $trouve["role"] . "<td>" . "<a href='/modele/backend.php'>supprimer</a>" . "</td></tr>";
        }
    }

}
?>

