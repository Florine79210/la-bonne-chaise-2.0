               <!-- NAVBAR -->
<!-- =========================================================================================================================================================================================================== -->

<nav class="navbar navbar-expand-lg fixed-top d-flex">

    <h1 class="ml-5">La Bonne Chaise</h1>

    <button class="navbar-toggler" id="hamburger" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
    </button>

    <div class="collapse navbar-collapse text-center" id="navbarNavAltMarkup">
        <div class="navbar-nav mr-4 ml-auto">
            <div class="row">
                <a class="nav-link mt-3 mr-2 ml-2" href="index.php"><span>Acceuil</span></a>
                <a class="nav-link mt-3 mr-2 ml-2" href="gammes.php"><span>Nos Gammes</span></a>
                <a class="nav-link mt-3 mr-2 ml-2" href="panier.php"><i class="fas fa-shopping-basket"></i><span class="quantite-panier">
                    (<?php if (isset($_SESSION["panier"])){
                        echo nbrArticlesPanier();} ?>)
                </span></a>

                <?php
                    if (isset ($_SESSION['email'])){

                        echo "<a class=\"nav-link mt-3 mr-2 ml-2\">
                                <form class=\"btnDeDeconnexion\" action=\"index.php\" method=\"post\">
                                    <i class=\"far fa-user\"></i>
                                    <input type=\"hidden\" name=\"btnDeconnexion\" value=\"true\">
                                    <input id=\"btnDeco\" style=\"border: none\" type=\"submit\" value=\" Déconnexion\">
                                </form>
                            </a>";

                    } else {
                        echo "<a class=\"nav-link mt-3 mr-2 ml-2\" href=\"connexion.php\"><i class=\"far fa-user\"></i><span class=\"btnConnexionInscription\"><br>Connexion/Inscription</span></a>";
                    }
                ?>

            </div>
            <div class="row mt-1 mr-3 ml-5 reseaux">
                <a class="nav-link mt-3" href="https://www.facebook.fr"><i class="fab fa-facebook-square"></i></a>
                <a class="nav-link mt-3" href="https://www.instagram.fr"><i class="fab fa-instagram"></i></a>
                <a class="nav-link mt-3" href="https://www.twitter.fr"><i class="fab fa-twitter-square"></i></a>
            </div>
            
        
        </div>
    </div>

</nav>
