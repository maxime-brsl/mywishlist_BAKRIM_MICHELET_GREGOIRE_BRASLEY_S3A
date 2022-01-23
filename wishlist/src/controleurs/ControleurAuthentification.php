<?php

namespace mywishlist\controleurs;

use mysql_xdevapi\Exception;

class ControleurAuthentification
{
    private $container;

    public function __construct($cont){
        $this->container = $cont;
    }

    /**
     * @param $rq
     * @param $rp
     * @param $args
     * @return mixed
     * fonction permettant de generer une page html liee a l'utilisateur particulier
     */
    public function page_connexion($rq, $rp, $args){
                    if($_SESSION['username'] === $args['username']) {
                        $vue = new \mywishlist\view\VueAuthentification();
                        $html = $vue->pageHTMLAuthentification();
                        $rp->getBody()->write($html);
                        return ($rp);
                    }
                    else{
                        $html = <<<END
                <!DOCTYPE html>
                <head>
                    <meta charset="UTF-8">
                    <title>Wishlist de phpMyAdmin</title>
                </head>
                <body>
                    <h1>Tu as voulu passer outre l'authentification en utilisant l'url bien tente petit filou...</h1>
                </body>
    
            END;
                        $rp->getBody()->write($html);
                        return ($rp);
                    }
    }



}
