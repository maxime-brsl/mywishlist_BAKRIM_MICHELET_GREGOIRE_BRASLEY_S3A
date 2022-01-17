<?php

namespace mywishlist\view;

use \DateTime;

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
            $image = "<img src='$infoItem->img' width='350px'>";
        }
        else{
            if(file_exists("img/" . $infoItem->img)){
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

        // on prepare une variable temporaire pour appeler les methode de la classe
        $temp = new VueProprio();
        
        // on met la zone concernant la reservatin de l item
        $contenu = $contenu . $temp->ajouterZoneMessage($liste, $infoItem);

        // on rajoute le formulaire de gestion des items qui permet de modifier/supprimer un item
        // uniquement si l item n est pas reserve
        $message = \mywishlist\models\Message::where('no_liste', '=', $liste->no)->where('id_item', '=', $infoItem->id)->first();
        if(!isset($message)){
            $contenu = $contenu . $temp->genererFormulaireGestion($infoItem, "item");
        }

        // on rajoute un petit bouton pour retourner a la liste
        $contenu = $contenu . "<a href=\"/wishlist/liste/$liste->token\"><button>Retourner à la liste</button></a>";

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

        // on recupere les dates d expiration de la liste et la date du jour
        $date_du_jour = new DateTime('now');
        $date_expiration = new DateTime($liste->expiration);
        
        $message = \mywishlist\models\Message::where('no_liste', '=', $liste->no)->where('id_item', '=', $item->id)->first();
        $msg = "";

        // si la liste n est pas a echeance on ne met que si l item est resrve ou non
        if($date_du_jour < $date_expiration){
            
            if(!isset($message)){
                $msg = "Votre item n'est toujours pas reservé.";
            }
            else{
                $msg = "Oh, on dirait qu'une âme charitable s'est portée volontaire ^^.";
            }
        }
        else{

            // sinon on met un petit message avec toutes les informations necessaires
            if(!isset($message)){
                $msg = "Sniff, personne n'a voulu vous faire plaisir et n'a pris votre item.";
            }
            else if($message->msg === ""){
                $msg = "Vous allez avoir votre item ^^. </br>" . $message->nom . " n'a rien écrit quand il a reservé";
            }
            else{
                $msg = "Vous allez avoir votre item ^^. </br>" . $message->nom . " a écrit \"" . $message->msg . "\" quand il a reservé";
            }
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
            // si l image existe on est content
            if(file_exists("img/" . $infoItem->img)){
                $image = "/wishlist/img/" . $infoItem->img;
            }
            else{
                // sinon on met une image par defaut
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
        if(!isset($infoListe)){
            return("<h2>Cette liste n'existe pas</h2>");
        }
        
        // on recupere les dates d expiration de la liste et la date du jour
        $date_du_jour = new DateTime('now');
        $date_expiration = new DateTime($infoListe->expiration);

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
        $temp = new VueProprio();

        // on ajoute l affichage des items dans la liste 
        foreach($items as $v){
            $html = $html . $temp->unItemHTMLPourListe($v);
        }

        $html = $html . "</article>";

        $html = $html . $temp->ajouterZoneMessageListe($infoListe);

        // on rajoute le formulaire d ajout d item sur la liste
        $html = $html . $temp->genererFormulaireGestion($infoListe, "liste");

        // on rajoute un petit bouton pour retourner au menu
        $html = $html . "<a href=\"/wishlist/\"><button>Retourner au main</button></a>";

        return($html);
    }

    /**
     * fonction qui permet de generer un petit formulaire pour que le proprio gere sa liste
     * @param mixed $objet = liste/item concernee
     * @param string $tyeGestion = type de formulaire a generer 
     *                          liste = formulaire pour ajouter un item 
     *                          item = formulaire pour modifier/supprimer un item
     * @return string formulaire html
     */
    private function genererFormulaireGestion($objet, $typeGestion){
        if($typeGestion === "liste"){

            $html = <<<END

            <article>
                Voulez vous modifier un peu votre liste ?
                
                <form id="fajoutitem" method="GET" action="/wishlist/liste/$objet->token/add/item">
                <button type="submit">Rajouter un item à ma liste</button>
                </form>

            </article>

            END;

            return($html);
        }
        else if($typeGestion === "item"){

            $html = <<<END

            <article>
                Voulez vous modifier un peu votre item ?

                <form id="fmodifitem" action="/wishlist/item/$objet->id/modify">
                    <button type="submit">Modifier cet item</button>
                </form>

                <form id="fdeleteitem" method="POST" action="/wishlist/dropitem.php?id_item=$objet->id">
                    <input name='useless' hidden>
                    <button type="submit">Supprimer l'item de ma liste</button>
                </form>

            </article>


            END;

            return($html);
        }
        else{
            return("");
        }
        
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