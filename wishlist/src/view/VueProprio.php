<?php

namespace mywishlist\view;

class VueProprio{

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
    public function unItemHTML($infoItem, $liste){

        self::$renduPage = "renduItem.css";
        $tokenListe = $liste->token;

        // si le no de la liste est different de celui de l item on le fait savoir
        if($liste->no != $infoItem->liste_id){
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

        // si le liste_id d un item est a 0 cela indique qu il n appartient a aucune liste
        if($infoItem->liste_id == 0){
            $contenu = <<<END

                <article>
                    <p>Oula, cet article n appartient a aucune liste</p>
                </article>
            
            END;

            return($contenu);
        }

        $contenu = "<article>";
        $nomItem = $infoItem->nom;

        // on verifie si l image de l item est un url ou non
        if(str_contains($infoItem->img, "http")){
            $image = "<img src='$infoItem->img'>";
        }
        else{
            $image = "<img src='/wishlist/img/$infoItem->img'>";
        }

        $contenu = $contenu . "<h1>$nomItem</h1>";
        $contenu = $contenu . "<p>$infoItem->descr</p>";
        $contenu = $contenu . "<p>$infoItem->tarif €</p>";
        $contenu = $contenu . "<p>Cet item appartient a la liste de token $tokenListe</p>";

        // on n oublie pas de mettre l image
        $contenu = $contenu . $image . "</article>";
        
        // si la liste n est pas expiree on ne met pas les messages sur l item
        if($liste->expiration > date("y.m.d")){
            $zone = <<<END
                <article>
                    <p>
                        Votre liste n'est pas encore arrivé a expiration. </br>
                        Soyez patient, vous saurez si vous avez eu votre item une fois la liste expirée.
                    </p>
                </article>
            END;

            $contenu = $contenu . $zone;
        }
        else{
            // sinon on en met un
            $temp = new VueProprio();
            $contenu = $contenu . $temp->ajouterZoneMessage($liste, $infoItem);
        }

        return($contenu);
    }

    /**
     * fonction qui pemet d ajouter le message de reservation si il y en a eu une 
     * pour que le proprio voir ce que les participants ont pu ecrire
     * @param mixed $liste = liste concernee par la reservation
     * @param mixed $item = item concernee par la reservation
     * @return string morceau html qui contient les infos necessaires
     */
    private function ajouterZoneMessage($liste, $item){
        
        $message = \mywishlist\models\Message::where('no_liste', '=', $liste->no)->where('id_item', '=', $item->id)->first();
        $msg = "";

        // si il n y a pas de nom c que l item n a pas ete reserve car le nom est 
        // obligatoire pour envoyer le formulaire
        if($message->nom === null){
            $msg = "Sniff, personne n'a voulu vous faire plaisir et n'a pris votre item.";
        }
        else if($message->msg === ""){
            $msg = "Vous allez avoir votre item ^^. </br>" . $message->nom . " n'a rien écrit quand il a reservé";
        }
        else{
            $msg = "Vous allez avoir votre item ^^. </br>" . $message->nom . " a écrit \"" . $message->msg . "\" quand il a reservé";
        }


        $html = <<<END

        <article>
            <p>$msg</p>
        </article>

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

        // on verifie si l image est un url ou une image stockee
        if(str_contains($infoItem->img, "http")){
            $image = $infoItem->img;
        }
        else{
            $image = "/wishlist/img/" . $infoItem->img;
        }

        // on met une miage avec un lien vers l item en question
        $contenu = <<<END

            $contenu
            <a href="/wishlist/item/$id"><img src='$image' alt="$image" width="350px"></a>
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
        }

        $html = $html . "</article><article id=\"listeItem\">";

        // cette variable permettra d appeler les methodes de la classe
        $temp = new VueProprio();

        // on ajoute l affichage des items dans la liste 
        foreach($items as $v){
            $html = $html . $temp->unItemHTMLPourListe($v);
        }

        $html = $html . "</article>";

        $html = $html . $temp->ajouterZoneMessageListe($infoListe);

        return($html);
    }

    /**
     * fonction qui permet d ajouter une zone de messages sur la liste
     * il y aura un formulaire pour ajouter des messages 
     * ainsi que les messages deja ecrits
     * @param mixed $liste = liste sur la quelle ajouter cette zone de messages
     * @return string zone html qui contient la zone de messages
     */
    private function ajouterZoneMessageListe($liste){

        $no = $liste->no;
        $token = $liste->token;

        $messages = \mywishlist\models\Message::where('no_liste', '=', $no)->where('id_item', '<', 0)->get();
        $msg = "";

        // on recupere les messages deja ecrits 
        foreach($messages as $v){
            $msg = $msg . "<li>" . $v->nom . " a écrit : " . $v->msg . "</li>";
        }

        $html = <<<END

        <article>

        <h2>Les participants communiquent</h2>
        <p>Ceci est le resultats de leurs dires</p>
        $msg

        </article>
        
        END;

        return($html);
    }

}