<?php

namespace mywishlist\models;


/**
 *
 * requete sql a taper pour creer la table cagnotte
 *
 * CREATE TABLE cagnotte(
 * item_id number(11),
 * liste_id number(11)
 * montant number(11),
 * user_id number(11),
 * FOREIGN KEY (item_id) REFERENCES item(id),
 * FOREIGN KEY (liste_id) REFERENCES liste(no)
 *    )
 *
 **/

class Cagnotte extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'cagnotte';
    public $timestamps = false;

}
