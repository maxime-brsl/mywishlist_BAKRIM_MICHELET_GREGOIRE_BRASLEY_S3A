<?php

namespace mywishlist\view;

class VueModifListe{

    public function pageHTML($formulaire){
        $html = <<<END
        <!DOCTYPE html>
        <head>
            <meta charset="UTF-8">
            <title>Wishlist de phpMyAdmin</title>
            <link rel="stylesheet" href="/wishlist/css/renduListe.css">
        </head>
        <body>

            $formulaire

        </body>
        END;

        return($html);
    }


    /**
     * fonction qui permet de generer un formulaire pour modifier une liste
     * @param mixed $liste = liste que l on veut modifier
     * @return string formuaire html pour modifier la liste
     */
    public function formulaireModificationListe($liste){
        $html = <<<END

        <form id="fmodifliste" method="POST" enctype="multipart/form-data" action="/wishlist/modifyliste.php?token=$liste->token">
            <label>Nouveau nom de la liste :</label>
            <input ="text" name="newtitle">
            </br>
            <label>Nouvelle description de la liste :</label>
            <input ="text" name="newdesc" >
            </br>
            <label>Nouvelle date d'expiration (YYYY-MM-DD) :</label>
            <input ="text" name="newexp">
            </br>
            <button type="submit">Confirmer les modifications de la liste</button>
            <input type="button" value="Retourner à ma liste" onClick="history.go(-1);">
        </form>
        
        END;

        return($html);
    }
}