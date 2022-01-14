<?php
namespace mywishlist\controleurs;

class ControleurGestion{

    private $container;

    public function __construct($cont){
        $this->container = $cont;
    }

    /**
     * fonction qui permet de generer le formulaire d ajout d un item dans la base de donnee
     * @param array $args = arguments de la page
     */
    public function genererFormulaireAjoutItem($rq, $rp, $args){
        // on recupere la liste concernee par l ajout d item
        $liste = \mywishlist\models\Liste::where('token', '=', $args['token'])->first();

        // on va generer le formulaire de la page pour ajouter un item
        $vue = new \mywishlist\view\VueGestionItem();
        $form = $vue->formulaireReservation($liste);
        $pageHTML = $vue->pageHTML($form);
        
        // on ecrit ce formulaire dans la page html 
        $rp->getBody()->write($pageHTML);
        return($rp);
    }

    /**
     * fonction qui permet de generer le formulaire de modification d un item
     */
    public function genererForulaireModificationItem($rq, $rp, $args){

        // on recupere l'item concerne par cette modification
        $item = \mywishlist\models\Item::where('id', '=', $args['iditem'])->first();

        // on va generer le formulaire 
        $vue = new \mywishlist\view\VueGestionItem();
        $form = $vue->formulaireModificationItem($item);
        $pageHTML = $vue->pageHTML($form);

        // on ecrit ce formulaire
        $rp->getBody()->write($pageHTML);
        return($rp);
    }

}