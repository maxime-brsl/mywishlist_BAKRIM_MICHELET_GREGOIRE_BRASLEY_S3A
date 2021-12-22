<?php

namespace mywishlist\view;
use \mywishlist\controleurs\ControleurParticipant;

unset($_post['token']);
unset($_post['iditem']);

class VueParticipant{

    private static $renduPage = "";

    /**
     * fonction qui permet de generer une page html a partir d un contenu
     * @param string $contenuHTML = le contenu formate au codage html a afficher
     * @return string page html correspondant
     */
    public function pageHTML($contenuHTML){

        $render = self::$renduPage;
        $html = <<<END

        <!DOCTYPE html>
        <head>
            <meta charset="UTF-8">
            <title>Wishlist de phpMyAdmin</title>
            <link rel="stylesheet" href="./../css/$render">
        </head>
        <body>

            $contenuHTML

        </body>

        END;

        return($html);
    }

    /**
     * fonction qui permet de generer une page HTML pour un participant
     * @param string $contenu = le contenu de la page html
     * @return mixed page HTML avec le contenu
     */
    public function unItemHTML($infoItem){

        self::$renduPage = "renduItem.css";

        $contenu = "<article>";
        $nomItem = $infoItem->nom;
        $image = "<img src='../img/$infoItem->img'>";

        $contenu = $contenu . "<h1>$nomItem</h1>";
        $contenu = $contenu . "<p>$infoItem->descr</p>";
        $contenu = $contenu . "<p>$infoItem->tarif €</p>";
        
        // on n oublie pas de mettre l image si on en a trouve une
        $contenu = $contenu . $image . "</article>";

        // on met la zone de reservation que si l item est libre
        if(!isset($_COOKIE[$nomItem])){
            $v = new VueParticipant();
            $zoneReserv = $v->ajouterZoneReservation($nomItem);
            $contenu = $contenu . $zoneReserv;
        }
        else{
            $contenu = $contenu . "<p>L'item est deja reserve</p>";
        }

        return($contenu);
    }

    /**
     * fonction qui permet de rajouter une zone de reservation si 
     * l item n est pas reserve
     * @return string html contenant la zone de reservation
     */
    private function ajouterZoneReservation($nomItem){

        $html = <<<END

        <form id="f1" method="POST" action="/wishlist/redirect.php?nomItem=$nomItem">
                <h2>Cet article n'est toujours pas reservé</h2>
                <p>Peut-être voudriez vous remedier à ce problème ?</p>
                <label for="f1_nom">Nom : </label>
                <input type="text" placeholder="Ce champ est nécessaire" name="nom" required>
                </br>
                <label for="f1_msg">Un message pour le propriétaire ? : </label>
                <input type="text" name="msg">
                </br></br>
                <button type="submit">Reserver</button>
        </form>

        END;

        return($html);
    }

    /**
     * fonction qui permet de generer une page HTML d un item 
     * en moins detaille pour faire une liste 
     * @param string $contenu = le contenu de la page html
     * @return mixed page HTML avec le contenu
     */
    private function unItemHTMLPourListe($infoItem){
        $contenu = "<article>";

        $contenu = $contenu . "<h1>$infoItem->nom</h1>";
        $id = $infoItem->id;
        $image = $infoItem->img;

        // on met une miage avec un lien vers l item en question
        $contenu = <<<END

            $contenu
            <a href="/wishlist/item/$id"><img src=../img/$image alt="$image" width="350px"></a>
            </article>

        END;

        return($contenu);
    }

    /**
     * fonction qui permet de generer une page html pour une liste
     * @param mixed $infoListe = informations sur une liste 
     * @param mixed $items = liste d items a afficher
     * @return string une page html pour afficher la liste
     */
    public function uneListeHTML($infoListe, $items){

        self::$renduPage = "renduListe.css";
        $html = "<article>";

        $html = $html . "<h1>Liste n°$infoListe->no</h1>";
        $html = $html . "<h2>$infoListe->titre</h2>";
        $html = $html . "<p>$infoListe->description</p>";
        if(date("y.m.d") >= $infoListe->expiration){
            $html = $html . "<p id =\"expire\">Cette liste etait valable jusqu'au $infoListe->expiration</p>";
        }
        else{
            $html = $html . "<p id=\"pasexpire\">Cette liste est encore disponible</p>";
        }

        $html = $html . "</article><article id=\"listeItem\">";

        // cette variable permettra d appeler les methodes de la classe
        $temp = new VueParticipant();

        // on ajoute l affichage des items dans la liste 
        foreach($items as $v){
            $html = $html . $temp->unItemHTMLPourListe($v);
        }

        $html = $html . "</article>";

        return($html);

    }

}