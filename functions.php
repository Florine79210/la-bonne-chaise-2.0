<?php

function get_connection(){

    try {
        $bdd = new PDO('mysql:host=localhost;dbname=boutique_en_ligne;charset=utf8', 'florine', 'Stell@1914bl0*', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));    
    }
    
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

    return $bdd;
}



        // LISTE DES ARTICLES
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function getArticles() {

    $bdd = get_connection();

    $listeArticles = $bdd->query('SELECT * FROM articles');

    return $listeArticles->fetchAll(PDO::FETCH_ASSOC);
}


        // VOIR LES ARTICLES (PAGE D'ACCUEIL)
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function showArticles(){

    $listeArticles = getArticles();

    foreach ($listeArticles as $article){

        $article['prix'] = number_format($article['prix'], 2, ',', ' ');

        echo "<div class=\"container mt-5 mb-5 p-5 fiche_article\">

                <div class=\"row\">

                    <div class=\"col-md-6 pl-5\">
                        <div class=\"row mb-5 pt-3 text-center\">
                            <h2>" .  $article['nom'] . "<h2>\n
                        </div>
                        
                        <div class=\"row pr-5\"> 
                            <p>" . $article['description'] . "<p>\n
                        </div>            
                    </div>  

                    <div class=\"col-md-6\">
                        <div class=\"row justify-content-center\">
                            <img class=\"image_article\" src=\"images/" . $article['image'] . "\">
                        </div>

                        <div class=\"row mb-3 justify-content-center\">
                            <p>Prix unitaire : <span>" . $article['prix'] . " €</span><p>\n
                        </div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6 text-center\">
                        <form action=\"index.php\" method=\"post\">        
                            <input type=\"hidden\" name= \"idEnvoiAjoutPanier\" value=\"" . $article["id"] . "\">
                            <input class=\"mt-3 pt-2 pr-3 pb-2 pl-3 btns btn-ajout-panier\"type=\"submit\" name=\"ajoutPanier\" value=\"Ajouter au panier\">
                        </form>
                    </div>

                    <div class=\"col-md-6 text-center\">
                        <form action=\"produit.php\" method=\"post\">       
                        <input type=\"hidden\" name= \"idDetailsproduit\" value=\"" . $article["id"] . "\">
                        <input class=\"mt-3 pt-2 pr-3 pb-2 pl-3 btns btn-details\" type=\"submit\" name=\"detailsProduit\" value=\"Détails du produit\">
                        </form>
                    </div>
                </div>    

            </div>";  
    }                
}


// <----- Ajouter un article de la BDD via son ID ---------------->

function getArticleBddFromId($id){

    $bdd = get_connection();

    $articleSelectBdd = $bdd->prepare('SELECT * FROM articles WHERE id=?');
    $articleSelectBdd->execute(array($id));

    return $articleSelectBdd->fetch();
  
}

        // VOIR LES DETAILS D'UN ARTICLE (PAGE PRODUITS)
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function showArticleDetails($article){

    $article['prix'] = number_format($article['prix'], 2, ',', ' ');

        echo "<div class=\"container mt-5 mb-5 p-5 details_article\">
                <div class=\"row\">

                    <div class=\"col-md-6 pl-5\">
                        <div class=\"row mb-3\">
                            <h2>" .  $article['nom'] . "<h2>\n
                        </div>
                        
                        <div class=\"row mb-3\">
                            <p>" . $article['description'] . "<p>\n
                            <p>" . $article['description_detaillee'] . "<p>\n
                        </div>                     
                    </div>

                    <div class=\"col-md-6\">
                        <div class=\"row mt-4 justify-content-center\">
                            <img class=\" mt-4 pt-4 image_article\" src=\"images/" . $article['image'] . "\">
                        </div> 
                        
                        <div class=\"row mt-4 justify-content-center\">       
                            <p>Prix unitaire : <span>" . $article['prix'] . " €</span><p>\n
                        </div> 
                    </div> 
                
                </div>

                <div class=\"row justify-content-center\">
                        <form action=\"index.php\" method=\"post\">        
                            <input type=\"hidden\" name= \"idEnvoiAjoutPanier\" value=\"" . $article["id"] . "\">
                            <input class=\"mt-3 pt-2 pb-2 text-center btn btns btn-ajout-panier\" type=\"submit\" name=\"ajoutPanier\" value=\"Ajouter au panier\">
                        </form>
                    </div>
                </div>

            </div>";                 
}


// <-----Ajouter un article au panier ---------------->

function ajoutPanier($article){

    $articleAjoute = false;

    foreach ($_SESSION["panier"] as $articlePanier){
        if ($articlePanier ["id"] == $article ["id"]){
            echo "<script> alert(\"Article déjà présent dans le panier !\");</script>";
            $articleAjoute = true;
        }
    }

    if (!$articleAjoute){
        $article['quantite'] = 1;
        array_push($_SESSION['panier'], $article);
    }
}


        // VOIR LE PANIER (PAGE PANIER & VALIDATION)
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function showPanier($nomDePage){

    foreach ($_SESSION["panier"] as $article){

        $article['prix'] = number_format($article['prix'], 2, ',', ' ');

        echo "<div class=\"container mt-5 mb-5 pt-3 pb-3 voir_panier\">
                <div class=\"row align-items-center\">
                
                    <div class=\"col-md-4 text-center\">
                        <h2 class=\"mb-3\">" .  $article['nom'] . "<h2>\n
                        <img class=\"image_article\" src=\"images/" . $article['image'] . "\">
                    </div>
                             
                    <div class=\"col-md-4\">
                        <div class=\"row mb-4 justify-content-center\">      
                            <p>Prix unitaire : <span>" . $article['prix'] . " €</span><p>\n 
                        </div>
                    
                        <div class=\"row justify-content-center\">
                            <form class=\"form-row\" action=\"".$nomDePage."\" method=\"post\">
                                <p class=\"mt-2 mr-2\" >Quantité :<p>
                                <input type=\"hidden\" name=\"idModifierQuantite\" value=\"" .$article['id']. "\">
                                <input class=\"mr-3 btn-saisie-nbr\" type=\"number\" name=\"nouvelleQuantite\" min=\"1\" max=\"12\" value=\"" .$article['quantite']. "\"> 
                                <button class=\" pt-2 pr-3 pb-2 pl-3 btns btn_modif\" type=\"submit\"> Modifier </button>
                            </form>   
                        </div>
                    </div>

                    <div class=\"col-md-4 text-center\">
                        <form action=\"".$nomDePage."\" method=\"post\">
                            <input type=\"hidden\" name=\"idSupprimerArticle\" value=\"" .$article['id']. "\"> 
                            <button class=\" pt-2 pr-3 pb-2 pl-3 btns btn_suppr\" type=\"submit\"> Supprimer l'article </button>
                        </form>
                    </div>
                    
                </div>
            </div>";  
    }
}


// <-----Modifier la quantité d'un article ---------------->

function modifierQuantite(){

    $idModifierQuantite = $_POST["idModifierQuantite"];

        for ($i = 0; $i < count($_SESSION['panier']); $i++){

            if ($_SESSION['panier'][$i]['id'] == $idModifierQuantite){
                $_SESSION['panier'][$i]['quantite'] = $_POST['nouvelleQuantite'];
            }
        }
}
 

// <-----Supprimer un article ---------------->

 function supprArticle(){

    for ($i = 0; $i < count($_SESSION['panier']); $i++){

        if ($_SESSION['panier'][$i]['id'] == $_POST["idSupprimerArticle"]){
            array_splice($_SESSION['panier'], $i, 1);
            echo "<script> alert(\"Article retiré du panier\");</script>";
        } 

        if (empty ($_SESSION['panier'])){
            echo "<p class=\"text-center message-panier-vide\">Le panier est <span>vide</span>.</p>";
        }
    }
 }


// <-----Afficher les boutons Valider & Vider le panier (PAGE PANIER) ---------------->

function afficherBoutons(){

    if (!empty($_SESSION["panier"])){

        echo "<div class=\"container mt-5 mb-5 valider_vider\">
                <div class=\"row\">

                    <div class=\"col-md-6 text-center\">
                        <a href=\"validation.php\">
                            <button class=\"pt-2 pr-3 pb-2 pl-3 btns btn_valider\"> Valider le panier </button>
                        </a>  
                    </div>

                    <div class=\"col-md-6 text-center\">
                        <form action=\"index.php\" method=\"post\">
                            <input type=\"hidden\" name=\"viderPanier\" value=\"true\">
                            <button  class=\"pt-2 pr-3 pb-2 pl-3 btns btn_vider\"type=\"submit\"> Vider le panier </button>   
                        </form>
                    </div>

                </div>
            </div>";  
    }
}


// <-----Vider le Panier ---------------->

function viderPanier(){

    $_SESSION['panier'] = array();
    echo "<script> alert(\"Le panier est vide.\");</script>";   
}


// <-----Calculs et affichages pour le Panier ---------------->

function nbrArticlesPanier(){

    $nbrArticlesPanier = 0;

    for ($i = 0; $i < count($_SESSION['panier']); $i++){
        $nbrArticlesPanier += intval($_SESSION['panier'][$i]['quantite']);
    }
    return $nbrArticlesPanier;
}


function totalPrixArticles(){

    $totalPrixArticles = 0;

    for ($i = 0; $i < count($_SESSION['panier']); $i++){
        $totalPrixArticles += $_SESSION['panier'][$i]['prix'] * intval($_SESSION['panier'][$i]['quantite']);
    }
    return $totalPrixArticles;
}

function affichageTotalPrixArticles(){
    $totalPrixArticles = totalPrixArticles();

    if ($_SESSION['panier']) {
        $totalPrixArticles = number_format($totalPrixArticles, 2, ',', ' ');
        echo "<p class=\"text-center totals total_articles\">Total des achats : <span>" . $totalPrixArticles . " €</span></p>";
    }
}


function totalFraisPort(){
    $totalFraisPort = 0;

    for ($i = 0; $i < count($_SESSION['panier']); $i++){
        $totalFraisPort += 12.49 * intval($_SESSION['panier'][$i]['quantite']);
    }
    return $totalFraisPort;
}

function affichageTotalFraisPort(){
    $totalFraisPort = totalFraisPort();

    if ($_SESSION['panier']) {
        $totalFraisPort = number_format($totalFraisPort, 2, ',', ' ');
        echo "<p class=\"text-center totals\">Total des frais de port : <span>" . $totalFraisPort . " €</span></p>";
    }
}


function totalARegler(){
    
    $totalPrixArticles = totalPrixArticles();
    $totalFraisPort = totalFraisPort();

    return $totalPrixArticles + $totalFraisPort;
}

function affichageTotalARegler(){
    $totalARegler = totalARegler();

    if ($_SESSION['panier']) {
        $totalARegler = number_format($totalARegler, 2, ',', ' ');
        echo "<p class=\"text-center total_a_regler\">Total à régler : <span>" . $totalARegler . " €</span></p>";
    }
}


// <----- LISTE DES GAMMES ---------------->
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function getGammes() {

    $bdd = get_connection();

    $listeGammes = $bdd->query('SELECT * FROM gammes');

    return $listeGammes->fetchAll(PDO::FETCH_ASSOC);
}

// <----- LISTE DES ARTICLES D'UNE GAMME ---------------->

function getArticleGammeBddFromId($id){

    $bdd = get_connection();

    $listeArticlesGammes = $bdd->prepare('SELECT * FROM articles WHERE id_gamme=?');
    $listeArticlesGammes->execute(array($id));

    return $listeArticlesGammes->fetchAll(PDO::FETCH_ASSOC);
}


// <----- AFFICHER LES GAMMES ET LEURS ARTICLES ---------------->

function showGammes(){

    $listeGammes = getGammes();

    foreach ($listeGammes as $gamme){

        echo "<div class=\"container gamme\">

                <div class=\"row justify-content-center\">
                    <h2>" . $gamme['nom_gamme'] . "<h2\n
                </div>
            </div>";
    

        $listeArticlesGammes = getArticleGammeBddFromId($gamme['id']);

        foreach ($listeArticlesGammes as $article){

            $article['prix'] = number_format($article['prix'], 2, ',', ' ');

            echo "<div class=\"container mt-5 mb-5 p-5 articles_gamme\">

                    <div class=\"row\">

                        <div class=\"col-md-6 pl-5\">
                            <div class=\"row mb-5 pt-3 text-center\">
                                <h3>" .  $article['nom'] . "<h3>\n
                            </div>
                    
                            <div class=\"row pr-5\"> 
                                <p>" . $article['description'] . "<p>\n
                            </div>            
                        </div>  

                        <div class=\"col-md-6\">
                            <div class=\"row justify-content-center\">
                                <img class=\"image_article\" src=\"images/" . $article['image'] . "\">
                            </div>

                            <div class=\"row mb-3 justify-content-center\">
                                <p>Prix unitaire : <span>" . $article['prix'] . " €</span><p>\n
                            </div>
                        </div>
                    </div>

                    <div class=\"row\">
                        <div class=\"col-md-6 text-center\">
                            <form action=\"index.php\" method=\"post\">        
                                <input type=\"hidden\" name= \"idEnvoiAjoutPanier\" value=\"" . $article["id"] . "\">
                                <input class=\"mt-3 pt-2 pr-3 pb-2 pl-3 btns btn-ajout-panier\"type=\"submit\" name=\"ajoutPanier\" value=\"Ajouter au panier\">
                            </form>
                        </div>

                        <div class=\"col-md-6 text-center\">
                            <form action=\"produit.php\" method=\"post\">       
                                <input type=\"hidden\" name= \"idDetailsproduit\" value=\"" . $article["id"] . "\">
                                <input class=\"mt-3 pt-2 pr-3 pb-2 pl-3 btns btn-details\" type=\"submit\" name=\"detailsProduit\" value=\"Détails du produit\">
                             </form>
                        </div>
                    </div>    

                </div>";  
        }
    }                
}


// <----- CONNEXION ---------------->
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                echo "<div class=\"container\">
                        <div class=\"row justify-content-center\">
                            <form action=\"index.php\" method=\"post\">

                                <div class=\"row\">
                                    <p>Email :<p>
                                    <input type=\"hidden\" name=\"idModifierQuantite\" value=\"" .$article['id']. "\">
                                    <input class=\"mr-3 btn-saisie-nbr\" type=\"number\" name=\"nouvelleQuantite\" min=\"1\" max=\"12\" value=\"" .$article['quantite']. "\"> 
                                </div>

                                <div class=\"row\">
                                    <p>Mot de passe :<p>
                                    <input type=\"hidden\" name=\"idModifierQuantite\" value=\"" .$article['id']. "\">
                                    <input class=\"mr-3 btn-saisie-nbr\" type=\"number\" name=\"nouvelleQuantite\" min=\"1\" max=\"12\" value=\"" .$article['quantite']. "\"> 
                                </div>

                                <div class=\"row\">
                                    <input type=\"hidden\" name=\"idModifierQuantite\" value=\"" .$article['id']. "\">
                                    <input type=\"number\" name=\"nouvelleQuantite\" min=\"1\" max=\"12\" value=\"" .$article['quantite']. "\"> 
                                    <button class=\" pt-2 pr-3 pb-2 pl-3 btns btn_modif\" type=\"submit\"> Modifier </button>
                                </div>

                            </form>   
                        </div>
                    </div>


// <----- INSCRITION ---------------->
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------



?>