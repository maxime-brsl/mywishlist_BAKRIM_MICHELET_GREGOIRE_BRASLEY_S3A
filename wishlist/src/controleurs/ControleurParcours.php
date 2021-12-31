<?php

namespace mywishlist\controleurs;

class ControleurParcours{

    private $container;
    private $typeGens;

    /**
     * constructeur qui permet de specifier le container du controleur
     * @param mixed $container = conteneur ayant toutes les variables utiles
     */
    public function __construct($container){
        $this->container = $container;
        $this->typeGens = $_SESSION['typeGens'];
    }

    /**
     * fonction qui permet de faire la page html d un item
     * @param string $id_item = id de l item concerne
     * @return mixed la page html de l item
     */
    public function page_un_item($rq, $rp, $args){
        // on selectionne l item que l on veut dans la BDD
        $item_concerne = \mywishlist\models\Item::where('id', '=', $args['id'])->first();
        
        // on verifie si le token etait donnee dans l url
        if(isset($args['token'])){
            $liste = \mywishlist\models\Liste::where('token', '=', $args['token'])->first();
        }
        else{
            // sinon on recupere la liste automatiquement 
            $liste = \mywishlist\models\Liste::where('no', '=', $item_concerne->liste_id)->first();
        }

        // on creer une vue pour afficher la page HTML
        if($this->typeGens === "participant"){
            $vue = new \mywishlist\view\VueParticipant();
        }
        else if($this->typeGens === "proprio"){
            $vue = new \mywishlist\view\VueProprio();
        }
        
        $itemHTML = $vue->unItemHTML($item_concerne, $liste);
        $pageHTML = $vue->PageHTML($itemHTML);

        $rp->getBody()->write($pageHTML);
        return($rp);
    }

    /**
     * fonction qui permet d afficher une liste selon un id
     * @param int $id_liste = id de la liste a afficher
     * @param Requeste $rq = requete
     * @param Response $rp = reponse
     * @param array $args = tableau d arguments
     * @return mixed contenu de la liste
     */
    public function page_une_liste($rq, $rp, $args){
        
        // on recupere la liste concernee
        $liste_concernee = \mywishlist\models\Liste::where('token', '=', $args['token'])->first();
        // on recupere les items de la liste de souhaits
        $items_liste = \mywishlist\models\Item::where('liste_id', '=', $liste_concernee->no)->get();

        // on creer une vue pour afficher la page HTML
        if($this->typeGens === "participant"){
            $vue = new \mywishlist\view\VueParticipant();
        }
        else if($this->typeGens === "proprio"){
            $vue = new \mywishlist\view\VueProprio();
        }

        $listeHTML = $vue->uneListeHTML($liste_concernee, $items_liste);
        $pageHTML = $vue->PageHTML($listeHTML);

        $rp->getBody()->write($pageHTML);
        return($rp);
        
    }

}