               <!-- NAVBAR -->
<!-- =========================================================================================================================================================================================================== -->

<nav class="navbar navbar-expand-lg fixed-top d-flex">

    <h1 class="mr-4 ml-4">La Bonne Chaise</h1>

    <button class="navbar-toggler" id="hamburger" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
    </button>

    <div class="collapse navbar-collapse text-center" id="navbarNavAltMarkup">
        <div class="navbar-nav mr-auto ml-auto">
            <div class="row justify-content-center">
                <a class="nav-link mt-4 mr-1 ml-1" href="index.php"><i class="fas fa-store"></i><p>Boutique</p></a>
                <a class="nav-link mt-4 mr-1 ml-1" href="gammes.php"><i class="fas fa-chair"></i><p>Nos Gammes</p></a>
                <a class="nav-link mt-4 mr-1 ml-1" href="panier.php">
                    <i class="fas fa-shopping-basket"></i>
                    <p>Panier<span class="quantite-panier">
                        (<?php if (isset($_SESSION["panier"])){echo nbrArticlesPanier();} ?>)
                    </span></p>
                </a>

                <?php
                    if (isset ($_SESSION['email'])){

                        echo  "<a class=\"nav-link mt-4 mr-1 ml-1\" href=\"monCompte.php\"><i class=\"fas fa-user-circle\"></i><p>Mon compte</p></a>
                        
                            <a class=\"nav-link mt-4 mr-1 ml-1\">
                                <form action=\"index.php\" method=\"post\">
                                    <i class=\"fas fa-user-slash\"></i>
                                    <br>
                                    <input type=\"hidden\" name=\"btnDeconnexion\" value=\"true\">
                                    <input id=\"btnDeco\" style=\"border: none\" type=\"submit\" value=\" Déconnexion\">
                                </form>
                            </a>";

                    } else {
                        echo "<a class=\"nav-link mt-4 mr-1 ml-1\" href=\"connexion.php\"><i class=\"far fa-user\"></i><p>Connexion<br>Inscription</p></a>";
                    }
                ?>

            </div>

        </div>

        <div class="navbar-nav mr-4 ml-auto">
            <div class="row d-flex flex-nowrap justify-content-center reseaux">
                <a class="nav-link" href="https://www.facebook.fr"><i class="fab fa-facebook-square"></i></a>
                <a class="nav-link" href="https://www.instagram.fr"><i class="fab fa-instagram"></i></a>
                <a class="nav-link" href="https://www.twitter.fr"><i class="fab fa-twitter-square"></i></a>
            </div>
        </div>
            
        
        </div>
    </div>

</nav>
