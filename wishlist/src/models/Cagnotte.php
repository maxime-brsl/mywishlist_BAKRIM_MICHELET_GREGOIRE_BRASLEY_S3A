<?php

namespace mywishlist\models;


/**
 *
 * requete sql a taper pour creer la table cagnotte
 *
 * CREATE TABLE cagnotte(id_item int(11), montant int(11),
 *
 **/

class Cagnotte extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'cagnotte';
    public $timestamps = false;

}
