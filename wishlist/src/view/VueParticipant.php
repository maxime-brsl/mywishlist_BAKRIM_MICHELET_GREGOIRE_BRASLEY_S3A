<?php

namespace mywishlist\view;
use \mywishlist\controleurs\ControleurParticipant;

class VueParticipant{

    /**
     * fonction qui permet de generer une page html a partir d un contenu
     * @param string $contenuHTML = le contenu formate au codage html a afficher
     * @return string page html correspondant
     */
    public function pageHTML($contenuHTML){

        $html = <<<END

        <!DOCTYPE html>
        <head>
            <meta charset="UTF-8">
            <title>Wishlist de phpMyAdmin</title>
            <link rel="stylesheet" href="./../css/rendu.css">
        </head>
        <body>

            $contenuHTML

            <script src="../js/listener.js"></script>
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

        $contenu = "";
        
        $infos = explode(",", $infoItem);
        
        // on ajoute le contenu petit a petit
        foreach($infos as $v){

            // on separe les cles des infos pour savoir si c le nom le prix etc
            $cle = explode(":", $v);

            $information = explode("\"", $cle[1]);
    
            // si on trouve l image alors il faut sauver l image pour l afficher apres
            if($cle[0] === "\"img\""){
                $image = "<img src='../img/$information[1]'>";
            }
            else if($cle[0] === "\"nom\""){
                $contenu = $contenu . "<h1 id=\"nomItem\"> $information[1] </h1>";
                $nomItem = str_replace(" ", "_", $information[1]);
            }
            else if($cle[0] === "\"tarif\""){
                $contenu = $contenu . "<p> tarif : $information[1] € </p>";
            }
            else{
                // sinon on met l information directement 
                $contenu = $contenu . "<p> $information[1] </p>";
            }
        }
        
        // on n oublie pas de mettre l image si on en a trouve une
        $contenu = $contenu . $image;

        // on met la zone de reservation que si l item est libre
        if(!isset($_COOKIE[$nomItem])){
            $v = new VueParticipant();
            $zoneReserv = $v->ajouterZoneReservation();
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
    private function ajouterZoneReservation(){
        $html = <<<END

            <article>
            <h2>Cet article n'est toujours pas reservee :sniff:</h2>
            <p>You can help by changing that</br>Mettez un petit message pour reserver :smooch:</p>
            <textarea id="msg" name="msg" rows="5" cols="33"></textarea>
            <button id="reservB">Reserver</button>

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

        $infos = explode(",", $infoItem);

        // on ajoute le contenu petit a petit
        foreach($infos as $v){

            // on separe les cles des infos pour savoir si c le nom le prix etc
            $cle = explode(":", $v);

            $information = explode("\"", $cle[1]);
    
            // si on trouve l image alors il faut sauver l image pour l afficher apres
            if($cle[0] === "\"img\""){
                $image = $information[1];
            }
            else if($cle[0] === "\"nom\""){
                $contenu = $contenu . "<h1> $information[1] </h1>";
            }
            else if($cle[0] === "{\"id\""){
                $id = $information[0];
            }
            
        }
        
        // on n oublie pas de mettre l image si on en a trouve une
        // et on penses a mettre le lien pour suivre l item en detail
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

        $html = "<article>";

        $informations = explode(",", $infoListe);

        // on affiche d abord les informations de la liste
        foreach($informations as $value){

            $cle = explode(":", $value);
            $infos = explode("\"", $cle[1]);

            if($cle[0] === "{\"no\""){
                $html = $html . "<h1>Liste n°$cle[1]</h1>";
            }
            else if($cle[0] === "\"titre\""){
                $html = $html . "<h2>$infos[1]</h2>";
            }
            else if($cle[0] === "\"expiration\""){
                if(date("y.m.d") >= $infos[1]){
                    $html = $html . "<p id=\"expire\">Cette liste etait valable jusqu au $infos[1]</p>";
                }
                else{
                    $html = $html . "<p id=\"pasexpire\">La liste est encore disponible</p>";
                }
            }
            else if($cle[0] != "\"token\""){
                $html = $html . "<p>$infos[1]</p>";
            }

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