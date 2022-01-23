<?php

namespace mywishlist\models;

/**
 *
 * requete sql a taper pour creer la table utilisateurs
 *
 * CREATE TABLE utilisateurs (
 * username varchar(100) NOT NULL PRIMARY KEY,
 * password varchar(100) NOT NULL )
 */

class Utilisateurs extends \Illuminate\Database\Eloquent\Model{

    protected $table = 'utilisateurs';
    protected $primarykey = 'username';
    public $timestamps = false;

}

