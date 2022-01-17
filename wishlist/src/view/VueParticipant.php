<?php

namespace mywishlist\view;
use \mywishlist\controleurs\ControleurParticipant;
use \DateTime;

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
        // si l'image est une url on la met directement au lieu de chercher dans les images
        // stockees sur le serveur
        if(str_contains($infoItem->img, "http")){
            $image = "<img src='$infoItem->img' width='350px'>";
        }
        else{
            if(file_exists("img/".$infoItem->img)){
                $image = "<img src='/wishlist/img/$infoItem->img' width='350px'>";
            }
            else{
                $image = "<img src='/wishlist/img/no_image.jpg' width='350px'>";
            }
        }

        $contenu = $contenu . "<h1>$nomItem</h1>";
        $contenu = $contenu . "<p>$infoItem->descr</p>";
        $contenu = $contenu . "<p>$infoItem->tarif €</p>";
        $contenu = $contenu . "<p>Cet item appartient a la liste de token $tokenListe</p>";
        
        // on n oublie pas de mettre l image 
        $contenu = $contenu . $image . "</article>";

        // on met des underscore au lieu des espaces pour gerer les cookies
        $nomItem = str_replace(" ", "_", $nomItem);

        // le nom du cookie est compose du nom de l id item de l item et 
        // du token de la liste a la quelle 
        // il appartient
        $nomCookie = $infoItem->id . $nomItem . $tokenListe;

        // on recupere les dates du jour et d expiration de la liste
        $date_du_jour = new DateTime('now');
        $date_expiration = new DateTime($liste->expiration);

        // on met la zone de reservation que si l item est libre et que 
        // la liste est encore valable
        if(!isset($_COOKIE[$nomCookie]) && $date_du_jour < $date_expiration){
            $v = new VueParticipant();
            $zoneReserv = $v->ajouterZoneReservation($infoItem, $liste);
            $contenu = $contenu . $zoneReserv;
        }
        else if($date_du_jour >= $date_expiration){
            $contenu = $contenu . "<p>La liste est expiree donc on ne peut plus reserver l'item</p>";
        }
        else{
            $contenu = $contenu . "<div><p>L'item est deja reserve</p>";
            $msg = \mywishlist\models\Message::where('no_liste', '=', $liste->no)->where('id_item', '=', $infoItem->id)->first();
            if($msg->msg === ""){
                $contenu = $contenu . "<p>$msg->nom a utilisé son droit au silence</p></div>";
            }
            else{
                $contenu = $contenu . "<p>$msg->nom a dit : $msg->msg</p></div>";
            }
        }

        // on rajoute un petit bouton pour retourner rapidement a la liste
        $contenu = $contenu . "<a href=\"/wishlist/liste/$liste->token\"><button>Retourner à la liste</button></a>";

        return($contenu);
    }

    /**
     * fonction qui permet de rajouter une zone de reservation si 
     * l item n est pas reserve
     * @param mixed $item = item que l on veut reserver
     * @param mixed $liste = liste a la quelle est lie l item
     * @return string html contenant la zone de reservation
     */
    private function ajouterZoneReservation($item, $liste){

        // le nom de l item se compose de son nom et du token de sa liste
        $nomCookie = $item->id . $item->nom . $liste->token;
        // on met des underscore au lieu des espaces pour gerer les cookies
        $nomCookie = str_replace(" ", "_", $nomCookie);

        // on recupere le numero de la liste ainsi que son token
        $no_liste = $liste->no;
        $token = $liste->token;

        // le formulaire permettra aussi de set un cookie pour indiquer que l item est reserve
        $dateCourante = new DateTime('now');
        $dateEcheance = new DateTime($liste->expiration);
        $intvl = $dateCourante->diff($dateEcheance);
        
        // on calcul la duree du cookie de sorte qu il dure jusqu a l echeance de la liste
        $duree = $intvl->y *365.25*24*60*60 + $intvl->m*30*24*60*60 + $intvl->d*24*60*60;

        $html = <<<END
        
        <form id="f1" method="POST" action="/wishlist/AjouterMessageItem.php?nomCookie=$nomCookie&no_liste=$no_liste&token=$token&duree=$duree&id_item=$item->id">
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

        // si l'image est une url on la met directement au lieu de chercher dans les images
        // stockees sur le serveur
        if(str_contains($infoItem->img, "http")){
            $image = $infoItem->img;
        }
        else{
            if(file_exists("img/" . $infoItem->img)){
                $image = "/wishlist/img/" . $infoItem->img;
            }
            else{
                $image = "/wishlist/img/no_image.jpg";
            }
        }

        // on met une miage avec un lien vers l item en question
        $contenu = <<<END

            $contenu
            <a href="/wishlist/item/$id"><img src='$image' alt="image non disponible" width="350px"></a>
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

        // on recupere les dates du jour et d expiration de la liste
        $date_du_jour = new DateTime('now');
        $date_expiration = new DateTime($infoListe->expiration);

        // on prepare la page html a generer
        $html = "<article>";

        $html = $html . "<h1>Liste n°$infoListe->no</h1>";
        $html = $html . "<h2>$infoListe->titre</h2>";
        $html = $html . "<p>$infoListe->description</p>";

        // si la liste est expiree on le fait savoir
        if($date_du_jour >= $date_expiration){
            $html = $html . "<p id =\"expire\">Cette liste etait valable jusqu'au $infoListe->expiration</p>";
        }
        else{
            // sinon on met un message indiquant que la liste est encore dispo
            $html = $html . "<p id=\"pasexpire\">Cette liste est encore disponible jusqu'au $infoListe->expiration</p>";
        }

        $html = $html . "</article><article id=\"listeItem\">";

        // cette variable permettra d appeler les methodes de la classe
        $temp = new VueParticipant();

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

        <form id="f2" method="POST" action="/wishlist/AjouterMessageListe.php?no_liste=$no&token=$token">
            <label for"f2_nom">Votre nom : </label>
            <input type="text" placeholder="Ce champ est nécessaire" name="nom" required>
            </br>
            <label for="f2_message">Votre message</label>
            <input type="text" name="message" required>
            </br>
            <button type="submit">Ajouter message</button>
            
            </form>
        
        END;

        return($html);
    }

}