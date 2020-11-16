<?php

        // LISTE DES ARTICLES
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function getArticles() {

    return [
        "article 1" => ["id" => "1", "name" => "Füt'Hürr", "picture" => "chaise-fut-hurr.jpg", "description" => "Moulée dans un seul bloc de polypropylène, la chaise design Füt'Hürr donnera un aspect résolument moderne et futuriste à votre décoration intérieure.",
                        "descriptionDetaillee" => "Ses courbes associées font de la chaise Füt'Hürr un modèle du genre. La forme ergonomique de son siège vous offre un excellent confort d'assise. Si vous souhaitez meubler un intérieur moderne ou design,
                        cette chaise est faite pour vous !<br>Petit plus, légère et empilable, elle peut également être utilisée sur votre terrasse ou dans votre jardin.",
                        "price" => 149.99],
        "article 2" => ["id" => "2", "name" => "Rusticae", "picture" => "chaise-rusticae.jpg", "description" => "La chaise Rusticae est une création française de qualité. Elle possède un look hors du temps, très nature et élégant qui s'accorde parfaitement avec tous les styles d'intérieur.",
                        "descriptionDetaillee" => "Cette chaise française se distingue par sa robustesse. Elle possède un dossier et une assise en lin ainsi qu'une épaisse structure en bois flotté qui se veut rassurante et rustique. 
                        Cette chaise est idéale pour apporter une authenticité accrue à votre déco.",
                        "price" => 249.99],
        "article 3" => ["id" => "3", "name" => "Wave", "picture" => "chaise-wave.jpg", "description" => "Chaleureuse, séduisante et tendance,<br>la chaise en tissu Wave est un fructueux<br>mélange entre modernité et confort.",
                        "descriptionDetaillee" => "Envie de douceur dans votre intérieur ?<br>Ne cherchez pas plus longtemps, la chaise Wave sera votre meuble idéal ! Un dossier haut pour un maintien optimal, 
                        un tissu agréable et chaleureux ainsi qu'une assise rembourrée ... Tous les atouts sont là pour vous offrir un confort des plus délectables. Cette chaise confortable s'accommodera aisément dans les intérieurs
                        contemporains ou modernes et vous fera passer un bon moment de détente et de convivialité ! A noter que la housse est déhoussable afin de faciliter son entretien.",
                        "price" => 199.99],
        "article 4" => ["id" => "4", "name" => "Whirlwind", "picture" => "chaise_whirlwind.jpg", "description" => "Conçue par notre équipe de designers,<br>la chaise Whirlwind incarne le parfait compromis entre design et confort.",
                        "descriptionDetaillee" => "La chaise design Whirlwind trouvera sa place aussi bien dans un séjour, un salon ou un bureau. La conception de sa coque a été pensée dans les moindres détails afin d'offrir un excellent confort à ses utilisateurs.<br>
                        En effet, moulée dans un bloc de polypropylène, sa coque possède de jolies courbes. Son piétement en granit brut est également pivotant, ce qui garantit une liberté de mouvement.",
                        "price" => 299.99]
    ];
}


        // VOIR LES ARTICLES (PAGE D'ACCUEIL)
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function showArticles($listeArticles){

    foreach ($listeArticles as $article){

        $article["price"] = number_format($article["price"], 2, ',', ' ');

        echo "<div class=\"container mt-5 mb-5 p-5 fiche_article\">

                <div class=\"row\">

                    <div class=\"col-md-6 pl-5\">
                        <div class=\"row mb-5 pt-3 text-center\">
                            <h2>" .  $article["name"] . "<h2>\n
                        </div>
                        
                        <div class=\"row pr-5\"> 
                            <p>" . $article["description"] . "<p>\n
                        </div>            
                    </div>  

                    <div class=\"col-md-6\">
                        <div class=\"row justify-content-center\">
                            <img class=\"image_article\" src=\"images/" . $article["picture"] . "\">
                        </div>

                        <div class=\"row mb-3 justify-content-center\">
                            <p>Prix unitaire : <span>" . $article["price"] . " €</span><p>\n
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


        // VOIR LES DETAILS D'UN ARTICLE (PAGE PRODUITS)
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function showArticleDetails($article){

    $article["price"] = number_format($article["price"], 2, ',', ' ');

        echo "<div class=\"container mt-5 mb-5 p-5 details_article\">
                <div class=\"row\">

                    <div class=\"col-md-6 pl-5\">
                        <div class=\"row mb-3\">
                            <h2>" .  $article["name"] . "<h2>\n
                        </div>
                        
                        <div class=\"row mb-3\">
                            <p>" . $article["description"] . "<p>\n
                            <p>" . $article["descriptionDetaillee"] . "<p>\n
                        </div>                     
                    </div>

                    <div class=\"col-md-6\">
                        <div class=\"row mt-4 justify-content-center\">
                            <img class=\" mt-4 pt-4 image_article\" src=\"images/" . $article["picture"] . "\">
                        </div> 
                        
                        <div class=\"row mt-4 justify-content-center\">       
                            <p>Prix unitaire : <span>" . $article["price"] . " €</span><p>\n
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


// <-----Ajouter un article via son ID ---------------->

function getArticleFromId($listeArticles, $id){

    foreach ($listeArticles as $article){

        if ($article["id"] == $id){
            return $article;
        }
    }
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

        $article["price"] = number_format($article["price"], 2, ',', ' ');

        echo "<div class=\"container mt-5 mb-5 pt-3 pb-3 voir_panier\">
                <div class=\"row align-items-center\">
                
                    <div class=\"col-md-4 text-center\">
                        <h2 class=\"mb-3\">" .  $article['name'] . "<h2>\n
                        <img class=\"image_article\" src=\"images/" . $article['picture'] . "\">
                    </div>
                             
                    <div class=\"col-md-4\">
                        <div class=\"row mb-4 justify-content-center\">      
                            <p>Prix unitaire : <span>" . $article["price"] . " €</span><p>\n 
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
        $totalPrixArticles += $_SESSION['panier'][$i]['price'] * intval($_SESSION['panier'][$i]['quantite']);
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

?>