<?php

namespace mywishlist\controleurs;

class ControleurParticipant{

    /**
     * fonction qui permet de faire la page html d un item
     * @param string $id_item = id de l item concerne
     * @return mixed la page html de l item
     */
    public function page_un_item($id_item){
        $item_concerne = \mywishlist\models\Item::where('id', '=', $id_item)->first();
        $infos = explode(",", $item_concerne);
        $contenu = "<h1>Item n°$id_item</h1>";

        // on ajoute le contenu petit a petit
        foreach($infos as $v){

            $cle = explode(":", $v);
    
            // si on trouve l image alors il faut sauver l image pour l afficher apres
            if($cle[0] === "\"img\""){
                $image = explode("\"", $cle[1]);
            }
            else{
                // sinon on met l information directement 
                $information = explode("\"", $cle[1]);
                $contenu = $contenu . "<p> $information[1] </p>";
            }
        }
        
        // on n oublie pas de mettre l image si on en a trouve une
        $contenu = $contenu . "<img src='../img/$image[1]'>";
        $vue = new \mywishlist\view\VueParticipant();
        
        $pageHTML = $vue->PageHTML($contenu);
        return($pageHTML);
    }

    /**
     * fonction qui permet d afficher une liste selon un id
     * @param int $id_liste = id de la liste a afficher
     * @return mixed contenu de la liste
     */
    public function page_une_liste($id_liste){
        $liste_concernee = \mywishlist\models\Liste::where('id', '=', $id_liste)->first();
        $vue = new \mywishlist\view\VueParticipant();
        $contenu = "<p>$liste_concernee</p>";
        $pageHTML = $vue->PageHTML($contenu);
        return($pageHTML);
    }

}