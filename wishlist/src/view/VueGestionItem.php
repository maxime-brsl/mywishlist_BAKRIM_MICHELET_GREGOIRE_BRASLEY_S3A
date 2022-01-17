<?php

namespace mywishlist\view;

class VueGestionItem{

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
     * fonction qui permet de generer le formulaire d ajout d item
     * @param mixed $liste = liste concernee par l ajout d item
     * @return string morceau html contenant le formulaire
     */
    public function formulaireReservation($liste){
        $html = <<<END

        <form id="fajoutvitem" method="POST" enctype="multipart/form-data" action="/wishlist/additem.php?no_liste=$liste->no">
            <label>Nom de l'item :</label>
            <input ="text" name="nomitem" placeholder="Ce champs est requis" required>
            </br>
            <label>Description de l'item :</label>
            <input ="text" name="descritem" placeholder="Ce champs est requis" required>
            </br>
            <label>Prix de l'item (maximum 999,99€):</label>
            <input ="number" name="prixitem" placeholder="Ce champs est requis" required>
            </br>
            <label>URL du magasin pour acheter l'item (optionel) :</label>
            <input ="text" name="url">
            </br>
            <label>Vous pouvez également ajouter une image avec l'url de l'image : </label>
            <input type="text" name="url_img" id="img">
            </br>
            <label>Uploader une image : </label>
            <input type="file" name="file_img" id="img">
            </br>
            <button type="submit">Confirmer l'ajout de l'item</button>
        </form>

        <a href="/wishlist/liste/$liste->token"><button>Retourner à ma liste</button></a>
            
        END;

        return($html);
    }

    /**
     * fonction qui permet de generer un formulaire pour modifier un item
     * @param mixed $item = item que l on veut modifier
     * @return string formuaire html pour modifier l item
     */
    public function formulaireModificationItem($item){
        $html = <<<END

        <form id="fajoutvitem" method="POST" enctype="multipart/form-data" action="/wishlist/modifyitem.php?id_item=$item->id">
            <label>Nouveau nom de l'item :</label>
            <input ="text" name="nomitem">
            </br>
            <label>Nouvelle descrption de l'item :</label>
            <input ="text" name="descritem" >
            </br>
            <label>Prix de l'item (maximum 999,99€):</label>
            <input ="number" name="prixitem">
            </br>
            <label>URL du magasin pour acheter l'item (optionel) :</label>
            <input ="text" name="url">
            </br>
            <label>Vous pouvez également ajouter une image avec l'url de l'image : </label>
            <input type="text" name="url_img" id="img">
            </br>
            <label>Uploader une image : </label>
            <input type="file" name="file_img" id="img">
            </br>
            <button type="submit">Confirmer les modifications de l'item</button>
            <input type="button" value="Retourner au Home" onClick="history.go(-1);">
        </form>
        
        END;

        return($html);
    }

}