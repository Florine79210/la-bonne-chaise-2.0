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
                <a class="nav-link mr-2 ml-2" href="index.php"><span>Acceuil</span></a>
                <a class="nav-link mr-2 ml-2" href="panier.php"><i class="fas fa-shopping-basket"></i><span class="quantite-panier"> (<?php echo nbrArticlesPanier(); ?>)</span></a>
            </div>
            <div class="row mt-1 mr-3 ml-5 reseaux">
                <a class="nav-link" href="https://www.facebook.fr"><i class="fab fa-facebook-square"></i></a>
                <a class="nav-link" href="https://www.instagram.fr"><i class="fab fa-instagram"></i></a>
                <a class="nav-link" href="https://www.twitter.fr"><i class="fab fa-twitter-square"></i></a>
            </div>
            
        
        </div>
    </div>

</nav>
