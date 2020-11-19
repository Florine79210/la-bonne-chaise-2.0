<?php

function get_connection()
{

    try {
        $bdd = new PDO('mysql:host=localhost;dbname=boutique_en_ligne;charset=utf8', 'florine', 'Stell@1914bl0*', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    return $bdd;
}



// LISTE DES ARTICLES
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function getArticles()
{

    $bdd = get_connection();

    $listeArticles = $bdd->query('SELECT * FROM articles');

    return $listeArticles->fetchAll(PDO::FETCH_ASSOC);
}


// VOIR LES ARTICLES (PAGE D'ACCUEIL)
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function showArticles()
{

    $listeArticles = getArticles();

    foreach ($listeArticles as $article) {

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

function getArticleBddFromId($id)
{

    $bdd = get_connection();

    $articleSelectBdd = $bdd->prepare('SELECT * FROM articles WHERE id=?');
    $articleSelectBdd->execute(array($id));

    return $articleSelectBdd->fetch();
}

// VOIR LES DETAILS D'UN ARTICLE (PAGE PRODUITS)
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function showArticleDetails($article)
{

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

function ajoutPanier($article)
{

    $articleAjoute = false;

    foreach ($_SESSION["panier"] as $articlePanier) {
        if ($articlePanier["id"] == $article["id"]) {
            echo "<script> alert(\"Article déjà présent dans le panier !\");</script>";
            $articleAjoute = true;
        }
    }

    if (!$articleAjoute) {
        $article['quantite'] = 1;
        array_push($_SESSION['panier'], $article);
    }
}


// VOIR LE PANIER (PAGE PANIER & VALIDATION)
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function showPanier($nomDePage)
{

    foreach ($_SESSION["panier"] as $article) {

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
                            <form class=\"form-row\" action=\"" . $nomDePage . "\" method=\"post\">
                                <p class=\"mt-2 mr-2\" >Quantité :<p>
                                <input type=\"hidden\" name=\"idModifierQuantite\" value=\"" . $article['id'] . "\">
                                <input class=\"mr-3 btn-saisie-nbr\" type=\"number\" name=\"nouvelleQuantite\" min=\"1\" max=\"12\" value=\"" . $article['quantite'] . "\"> 
                                <button class=\" pt-2 pr-3 pb-2 pl-3 btns btn_modif\" type=\"submit\"> Modifier </button>
                            </form>   
                        </div>
                    </div>

                    <div class=\"col-md-4 text-center\">
                        <form action=\"" . $nomDePage . "\" method=\"post\">
                            <input type=\"hidden\" name=\"idSupprimerArticle\" value=\"" . $article['id'] . "\"> 
                            <button class=\" pt-2 pr-3 pb-2 pl-3 btns btn_suppr\" type=\"submit\"> Supprimer l'article </button>
                        </form>
                    </div>
                    
                </div>
            </div>";
    }
}


// <-----Modifier la quantité d'un article ---------------->

function modifierQuantite()
{

    $idModifierQuantite = $_POST["idModifierQuantite"];

    for ($i = 0; $i < count($_SESSION['panier']); $i++) {

        if ($_SESSION['panier'][$i]['id'] == $idModifierQuantite) {
            $_SESSION['panier'][$i]['quantite'] = $_POST['nouvelleQuantite'];
        }
    }
}


// <-----Supprimer un article ---------------->

function supprArticle()
{

    for ($i = 0; $i < count($_SESSION['panier']); $i++) {

        if ($_SESSION['panier'][$i]['id'] == $_POST["idSupprimerArticle"]) {
            array_splice($_SESSION['panier'], $i, 1);
            echo "<script> alert(\"Article retiré du panier\");</script>";
        }

        if (empty($_SESSION['panier'])) {
            echo "<p class=\"text-center message-panier-vide\">Le panier est <span>vide</span>.</p>";
        }
    }
}


// <-----Afficher les boutons Valider & Vider le panier (PAGE PANIER) ---------------->

function afficherBoutons()
{

    if (!empty($_SESSION["panier"])) {

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

function viderPanier()
{

    $_SESSION['panier'] = array();
    echo "<script> alert(\"Le panier est vide.\");</script>";
}


// <-----Calculs et affichages pour le Panier ---------------->

function nbrArticlesPanier()
{

    $nbrArticlesPanier = 0;

    for ($i = 0; $i < count($_SESSION['panier']); $i++) {
        $nbrArticlesPanier += intval($_SESSION['panier'][$i]['quantite']);
    }
    return $nbrArticlesPanier;
}


function totalPrixArticles()
{

    $totalPrixArticles = 0;

    for ($i = 0; $i < count($_SESSION['panier']); $i++) {
        $totalPrixArticles += $_SESSION['panier'][$i]['prix'] * intval($_SESSION['panier'][$i]['quantite']);
    }
    return $totalPrixArticles;
}

function affichageTotalPrixArticles()
{
    $totalPrixArticles = totalPrixArticles();

    if ($_SESSION['panier']) {
        $totalPrixArticles = number_format($totalPrixArticles, 2, ',', ' ');
        echo "<p class=\"text-center totals total_articles\">Total des achats : <span>" . $totalPrixArticles . " €</span></p>";
    }
}


function totalFraisPort()
{
    $totalFraisPort = 0;

    for ($i = 0; $i < count($_SESSION['panier']); $i++) {
        $totalFraisPort += 12.49 * intval($_SESSION['panier'][$i]['quantite']);
    }
    return $totalFraisPort;
}

function affichageTotalFraisPort()
{
    $totalFraisPort = totalFraisPort();

    if ($_SESSION['panier']) {
        $totalFraisPort = number_format($totalFraisPort, 2, ',', ' ');
        echo "<p class=\"text-center totals\">Total des frais de port : <span>" . $totalFraisPort . " €</span></p>";
    }
}


function totalARegler()
{

    $totalPrixArticles = totalPrixArticles();
    $totalFraisPort = totalFraisPort();

    return $totalPrixArticles + $totalFraisPort;
}

function affichageTotalARegler()
{
    $totalARegler = totalARegler();

    if ($_SESSION['panier']) {
        $totalARegler = number_format($totalARegler, 2, ',', ' ');
        echo "<p class=\"text-center total_a_regler\">Total à régler : <span>" . $totalARegler . " €</span></p>";
    }
}


// <----- LISTE DES GAMMES ---------------->
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function getGammes()
{

    $bdd = get_connection();

    $listeGammes = $bdd->query('SELECT * FROM gammes');

    return $listeGammes->fetchAll(PDO::FETCH_ASSOC);
}

// <----- LISTE DES ARTICLES D'UNE GAMME ---------------->

function getArticleGammeBddFromId($id)
{

    $bdd = get_connection();

    $listeArticlesGammes = $bdd->prepare('SELECT * FROM articles WHERE id_gamme=?');
    $listeArticlesGammes->execute(array($id));

    return $listeArticlesGammes->fetchAll(PDO::FETCH_ASSOC);
}


// <----- AFFICHER LES GAMMES ET LEURS ARTICLES ---------------->

function showGammes()
{

    $listeGammes = getGammes();

    foreach ($listeGammes as $gamme) {

        echo "<div class=\"container gamme\">

                <div class=\"row justify-content-center\">
                    <h2>" . $gamme['nom_gamme'] . "<h2\n
                </div>
            </div>";

        $listeArticlesGammes = getArticleGammeBddFromId($gamme['id']);

        foreach ($listeArticlesGammes as $article) {

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

function connexion(){

    extract($_POST);

    if(empty($Email) || empty($motDePasse) || empty($motDePasse2)) {
        echo "<div class=\"container w-50 text-center p-3 mt-2 bg-danger\"> Un ou plusieurs champs sont vides !</div>";

        }else {

            if(!($motDePasse == $motDePasse2)){
                echo "<div class=\"container w-50 text-center p-3 mt-2 bg-danger\"> Les mots de passe sont différents !</div>";

            }else {
                $bdd = get_connection();

                $requete = $bdd->prepare('SELECT * FROM clients WHERE email=?');
                $requete->execute([strip_tags($Email)]);
                $resultat = $requete->fetch(PDO::FETCH_ASSOC);

                if (!$resultat){
                    echo "<div class=\"container w-50 text-center p-3 mt-2 bg-danger\"> Adresse email INCONNUE !</div>";

                } else {
                    $motDePassCorrect = password_verify($motDePasse, $resultat['mot_de_passe']);

                    if (!$motDePassCorrect){
                        echo "<div class=\"container w-50 text-center p-3 mt-2 bg-danger\"> Le mot de passe est incorrect !</div>";

                    }else {
                        $requete = $bdd->prepare('SELECT * FROM adresses WHERE id_client=?');
                        $requete->execute([$resultat['id']]);
                        $adresseClient = $requete -> fetch(PDO::FETCH_ASSOC);

                        $_SESSION['id'] = $resultat['id'];
                        $_SESSION['nom'] = $resultat['nom'];
                        $_SESSION['prenom'] = $resultat['prenom'];
                        $_SESSION['email'] = $resultat['email'];
                        $_SESSION['adresse'] = $adresseClient;

                        var_dump($_SESSION); 

                        echo "<div class=\"container w-50 text-center p-3 mt-2 bg-success\"> Bienvenue " . $resultat['prenom'] ." ". $resultat['nom'] . " !</div>";
                    }
            }     
        }
    }
}


// <----- INSCRITION ---------------->
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function limiteCaracteresInputs()
{

    $longueurInputsOk = true;

    if (strlen($_POST['nom']) < 3 || strlen($_POST['nom']) > 25) {
        $longueurInputsOk = false;
    }

    if (strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 25) {
        $longueurInputsOk = false;
    }

    if (strlen($_POST['Email']) < 8 || strlen($_POST['Email']) > 40) {
        $longueurInputsOk = false;
    }

    if (strlen($_POST['adresse']) < 8 || strlen($_POST['adresse']) > 80) {
        $longueurInputsOk = false;
    }

    if (strlen($_POST['codePostal']) !== 5) {
        $longueurInputsOk = false;
    }

    if (strlen($_POST['ville']) < 4 || strlen($_POST['ville']) > 40) {
        $longueurInputsOk = false;
    }

    return $longueurInputsOk;
}


// function verifMotDePasse()
// {
//     $passwordSecur = false;

//     // au moins 1 chiffre et 1 lettre, entre 8 et 15 caractères
//     $regex = "^(?=.[0-9])(?=.[a-zA-Z])(?=\S+$).{8,15}$^";

//     var_dump($_POST['motDePasse']);

//     if (preg_match($regex, $_POST['motDePasse'])) {
//         $passwordSecur = true;
//     }

//     var_dump($passwordSecur);
//     return $passwordSecur;
// }


function inscription()
{
    $bdd = get_connection();

    extract($_POST);

    if (!empty($nom) && !empty($prenom) && !empty($adresse) && !empty($codePostal) && !empty($ville) && !empty($Email) && !empty($motDePasse) && !empty($motDePasse2)) {

        if (!limiteCaracteresInputs()) {
            echo '<script>alert(\'Longueur d\'un ou plusieurs champs incorrect !\')</script>';
        } else {

            if (!($motDePasse == $motDePasse2)) {
                echo '<script>alert(\'Les mots de passe sont différents !\')</script>';
            } else {

                // if (!verifMotDePasse()) {
                //     echo '<script>alert(\'La sécuritée du mot de passe est insufisante !\')</script>';
                // } else {

                    $options = ['cost' => 12];
                    $hashpass = password_hash(strip_tags($motDePasse), PASSWORD_BCRYPT, $options);

                    $inscription = $bdd->prepare('INSERT INTO clients (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mot_de_passe)');
                    $validationInscription = $inscription->execute([
                        'nom' => strip_tags($nom),
                        'prenom' => strip_tags($prenom),
                        'email' => strip_tags($Email),
                        'mot_de_passe' => $hashpass
                    ]);

                    if ($validationInscription) {
                        echo '<script>alert(\'Le compte a bien été créé !\')</script>';

                        $idClient = $bdd->lastInsertId();

                        $transmitionAdresseClient = $bdd->prepare('INSERT INTO adresses (id_client, adresse, code_postal, ville) VALUES (:id_client, :adresse, :code_postal, :ville)');
                        $transmitionAdresseClient->execute([
                            'id_client' => $idClient,
                            'adresse' => strip_tags($adresse),
                            'code_postal' => strip_tags($codePostal),
                            'ville' => strip_tags($ville),
                        ]);
                    } else {
                        echo '<script>alert(\'Echec! le compte n\'a pas été créé !\')</script>';
                    }
                // }
            }
        }
    }
}

function formulaireDInscription()
{
    $inscription = inscription();

    echo "<div class=\"container mb-5\">
            
                <form action=\"connexion.php\" method=\"post\">
                    <div class=\"row pt-3 formulaires formulaire-inscription\">
                        <div class=\"col md-6 pr-5\">
                            <div class=\"row justify-content-end\">
                                <p class=\"mr-2\">Nom : <p>
                                <input class=\"text-center\" type=\"text\" name=\"nom\" placeholder=\"Votre Nom\" required>
                            </div>

                            <div class=\"row justify-content-end\">
                                <p class=\"mr-2\">Prénom : <p>
                                <input class=\"text-center\" type=\"text\" name=\"prenom\" placeholder=\"Votre Prénom\" required>
                            </div>

                            <div class=\"row justify-content-end\">
                                <p class=\"mr-2\">Adresse : <p>
                                <input class=\"text-center\" type=\"text\" name=\"adresse\" placeholder=\"Votre adresse\" required>
                            </div>

                            <div class=\"row justify-content-end\">
                                <p class=\"mr-2\">Code Postal : <p>
                                <input class=\"text-center\" type=\"text\" name=\"codePostal\" placeholder=\"Votre code postal\" required>
                            </div>

                            <div class=\"row justify-content-end\">
                                <p class=\"mr-2\">Ville : <p>
                                <input class=\"text-center\" type=\"text\" name=\"ville\" placeholder=\"Votre ville\" required>
                            </div>
                        </div>

                        <div class=\"col md-6 pr-5\">
                            <div class=\"row justify-content-end\">
                                <p class=\"mr-2\">Email : <p>
                                <input class=\"text-center\" type=\"email\" name=\"Email\" placeholder=\"Votre Email '@'\" required>
                            </div>

                            <div class=\"row justify-content-end\">
                                <p class=\"mr-2\">Mot de passe : <p>
                                <input class=\"text-center\" type=\"password\" name=\"motDePasse\" placeholder=\"Votre mot de passe\" required>
                            </div>

                            <div class=\"row justify-content-end\">
                                <p class=\"mr-2\">Mot de passe : <p>
                                <input class=\"text-center\" type=\"password\" name=\"motDePasse2\" placeholder=\"Confirmez le M.D.P\" required>
                            </div>

                            <div class=\"row mt-4 justify-content-center\">
                                <button class=\"pt-1 pr-2 pb-1 pl-2 btns btnInscription\" type=\"submit\" name=\"inscription\" required> Inscription </button>
                            </div>
                        </div>
                    </div>

                    
                
                </form>   
            
            </div>";
}
