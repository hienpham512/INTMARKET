<?php
    $bdd = $bdd = new PDO('mysql:host=localhost;dbname=intmarket','root','root');
    if(isset($_SESSION["idUtilisateur"])){
        $idUtilisateur = $_SESSION['idUtilisateur'];
        $reponde = $bdd->query("SELECT * FROM intmarket.utilisateur");
        while ($trouve = $reponde -> fetch()){
            if($idUtilisateur == $trouve['idUtilisateur'] && $trouve['role'] == "administrateur"){
                echo "<div class=\"dropdown\">
                            <button class=\"dropbtn\">BACK END  <img src=\"./vue/photo_specific/maison_loisirs.png\" width=\"30px\" height=\"30px\">
                            <i class=\"fa fa-caret-down\"></i>
                        </button>
                            <div class=\"dropdown-content\">
                                <a href=\"./index.php?action=back_endd\">test 2</a>

                            </div>
                        </div>";
            }
        }
    }
?>