<?php
    session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=intmarket', 'root', 'root');

    if(isset($_SESSION["idUtilisateur"])){
        $reponde = $bdd -> query("SELECT * FROM intmarket.utilisateur");
    }
?>
