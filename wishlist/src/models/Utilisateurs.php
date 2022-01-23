<?php

namespace mywishlist\models;

/**
 *
 * requete sql a taper pour creer la table utilisateurs
 *
 * CREATE TABLE utilisateurs (
 * id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 * username varchar(100) NOT NULL,
 * password varchar(100) NOT NULL )
 */

class Utilisateurs extends \Illuminate\Database\Eloquent\Model{

    protected $table = 'utilisateurs';
    protected $primarykey = 'id';
    public $timestamps = false;

}

