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
$_SESSION['typeGens'] = "participant";
//$_SESSION['typeGens'] = "proprio";

$app = new \Slim\App();


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
 * partie dediee a la modification de la BDD en dur : 
 * Ajout de liste, items
 * Modifications
 * etc ...
 * 
 **********************************************/

$app->get('/liste/{token}/add/item', 
    function (Request $rq, Response $rp, $args):Response{

        $control = new \mywishlist\controleurs\ControleurAjout($this);
        return($control->genererFormulaireAjoutItem($rq, $rp, $args));
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

                <h1>Bondour !!!</h1>
                <h2>Bienvenue sur le projet PHP wishlist d'un groupe d'étudiants</h2>
                

                <article>
                    <h3>Que voulez vous faire ?</h3>
                    <div id="choix">
                        <button id="blist">Consulter une liste</button>
                        <button id="bitem">Consulter un item</button>
                        <button id="bajoutitem">Ajouter un item a une liste</button>
                        <button id="baddlist">Ajouter une liste</button>
                        <button id="bcreercagnotte">Créer une cagnotte</button>
                    </div>
                </article>

                <form id="fitem" method="POST" action="/wishlist/redirect.php">
                    <label>Numero de l'item</label>
                    <input ="text" name="iditem">
                    <button type="submit">Chercher l'item</button>
                </form>

                <form id="flist" method="POST" action="/wishlist/redirect.php">
                    <label>Token de la liste</label>
                    <input ="text" name="token">
                    <button type="submit">Chercher la liste</button>
                </form>

                <form id="fajoutitem" method="POST" action="/wishlist/redirect.php?ajout='oui'">
                    <label>Token de la liste</label>
                    <input ="text" name="token">
                    <button type="submit">Valider la liste à la quelle ajouter un item</button>
                </form>
                
                <form id="faddlist" method="POST" action="/wishlist/AjouterListe.php">
                    <label>Titre :</label>
                    <input ="text" name="title">
                    <label>Description :</label>
                    <input ="text" name="desc">
                    <label>Date d'expiration (YYYY-DD-MM) :</label>
                    <input ="text" name="exp">
                    <button type="submit">Ajouter la liste</button>
                </form>
                
                <form id="fcreercagnotte" method="POST">
                    <label>ID de l'item :</label>
                    <input ="text" name="id_item">
                    <label>Montant :</label>
                    <input ="text" name="prix">
                    <button type="submit">Créer la cagnotte</button>
                </form>
                    
                <script src="js/listener.js"></script>
            </body>

        END;

        $rp->getBody()->write($html);
        return($rp);
    }
);

$app->run();
