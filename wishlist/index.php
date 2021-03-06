<?php

require_once __DIR__ . '/vendor/autoload.php';

use mywishlist\bd\Eloquent;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/*********************
 *
 * Partie dediee a slim pour gerer les routes urls
 * et demarage d eloquent pour gerer la BDD
 *
 ********************/

Eloquent::start('src/conf/conf.ini');

session_start();

/**
 * lignes provisoires permettant de tester rapidement
 * le POV participant et le POV proprietaire de liste
 */
//$_SESSION['typeGens'] = "participant";
$_SESSION['typeGens'] = "proprio";

$app = new \Slim\App();

/****************************************
 *
 * Partie dediee a la navigation au sein du site
 *
 *****************************************/

$app->get('/item/{id}',
    function (Request $rq, Response $rp, $args):Response{

        $control = new \mywishlist\controleurs\ControleurParcours($this);
        return($control->page_un_item($rq, $rp, $args));

    }
);


$app->get('/liste/{token}',
    function (Request $rq, Response $rp, $args):Response{

        $control = new \mywishlist\controleurs\ControleurParcours($this);
        return($control->page_une_liste($rq, $rp, $args));
    }
);

$app->get('/liste/{token}/item/{id}',
    function (Request $rq, Response $rp, $args):Response{

        $control = new \mywishlist\controleurs\ControleurParcours($this);
        return($control->page_un_item($rq, $rp, $args));
    }
);

/*********************************************
 *
 * partie dediee a la modification des informations/contenu :
 * Ajout de liste, items
 * Modifications
 * etc ...
 *
 **********************************************/

$app->get('/liste/{token}/add/item',
    function (Request $rq, Response $rp, $args):Response{

        $control = new \mywishlist\controleurs\ControleurGestion($this);
        return($control->genererFormulaireAjoutItem($rq, $rp, $args));
    }
);

$app->get('/liste/{token}/modify',
    function (Request $rq, Response $rp, $args):Response{
        $control = new \mywishlist\controleurs\ControleurGestion($this);
        return ($control->genererForulaireModificationListe($rq, $rp, $args));
    }
);

$app->get('/item/{iditem}/modify',
    function (Request $rq, Response $rp, $args):Response{
    $control = new \mywishlist\controleurs\ControleurGestion($this);
    return ($control->genererForulaireModificationItem($rq, $rp, $args));
}
);




    /*****************************
 *
 * Partie dediee a l'authenfication
 * il consiste a diriger l'utilisateur vers son espace
 *
 ****************************/
$app->get('/utilisateurs/{username}',
    function (Request $rq, Response $rp, $args):Response{

        $control = new \mywishlist\controleurs\ControleurAuthentification($this);
        return($control->page_connexion($rq, $rp, $args));
    }
);


/*****************************
 *
 * Partie dediee a l affichage du main
 * il consiste en un menu simple qui permet de se diriger vers l affichage d une liste
 * ou d un item
 *
 ****************************/
$app->get('/',
    function(Request $rq, Response $rp, $args):Response{
        $html = <<<END

            <!DOCTYPE html>
            <head>
                <meta charset="UTF-8">
                <title>Wishlist de phpMyAdmin</title>
                <link rel="stylesheet" href="css/renduMain.css">
            </head>
            <body>

                 <h1>MyWishList</h1>
                <h2>Bienvenue sur le projet MyWishList d'un groupe de 4 ??tudiants, r??alis?? en PHP</h2>
                
                <p>
                Ce projet consiste ?? la gestion de listes de souhaits. </br>
                Un participant ?? une liste pourra r??server un item, tandis que le propri??taire d'une 
                liste pourra ajouter des items, les modifier si ils ne sont pas encore r??serv??s, etc ...
                </p>
                <button><a href="/wishlist/Authentification/login.php">Se Connecter</a></button>
                <button><a href="/wishlist/Authentification/register.php">S'Enregistrer</a></button>

                <article>
                    <h3>Que voulez vous faire ?</h3>
                    <div id="choix">
                        <button id="blist">Consulter une liste</button>
                        <button id="bitem">Consulter un item</button>
                        <button id="baddlist">Ajouter une liste</button>
                        <button id="bcreercagnotte" >Cr??er une cagnotte</button>
                    </div>
                </article>

                <form id="fitem" method="POST" action="/wishlist/Authentification/login.php">
                    <label>Numero de l'item</label>
                    <input ="text" name="iditem">
                    <button type="submit" class="action">Chercher l'item</button>
                </form>

                <form id="flist" method="POST" action="/wishlist/Authentification/login.php">
                    <label>Token de la liste</label>
                    <input ="text" name="token">
                    <button type="submit" class="action">Chercher la liste</button>
                </form>
                
                <form id="faddlist" method="POST" action="/wishlist/Authentification/login.php">
                    <label>Titre :</label>
                    <input ="text" name="title">
                    <label>Description :</label>
                    <input ="text" name="desc">
                    <label>Date d'expiration (YYYY-MM-DD) :</label>
                    <input ="text" name="exp">
                    <button type="submit" class="action">Ajouter la liste</button>
                </form>
                
                <form id="fcreercagnotte" method="POST" action="/wishlist/Authentification/login.php">
                    <label>ID de l'item :</label>
                    <input ="text" name="id_item">
                    <label>Montant :</label>
                    <input ="text" name="prix">
                    <button type="submit" class="action">Cr??er la cagnotte</button>
                </form>
                    <a href="/wishlist/credits.php"><button>Cr??dits</button></a>
                <script src="js/listener.js"></script>
            </body>

        END;

        $rp->getBody()->write($html);
        return($rp);
    }
);

$app->run();
