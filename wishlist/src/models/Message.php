<?php

namespace mywishlist\models;

/**
 * 
 * requete sql a taper pour creer la table message
 * 
 * CREATE TABLE Message(
 *    no_liste int(11),
 *    id_item int(11),
 *    msg varchar(100),
 *    FOREIGN KEY (no_liste) REFERENCES liste(no)
 *    )
 */

class Message extends \Illuminate\Database\Eloquent\Model{

    protected $table = 'message';
    public $timestamps = false;

}