<?php

namespace mywishlist\view;
use \mywishlist\controleurs\ControleurParticipant;
use \DateTime;

class VueParticipant{

    private static $renduPage = "";
    private static $dureeEcheance = 0;

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
            <link rel="stylesheet" href="/wishlist/css/$render">
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
     * @param string $tokenListe = token de la liste a la quelle appartient l item
     * @return mixed page HTML avec le contenu
     */
    public function unItemHTML($infoItem, $tokenListe){

        self::$renduPage = "renduItem.css";

        if($tokenListe < 0){
            $contenu = <<<END

                <article>
                    <p>
                        L'item que vous avez selectionnez ne correpond pas à la liste indiquée
                        ou n existe pas.
                    </p>
                </article>
            
            END;

            return($contenu);

        }
        else if($tokenListe == 0){
            $contenu = <<<END

                <article>
                    <p>Oula, cet article n appartient a aucune liste</p>
                </article>
            
            END;

            return($contenu);
        }

        $contenu = "<article>";
        $nomItem = $infoItem->nom;
        $image = "<img src='/wishlist//img/$infoItem->img'>";

        $contenu = $contenu . "<h1>$nomItem</h1>";
        $contenu = $contenu . "<p>$infoItem->descr</p>";
        $contenu = $contenu . "<p>$infoItem->tarif €</p>";
        $contenu = $contenu . "<p>Cet item appartient a la liste de token $tokenListe</p>";
        
        // on n oublie pas de mettre l image si on en a trouve une
        $contenu = $contenu . $image . "</article>";

        // on met des underscore au lieu des espaces pour gerer les cookies
        $nomItem = str_replace(" ", "_", $nomItem);

        // on met la zone de reservation que si l item est libre
        if(!isset($_COOKIE[$nomItem.$tokenListe])){
            $v = new VueParticipant();
            $zoneReserv = $v->ajouterZoneReservation($nomItem.$tokenListe);
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

        $dureeCookie = self::$dureeEcheance;
        
        $html = <<<END
        
        <form id="f1" method="POST" action="/wishlist/redirect.php?nomItem=$nomItem&duree=3600">
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
            <a href="/wishlist/item/$id"><img src=/wishlist//img/$image alt="$image" width="350px"></a>
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

        // si la liste est expiree on le fait savoir
        if(date("y.m.d") >= $infoListe->expiration){
            $html = $html . "<p id =\"expire\">Cette liste etait valable jusqu'au $infoListe->expiration</p>";
        }
        else{
            // sinon on met un message indiquant que la liste est encore dispo
            $html = $html . "<p id=\"pasexpire\">Cette liste est encore disponible jusqu'au $infoListe->expiration</p>";
            /**
             * on calcul une duree de vie pour les cookies de reservation
             * il dureront jusqu a ce que la liste ne soit plus disponible
             */
            self::$dureeEcheance = strtotime(date("y.m.d")) - strtotime($infoListe->expiration);            
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