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
        
        $vue = new \mywishlist\view\VueParticipant();
        
        $pageHTML = $vue->PageHTML($item_concerne);
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