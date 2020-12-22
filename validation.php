<?php

    session_start();
    include('functions.php');

    if (isset ($_POST['idModifierQuantite'])){
        modifierQuantite();
    }

    if (isset ($_POST['idSupprimerArticle'])){
        supprArticle();
    }

    if (isset ($_POST['modifierInfosPageValidation'])){
        modificationInfosClientPageValidation();
    }

    if (isset ($_POST["annulerCommande"])){
        $_SESSION['panier'] = array();
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
            <link rel="stylesheet" href="ressources/css/validation.css">
            <link rel="stylesheet" href="ressources/css/style.css">
        
        </head>

        <body>

            <header>

                <?php include("navbar.php"); ?>

            </header>

            <main>

                <?php
                    showPanier("validation.php");
                ?>

                <div class="container infosPanierEtModifInfos">
                    <div class="row">

                        <div class="col-lg-6 text-center">
                            <?php
                                affichageTotalPrixArticles();
                                affichageTotalFraisPort();
                                affichageTotalARegler();
                            ?>
                        </div>

                        <div class="col-lg-6 text-center">
                            <?php
                            if (isset($_SESSION['email'])) {
                                affichageDeSInfosClientPageValidation($_SESSION['id']);
                            }
                            ?>
                        </div>

                    </div>
                </div>

                <div class="container mt-5 mb-5 valider_vider_panier">
                    <div class="row">

                        <div class="col-md-6 text-center">

    <!-- BTN VALIDER LA COMMANDE -->
<!-- ---------------------------------------------------------------------------------------------------------------------------------------- -->
                            <?php
                            if (isset($_SESSION['email'])) {
                            ?>
                            <button type="button" class="btn btns2 btns_V_A btn_valider" data-toggle="modal" data-target="#modalValidation">
                            Valider la commande
                            </button>

                            <div class="modal" id="modalValidation" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="mt-3 modal-header-center">
                                            <h5 class="modal-title">Félicitation !</h5>
                                        </div>

                                        <div class="modal-body text-center">
                                            <p>La commande à été <span>validée</span>.</p>
                                            <br>
                                            <?php echo "<p>Votre commande sera expédié <br> le <span>". date('d-m-Y', strtotime(date('d-m-Y') . ' + 3 days')). "</span></p>"?>
                                        </div>

                                        <div class="modal-footer d-flex justify-content-center">
                                            <form action="index.php" method="post">
                                                <input type="hidden" name="validerCommande">
                                                <button type="submit" class="btn btns btn-valider-accueil">Revenir à l'Accueil</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <?php } else {
                               echo " <a type=\"button\" class=\"btn btns2 btns_V_A btn_valider\" href=\"connexion.php\">Connectez vous pour continuer</a>";
                            }  ?>          

                        </div>


    <!-- BTN ANNULER LA COMMANDE -->
<!-- ---------------------------------------------------------------------------------------------------------------------------------------- -->

                        <div class="col-md-6 text-center">

                            <button type="button" class="btn btns2 btns_V_A btn_annuler" data-toggle="modal" data-target="#modalAnnulation">
                            Annuler la commande
                            </button>

                            <div class="modal" id="modalAnnulation" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="mt-3 modal-header-center">
                                            <h5 class="modal-title"> ! Attention !</h5>
                                        </div>

                                        <div class="modal-body-center">
                                            <p>Êtes-vous sûr de vouloir<br><span>ANNULER</span> la commande ?</p>
                                        </div>

                                        <div class="modal-footer d-flex justify-content-center">

                                            <form action="validation.php" method="post">
                                                <input type="hidden" name="nePasAnnulerCommande">
                                                <button type="submit" class="mr-1 btn btns btn-retour-commande">Non<br>Revenir à la Commande</button>
                                            </form>

                                            <form action="index.php" method="post">
                                                <input type="hidden" name="annulerCommande">
                                                <button type="submit" class="ml-1 btn btns btn-annuler-accueil">Oui<br>Revenir à l'Accueil</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>               

                        </div>

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