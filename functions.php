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
                        
                        <div class=\"row mb-5 pr-5\"> 
                            <p>" . $article['description'] . "<p>\n
                        </div>
                        
                        <div class=\"row justify-content-center mt-5 pr-5 btnStock\"> 
                            " . boutonStocks($article['stock']) . "
                        </div>            
                    </div>  

                    <div class=\"col-md-6\">
                        <div class=\"row justify-content-center\">
                            <img class=\"image_article\" src=\"ressources/images/" . $article['image'] . "\">
                        </div>

                        <div class=\"row mt-2 justify-content-center\">
                            <p>Prix unitaire : <span>" . $article['prix'] . " €</span><p>\n
                        </div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6 text-center\">";

        if ($article['stock'] > 0) {
                    echo "<form action=\"index.php\" method=\"post\">        
                            <input type=\"hidden\" name= \"idEnvoiAjoutPanier\" value=\"" . $article["id"] . "\">
                            <input class=\"mt-3 pt-2 pr-3 pb-2 pl-3 btns btn-ajout-panier\"type=\"submit\" name=\"ajoutPanier\" value=\"Ajouter au panier\">
                        </form>";
        }
                echo "</div>

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
                        <img class=\" mt-4 pt-4 image_article\" src=\"ressources/images/" . $article['image'] . "\">
                    </div> 
                        
                    <div class=\"row mt-4 justify-content-center\">       
                        <p>Prix unitaire : <span>" . $article['prix'] . " €</span><p>\n
                    </div> 
                </div> 
                
            </div>

            <div class=\"row justify-content-center\">
                <div class=\"col-md-6 text-center\">";
    if ($article['stock'] > 0) {
        echo "<form action=\"index.php\" method=\"post\">        
                                <input type=\"hidden\" name= \"idEnvoiAjoutPanier\" value=\"" . $article["id"] . "\">
                                <input class=\"mt-3 pt-2 pb-2 text-center btn btns btn-ajout-panier\" type=\"submit\" name=\"ajoutPanier\" value=\"Ajouter au panier\">
                            </form>";
    }
    echo "</div>

                <div class=\"col-md-6 text-center mt-3\">
                    <div class=\"row justify-content-center\">
                        " . boutonStocks($article['stock']) . "
                    </div>
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
    if (isset($_SESSION["panier"])) {
        foreach ($_SESSION["panier"] as $article) {

            $article['prix'] = number_format($article['prix'], 2, ',', ' ');

            echo "<div class=\"container mt-5 mb-5 pt-3 pb-3 voir_panier\">
                <div class=\"row align-items-center\">
                
                    <div class=\"col-md-4 text-center\">
                        <h2 class=\"mb-3\">" .  $article['nom'] . "<h2>\n
                        <img class=\"image_article\" src=\"ressources/images/" . $article['image'] . "\">
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
}

// <-----Modifier la quantité d'un article ---------------->

function modifierQuantite()
{
    $articleId = $_POST["idModifierQuantite"];

    $bdd = get_connection();
    $query = $bdd->prepare('SELECT stock FROM articles where id = ?');
    $query->execute([$articleId]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $quantityInStock = $result['stock'];

    $nouvelleQuantite = $_POST['nouvelleQuantite'];

    if ($nouvelleQuantite > $quantityInStock) {
        echo "<script> alert(\"Quantité demandé supperieur a nos stocks !\");</script>";
    } else {
        for ($i = 0; $i < count($_SESSION['panier']); $i++) {

            if ($_SESSION['panier'][$i]['id'] == $articleId) {
                $_SESSION['panier'][$i]['quantite'] = $_POST['nouvelleQuantite'];
            }
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

    if (isset($_SESSION["panier"])) {

        for ($i = 0; $i < count($_SESSION['panier']); $i++) {
            $totalPrixArticles += $_SESSION['panier'][$i]['prix'] * intval($_SESSION['panier'][$i]['quantite']);
        }
    }
    return $totalPrixArticles;
}

function affichageTotalPrixArticles()
{
    $totalPrixArticles = totalPrixArticles();

    if (isset($_SESSION["panier"])) {

        if ($_SESSION['panier']) {
            $totalPrixArticles = number_format($totalPrixArticles, 2, ',', ' ');
            echo "<p class=\"text-center totals total_articles\">Total des achats : <span>" . $totalPrixArticles . " €</span></p>";
        }
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
                                <img class=\"image_article\" src=\"ressources/images/" . $article['image'] . "\">
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

function connexion()
{
    extract($_POST);

    if (empty($email) || empty($motDePasse) || empty($motDePasse2)) {
        echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-white\"> Un ou plusieurs champs sont vides !</div>";
    } else {

        if (!($motDePasse == $motDePasse2)) {
            echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-lwhite\"> Les mots de passe sont différents !</div>";
        } else {
            $bdd = get_connection();

            $requete = $bdd->prepare('SELECT * FROM clients WHERE email=?');
            $requete->execute([strip_tags($email)]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);

            if (!$resultat) {
                echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-white\"> Adresse email INCONNUE !</div>";
            } else {
                $motDePassCorrect = password_verify($motDePasse, $resultat['mot_de_passe']);

                if (!$motDePassCorrect) {
                    echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-white\"> Le mot de passe est incorrect !</div>";
                } else {
                    $requete = $bdd->prepare('SELECT * FROM adresses WHERE id_client=?');
                    $requete->execute([$resultat['id']]);
                    $adresseClient = $requete->fetch(PDO::FETCH_ASSOC);

                    $_SESSION['id'] = $resultat['id'];
                    $_SESSION['nom'] = $resultat['nom'];
                    $_SESSION['prenom'] = $resultat['prenom'];
                    $_SESSION['email'] = $resultat['email'];
                    $_SESSION['adresse'] = $adresseClient;

                    echo "<div class=\"container msg msgOk w-50 text-center p-3 mt-2 bg-white\"> Bonjour " . $resultat['prenom'] . " " . $resultat['nom'] . ",<br>nous sommes ravis de vous revoir !</div>";
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

    if (strlen($_POST['email']) < 8 || strlen($_POST['email']) > 40) {
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

    if (!empty($nom) && !empty($prenom) && !empty($adresse) && !empty($codePostal) && !empty($ville) && !empty($email) && !empty($motDePasse) && !empty($motDePasse2)) {

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
                    'email' => strip_tags($email),
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

// <----- QUANTIE STOCK BDD ---------------->
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function newQuantityBdd($article)
{
    $bdd = get_connection();

    $query = $bdd->prepare('SELECT stock FROM articles where id = ?');
    $query->execute([$article['id']]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $quantityInStock = $result['stock'];

    $newQuantityInStock = $quantityInStock - $article['quantite'];

    $requete = $bdd->prepare('UPDATE articles SET stock = :newStock WHERE id = :id');
    $requete->execute([
        'newStock' => $newQuantityInStock,
        'id' => $article['id']
    ]);
}

// <----- affichage selon stock BDD ---------------->

function boutonStocks($stockArticle)
{
    if ($stockArticle == 0) {
        return "<p class=\"pt-2 pr-3 pb-2 pl-3 stockArticle articleEpuise\">Article épuisé<p>";
    } elseif ($stockArticle >= 1 && $stockArticle <= 10) {
        return "<p class=\"pt-2 pr-3 pb-2 pl-3 stockArticle articlePresqueEpuise\">Vite! Plus que " . $stockArticle . " <p>";
    } else {
        return "<p class=\"pt-2 pr-3 pb-2 pl-3 stockArticle articleEnstock\">En stock<p>";
    }
}

// <----- COMMANDES ---------------->
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// <----- TRANSMITION DE COMANDE VERS BDD ---------------->

function transmissionCommandeBdd()
{
    $bdd = get_connection();

    $numeroCommande = mt_rand(1000000, 9999999);
    $totalARegler = totalARegler();

    $requete = $bdd->prepare('INSERT INTO commandes (id__client, numero, date_commande, prix) VALUES (:id__client, :numero, :date_commande, :prix)');
    $transmissionCommandeBdd = $requete->execute([
        'id__client' => $_SESSION['id'],
        'numero' => $numeroCommande,
        'date_commande' => date("d-m-Y"),
        'prix' => $totalARegler
    ]);

    if ($transmissionCommandeBdd) {

        $idCommande = $bdd->lastInsertId();

        foreach ($_SESSION["panier"] as $article) {

            $requete = $bdd->prepare('INSERT INTO commande_articles (id_commande, id_article, quantite) VALUES (:id_commande, :id_article, :quantite)');
            $requete->execute([
                'id_commande' => $idCommande,
                'id_article' => $article['id'],
                'quantite' => $article['quantite'],
            ]);
            newQuantityBdd($article);
        }
    }
}

// <----- MON COMPTE ---------------->
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// <----- RECUPERER LES COMMANDES ---------------->

function recupererLesCommandes($id)
{
    $bdd = get_connection();

    $requete = $bdd->prepare('SELECT * FROM commandes WHERE id__client=?');
    $requete->execute(array($id));

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

// <----- AFFICHAGE DES COMMANDES ---------------->

function affichageDesCommandes($idClient)
{
    $bdd = get_connection();

    $listeCommandes = recupererLesCommandes($idClient);

    foreach ($listeCommandes as $commande) {

        $commande['prix'] = number_format($commande['prix'], 2, ',', ' ');

        echo "<tr class=\"text-center\">
                <td>n° " . $commande["numero"] . "</td>
                <td>" . $commande["date_commande"] . "</td>
                <td>" . $commande["prix"] . " €</td>
                <td>
                    <form action=\"detailsCommande.php\" method=\"post\">
                        <input type=\"hidden\" name=\"commandeId\" value=\"" . $commande["id"] . "\">
                        <input type=\"hidden\" name=\"commandeNumber\" value=\"" . $commande["numero"] . "\">
                        <input type=\"hidden\" name=\"commandeTotal\" value=\"" . $commande["prix"] . "\">
                        <input type=\"hidden\" name=\"commandeDate\" value=\"" . $commande["date_commande"] . "\">
                        <button type=\"submit\"  class=\"btn btn-dark\">Détails</button>
                    </form>
                </td>
              </tr>";
    }
}

// <-----RECUPRER LES DETAILS D'UNE COMMANDE---------------->

function recupererArticlesCommande($orderId)
{
    $bdd = get_connection();

    $query = $bdd->prepare('SELECT * FROM commande_articles ca INNER JOIN articles a ON a.id = ca.id_article WHERE id_commande = ?');
    $query->execute([$orderId]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// <-----AFFICHAGE DETAILS D'UNE COMMANDE---------------->

function affichageDetailsCommande($listeArticles)
{
    echo "<table class=\"table table-striped\">

            <thead class=\"thead-dark text-center\">
                <tr>
                    <th scope=\"col\">Article</th>
                    <th scope=\"col\">Prix</th>
                    <th scope=\"col\">Quantité</th>
                    <th scope=\"col\">Montant</th>
                </tr>
            </thead>
            <tbody class=\"text-center\">";

    $articlesQuantity = 0;

    foreach ($listeArticles as $article) {

        $articlesQuantity += $article['quantite'];

        echo "<tr>
                    <td>" . $article["nom"] . "</td>
                    <td>" . $article["prix"] . " € </td>
                    <td>" . $article["quantite"] . "</td>
                    <td>" . $article["prix"] * $article["quantite"] . " €</td>
                  </tr>";
    }

    echo "<tr>
                <td>Frais de port</td>
                <td>" .  number_format(12.49, 2, ',', 0)  . " €</td>
                <td> $articlesQuantity </td>
                <td>" .  number_format(12.49 * $articlesQuantity, 2, ',', 0)  . " €</td>
            </tr>
        </tbody>
    </table>";
}

// <----- RECUPERER LES INfOS CLIENT ---------------->

function recupererInfosClient($id)
{
    $bdd = get_connection();
    $query = $bdd->prepare('SELECT * FROM clients cl INNER JOIN adresses a ON a.id_client = cl.id WHERE cl.id = ?');
    $query->execute([$id]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// <-----AFFICHAGE DES INFOS CLIENT---------------->

function affichageDeSInfosClient($idClient)
{
    $infosClient = recupererInfosClient($idClient);

    foreach ($infosClient as $infos) {

        echo "<div class=\"container mb-5\">
                <div class=\"row mr-5 ml-5 pt-4 pb-4 justify-content-center formulaireInfosClient\">
                    
                    <h3 class=\"pb-3\">Si vous le souhaitez, vous pouvez modifier vos infos ici</h3>

                    <form action=\"mesInfos.php\" method=\"post\">
                        <div class=\"row pt-3 justify-content-center\">

                            <div class=\"col-md-5 pr-5\">
                                <div class=\"row mb-2 justify-content-end\">
                                    <p class=\"mr-2\">Nom : </p>
                                    <input class=\"text-center w-50\" type=\"text\" name=\"nom\" value=\"" . $infos['nom'] . "\" required>
                                </div>
                    
                                <div class=\"row mb-2 justify-content-end\">
                                    <p class=\"mr-2\">Prénom : </p>
                                    <input class=\"text-center w-50\" type=\"text\" name=\"prenom\" value=\"" . $infos['prenom'] . "\" required>
                                </div>

                                <div class=\"row mb-2 justify-content-end\">
                                    <p class=\"mr-2\">Adresse : </p>
                                    <input class=\"text-center w-50\" type=\"text\" name=\"adresse\" value=\"" . $infos['adresse'] . "\" required>
                                </div>

                                <div class=\"row mb-2 justify-content-end\">
                                    <p class=\"mr-2\">Code Postal : </p>
                                    <input class=\"text-center w-50\" type=\"text\" name=\"codePostal\" value=\"" . $infos['code_postal'] . "\" required>
                                </div>

                                <div class=\"row mb-2 justify-content-end\">
                                    <p class=\"mr-2\">Ville : </p>
                                    <input class=\"text-center w-50\" type=\"text\" name=\"ville\" value=\"" . $infos['ville'] . "\" required>
                                </div>
                            </div>

                            <div class=\"col-md-7 pl-5\">
                                <div class=\"row mb-4 justify-content-end\">
                                    <p class=\"mr-2\">Email : </p>
                                    <input class=\"text-center w-50\" type=\"email\" name=\"email\" value=\"" . $infos['email'] . "\" required>
                                </div>

                                <div class=\"row mb-4 justify-content-end\">
                                    <span class=\"mr-2 text-muted\">Veuillez renseigner votre mot de passe<br>avant de valider le(s) changement(s).</span>
                                </div>

                                <div class=\"row mb-2 justify-content-end\">
                                    <p class=\"mr-2\">Mot de passe : </p>
                                    <input class=\"text-center w-50\" type=\"password\" name=\"motDePasse\" placeholder=\"Votre mot de passe\" required>
                                </div>

                                <div class=\"row mb-2 justify-content-end\">
                                    <p class=\"mr-2\">Mot de passe : </p>
                                    <input class=\"text-center w-50\" type=\"password\" name=\"motDePasse2\" placeholder=\"Confirmez le M.D.P\" required>
                                </div>

                            </div>
                        </div>

                        <div class=\"row mt-3 justify-content-center\">
                            <input type=\"hidden\" name=\"addressId\" value=\"" . $infos['id'] . "\">
                            <button class=\"pt-1 pr-2 pb-1 pl-2 btnModifierInfos\" type=\"submit\" name=\"modifierInfos\">Modifier mes infos</button>
                        </div>
                   
                    </form> 

                </div>
            </div>";
    }
}

// <-----MODIFCATION DES INFOS CLIENT---------------->

function modificationInfosClient()
{
    extract($_POST);

    if (empty($nom) || empty($prenom) || empty($adresse) || empty($codePostal) || empty($ville) || empty($motDePasse) || empty($motDePasse2)) {
        echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-white\"> Un ou plusieurs champs sont vides !</div>";
    } else {

        if (!limiteCaracteresInputs()) {
            echo '<script>alert(\'Longueur d\'un ou plusieurs champs incorrect !\')</script>';
        } else {

            if (!($motDePasse == $motDePasse2)) {
                echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-lwhite\"> Les mots de passe sont différents !</div>";
            } else {
                $bdd = get_connection();

                $requete = $bdd->prepare('SELECT * FROM clients WHERE id=?');
                $requete->execute([strip_tags($_SESSION['id'])]);
                $resultat = $requete->fetch(PDO::FETCH_ASSOC);

                if (!$resultat) {
                    echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-white\"> Adresse email INCONNUE !</div>";
                } else {
                    $motDePassCorrect = password_verify($motDePasse, $resultat['mot_de_passe']);

                    if (!$motDePassCorrect) {
                        echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-white\"> Le mot de passe est incorrect !</div>";
                    } else {

                        $requete = $bdd->prepare('UPDATE clients SET nom = :nom, prenom = :prenom WHERE id = :id');
                        $modifInfosClientBdd = $requete->execute([
                            'nom' => $nom,
                            'prenom' => $prenom,
                            'id' => $_SESSION['id']
                        ]);

                        if (!$modifInfosClientBdd) {
                            echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-white\"> ECHEC Vos infos n'ont pas étés modifiées !</div>";
                        } else {
                            $query = $bdd->prepare('UPDATE adresses SET adresse = :adresse, code_postal = :code_postal, ville = :ville WHERE id = :id');
                            $query->execute(array(
                                'adresse' => $adresse,
                                'code_postal' => $codePostal,
                                'ville' => $ville,
                                'id' => $_POST['addressId']

                            ));
                            echo "<div class=\"container msg msgOk w-50 text-center p-3 mt-2 bg-white\"> Vos infos ont étés modifiées avec succès !</div>";
                        }
                    }
                }
            }
        }
    }
}

// <-----AFFICHAGE FORMULAIRE MODIF MOT DE PASSE CLIENT---------------->

function affichageModifMDPClient($idClient)
{
    $infosClient = recupererInfosClient($idClient);

    foreach ($infosClient as $infos) {

        echo "<div class=\"container mb-5\">
                <div class=\"row mr-5 ml-5 pt-4 pb-4 justify-content-center formulaireInfosClient\">
                    
                    <h3 class=\"pb-3\">Si vous le souhaitez, vous pouvez modifier votre mot de passe ici</h3>

                    <form action=\"mesInfos.php\" method=\"post\">
                        <div class=\"row pt-3 justify-content-center\">

                            <div class=\"col-md-6 pr-5 text-center\">
                                <p class=\"mr-2 mb-2\">Ancien mot de passe : </p>
                                <input class=\"text-center w-50 mb-2 pt-2 pb-2\" type=\"password\" name=\"motDePasse\" placeholder=\"Ancien M.D.P\" required>
                                <input class=\"text-center w-50 mb-2 pt-2 pb-2\" type=\"password\" name=\"motDePasse2\" placeholder=\"Confirmez l'ancien M.D.P\" required>
                            </div>

                            <div class=\"col-md-6 pl-5 text-center\">
                                <p class=\"mr-2 mb-2\">Nouveau mot de passe : </p>
                                <input class=\"text-center w-50 mb-2 pt-2 pb-2\" type=\"password\" name=\"newMotDePasse\" placeholder=\"Nouveau mot de passe\" required>
                                <input class=\"text-center w-50 mb-2 pt-2 pb-2\" type=\"password\" name=\"newMotDePasse2\" placeholder=\"Confirmez l'ancien M.D.P\" required>
                            </div>
                        </div>

                        <div class=\"row mt-3 justify-content-center\">
                            <input type=\"hidden\" name=\"motDePasseId\" value=\"" . $infos['id'] . "\">
                            <button class=\"pt-1 pr-2 pb-1 pl-2 btnModifierInfos\" type=\"submit\" name=\"modifierMDP\">Modifier mon mot de passe</button>
                        </div>

                    </form> 
                </div>
            </div>";
    }
}

// <-----MODIFCATION DU MOT DE PASSE CLIENT---------------->

function modificationMDPClient()
{
    extract($_POST);

    if (empty($motDePasse) || empty($motDePasse2) || empty($newMotDePasse) || empty($newMotDePasse2)) {
        echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-white\"> Un ou plusieurs champs sont vides !</div>";
    } else {

        if (!($motDePasse == $motDePasse2)) {
            echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-lwhite\"> Les champs de l'ancien mot de passe sont différents !</div>";
        } else {

            if (!($newMotDePasse == $newMotDePasse2)) {
                echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-lwhite\"> Les champs du nouveau mot de passe sont différents !</div>";
            } else {

                if (($motDePasse == $newMotDePasse)) {
                    echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-lwhite\"> L'ancien mot de passe et le nouveau sont iddentiques !</div>";
                } else {

                    $bdd = get_connection();

                    $requete = $bdd->prepare('SELECT * FROM clients WHERE id=?');
                    $requete->execute([strip_tags($_SESSION['id'])]);
                    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

                    if (!$resultat) {
                        echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-white\"> Adresse email INCONNUE !</div>";
                    } else {
                        $motDePassCorrect = password_verify($motDePasse, $resultat['mot_de_passe']);

                        if (!$motDePassCorrect) {
                            echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-white\"> Le mot de passe est incorrect !</div>";
                        } else {

                            $options = ['cost' => 12];
                            $hashpass = password_hash(strip_tags($newMotDePasse), PASSWORD_BCRYPT, $options);

                            $requete = $bdd->prepare('UPDATE clients SET mot_de_passe = :mot_de_passe');
                            $modifMDPBdd = $requete->execute([
                                'mot_de_passe' => $hashpass
                            ]);

                            if (!$modifMDPBdd) {
                                echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-white\"> ECHEC Vos infos n'ont pas étés modifiées !</div>";
                            } else {
                                echo "<div class=\"container msg msgOk w-50 text-center p-3 mt-2 bg-white\"> Votre mot de passe a été modifié avec succès !</div>";
                            }
                        }
                    }
                }
            }
        }
    }
}

// <-----AFFICHAGE DES INFOS CLIENT PAGE VALIDATION ---------------->

function affichageDeSInfosClientPageValidation($idClient)
{
    $infosClient = recupererInfosClient($idClient);

    foreach ($infosClient as $infos) {

        echo "<button type=\"button\" class=\"btn mt-5 btnModifierInfosPageValidation\" data-toggle=\"modal\" data-target=\"#modalModifInfosPageValidation\">
            Modifier mes infos
            </button>

            <div class=\"modal\" id=\"modalModifInfosPageValidation\" tabindex=\"-1\">
                <div class=\"modal-dialog\">
                    <div class=\"modal-content\">

                        <div class=\"mt-3 modal-header-center\">
                            <button type=\"button\" class=\"close mr-3\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">&times;</span>
                            </button>

                            <h5 class=\"modal-title\">Vous pouvez modifier vos infos ici</h5>
                        </div>

                        <form action=\"validation.php\" method=\"post\">

                            <div class=\"modal-body-center pr-5\">
                                
                                <div class=\"row mr-5 mb-2 justify-content-end\">
                                    <p class=\"mr-2\">Nom : </p>
                                    <input class=\"text-center w-50\" type=\"text\" name=\"nom\" value=\"" . $infos['nom'] . "\" required>
                                </div>
            
                                <div class=\"row mr-5 mb-2 justify-content-end\">
                                    <p class=\"mr-2\">Prénom : </p>
                                    <input class=\"text-center w-50\" type=\"text\" name=\"prenom\" value=\"" . $infos['prenom'] . "\" required>
                                </div>

                                <div class=\"row mr-5 mb-2 justify-content-end\">
                                    <p class=\"mr-2\">Adresse : </p>
                                    <input class=\"text-center w-50\" type=\"text\" name=\"adresse\" value=\"" . $infos['adresse'] . "\" required>
                                </div>

                                <div class=\"row mr-5 mb-2 justify-content-end\">
                                    <p class=\"mr-2\">Code Postal : </p>
                                    <input class=\"text-center w-50\" type=\"text\" name=\"codePostal\" value=\"" . $infos['code_postal'] . "\" required>
                                </div>

                                <div class=\"row mr-5 mb-4 justify-content-end\">
                                    <p class=\"mr-2\">Ville : </p>
                                    <input class=\"text-center w-50\" type=\"text\" name=\"ville\" value=\"" . $infos['ville'] . "\" required>
                                </div>

                                <div class=\"row mr-5 mb-4 justify-content-end\">
                                    <span class=\"mr-2 text-muted\">Veuillez renseigner votre mot de passe<br>avant de valider le(s) changement(s).</span>
                                </div>

                                <div class=\"row mr-5 mb-2 justify-content-end\">
                                    <p class=\"mr-2\">Mot de passe : </p>
                                    <input class=\"text-center w-50\" type=\"password\" name=\"motDePasse\" placeholder=\"Votre mot de passe\" required>
                                </div>

                                <div class=\"row mr-5 mb-2 justify-content-end\">
                                    <p class=\"mr-2\">Mot de passe : </p>
                                    <input class=\"text-center w-50\" type=\"password\" name=\"motDePasse2\" placeholder=\"Confirmez le M.D.P\" required>
                                </div>

                            </div>

                            <div class=\"modal-footer d-flex justify-content-center\">

                                <input type=\"hidden\" name=\"addressId\" value=\"" . $infos['id'] . "\">
                                <button type=\"submit\" class=\"mr-1 btn btnModifierInfos\" name=\"modifierInfosPageValidation\">Modifier et<br>revenir a la commande</button>
                            </div>

                        </form>

                </div>
            </div>
        </div>";
    }
}

function limiteCaracteresInputsAdresse()
{
    $longueurInputsOk = true;

    if (strlen($_POST['nom']) < 3 || strlen($_POST['nom']) > 25) {
        $longueurInputsOk = false;
    }

    if (strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 25) {
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

// <-----MODIFCATION DES INFOS CLIENT PAGE VALIDATION ---------------->

function modificationInfosClientPageValidation()
{
    extract($_POST);

    if (empty($nom) || empty($prenom) || empty($adresse) || empty($codePostal) || empty($ville) || empty($motDePasse) || empty($motDePasse2)) {
        echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-white\"> Un ou plusieurs champs sont vides !</div>";
    } else {

        if (!limiteCaracteresInputsAdresse()) {
            echo '<script>alert(\'Longueur d\'un ou plusieurs champs incorrect !\')</script>';
        } else {

            if (!($motDePasse == $motDePasse2)) {
                echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-lwhite\"> Les mots de passe sont différents !</div>";
            } else {
                $bdd = get_connection();

                $requete = $bdd->prepare('SELECT * FROM clients WHERE id=?');
                $requete->execute([strip_tags($_SESSION['id'])]);
                $resultat = $requete->fetch(PDO::FETCH_ASSOC);

                if (!$resultat) {
                    echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-white\"> Adresse email INCONNUE !</div>";
                } else {
                    $motDePassCorrect = password_verify($motDePasse, $resultat['mot_de_passe']);

                    if (!$motDePassCorrect) {
                        echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-white\"> Le mot de passe est incorrect !</div>";
                    } else {

                        $requete = $bdd->prepare('UPDATE clients SET nom = :nom, prenom = :prenom WHERE id = :id');
                        $modifInfosClientBdd = $requete->execute([
                            'nom' => $nom,
                            'prenom' => $prenom,
                            'id' => $_SESSION['id']
                        ]);

                        if (!$modifInfosClientBdd) {
                            echo "<div class=\"container msg msgDErreur w-50 text-center p-3 mt-2 bg-white\"> ECHEC Vos infos n'ont pas étés modifiées !</div>";
                        } else {
                            $query = $bdd->prepare('UPDATE adresses SET adresse = :adresse, code_postal = :code_postal, ville = :ville WHERE id = :id');
                            $query->execute(array(
                                'adresse' => $adresse,
                                'code_postal' => $codePostal,
                                'ville' => $ville,
                                'id' => $_POST['addressId']

                            ));
                            echo "<div class=\"container msg msgOk w-50 text-center p-3 mt-2 bg-white\"> Vos infos ont étés modifiées avec succès !</div>";
                        }
                    }
                }
            }
        }
    }
}
