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
                <a class="nav-link mt-4 mr-2 ml-2" href="index.php"><i class="fas fa-store"></i><p>Boutique</p></a>
                <a class="nav-link mt-4 mr-2 ml-2" href="gammes.php"><i class="fas fa-chair"></i><p>Nos Gammes</p></a>
                <a class="nav-link mt-4 mr-2 ml-2" href="panier.php">
                    <i class="fas fa-shopping-basket"></i>
                    <p>Panier<span class="quantite-panier">
                        (<?php if (isset($_SESSION["panier"])){echo nbrArticlesPanier();} ?>)
                    </span></p>
                </a>

                <?php
                    if (isset ($_SESSION['email'])){

                        echo  "<a class=\"nav-link mt-4 mr-2 ml-2\" href=\"monCompte.php\"><i class=\"fas fa-user-circle\"></i><p>Mon compte</p></a>
                        
                            <a class=\"nav-link mt-4 mr-2 ml-2\">
                                <form action=\"index.php\" method=\"post\">
                                    <i class=\"fas fa-user-slash\"></i>
                                    <br>
                                    <input type=\"hidden\" name=\"btnDeconnexion\" value=\"true\">
                                    <input id=\"btnDeco\" style=\"border: none\" type=\"submit\" value=\" Déconnexion\">
                                </form>
                            </a>";

                    } else {
                        echo "<a class=\"nav-link mt-4 mr-2 ml-2\" href=\"connexion.php\"><i class=\"far fa-user\"></i><p>Connexion/Inscription</p></a>";
                    }
                ?>

            </div>
            <div class="row mt-1 mr-3 ml-5 reseaux">
                <a class="nav-link mt-4" href="https://www.facebook.fr"><i class="fab fa-facebook-square"></i></a>
                <a class="nav-link mt-4" href="https://www.instagram.fr"><i class="fab fa-instagram"></i></a>
                <a class="nav-link mt-4" href="https://www.twitter.fr"><i class="fab fa-twitter-square"></i></a>
            </div>
            
        
        </div>
    </div>

</nav>
