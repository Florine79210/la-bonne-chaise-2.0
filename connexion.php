<?php
    session_start();
    include('functions.php');

    if(isset($_POST['inscription'])){
        inscription();
    }
?>

<!DOCTYPE html>
    <html lang="fr">

        <head>
        
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

            <title>La Bonne Chaise</title>

            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0/css/all.min.css">
            <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet"> 

            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
            <link rel="stylesheet" href="ressources/css/connexion-inscription.css">
            <link rel="stylesheet" href="ressources/css/style.css">

        </head>

        <body>

            <header>

                <?php include("navbar.php"); ?>

            </header>

            <main>

                <div class="container mb-5">
                    <div class="row justify-content-center">
                        <i class="far fa-user"></i>
                    </div>
                    
                    <div class="row justify-content-center">
                        <h2>Connexion</h2>
                    </div>
                </div>

                <div class="container mb-5">
                    <div class="row justify-content-center formulaires formulaire-connexion">
                        <form action="index.php" method="post">
        
                            <div class="row mt-3 justify-content-end">
                                <p class="mr-2">Email : </p>
                                <input class="text-center" type="email" name="email" placeholder="Votre Email @" required>
                            </div>
        
                            <div class="row justify-content-end">
                                <p class="mr-2">Mot de passe : </p>
                                <input class="text-center" type="password" name="motDePasse" placeholder="Votre mot de passe" required>
                            </div>
        
                            <div class="row justify-content-end">
                                <p class="mr-2">Mot de passe : </p>
                                <input class="text-center" type="password" name="motDePasse2" placeholder="Confirmez le M.D.P" required>
                            </div>
        
                            <div class="row mt-3 justify-content-center">
                                <button class="mb-3 pt-1 pr-2 pb-1 pl-2 btns btnConnexion" type="submit" name="connexion" required> Connexion </button>
                            </div>
        
                        </form>   
                    </div>
                </div>

                <div class="container">
                    <div class="row mt-3 justify-content-center important">
                        <p>Pas encore inscrit ?</p>
                    </div>

                    <div class="row justify-content-center important">
                        <p>Inscrivez vous !</p>
                    </div>

                    <div class="row justify-content-center">
                        <a href="inscription.php">
                            <button class="mb-5 pt-1 pr-2 pb-1 pl-2 btns btnInscription">Inscription</button>
                        </a>
                    </div>
                </div>

            </main>

            <footer>

                <?php include("footer.php"); ?>

            </footer>
        
        </body>

<!-- BOOTSTRAP -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    </html>