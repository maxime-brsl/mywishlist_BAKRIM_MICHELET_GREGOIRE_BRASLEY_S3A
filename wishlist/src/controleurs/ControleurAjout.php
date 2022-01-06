<?php
namespace mywishlist\controleurs;

class ControleurAjout{

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
        $vue = new \mywishlist\view\VueAjoutItem();
        $form = $vue->formulaireReservation($liste);
        $pageHTML = $vue->pageHTML($form);
        
        // on ecrit ce formulaire dans la page html 
        $rp->getBody()->write($pageHTML);
        return($rp);
    }

}