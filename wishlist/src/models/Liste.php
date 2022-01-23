<?php

namespace mywishlist\models;

/**
 * Script de creation de la table liste
 * 
 * CREATE TABLE `liste` (
 * `no` int(11) NOT NULL AUTO_INCREMENT,
 * `user_id` int(11) DEFAULT NULL,
 * `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 * `description` text COLLATE utf8_unicode_ci,
 * `expiration` date DEFAULT NULL,
 * `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
 * PRIMARY KEY (`no`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
 */

class Liste extends \Illuminate\Database\Eloquent\Model{

    protected $table = 'liste';
    protected $primarykey = 'no';
    public $timestamps = false;

    public function utilisateur(){
        return($this->belongsTo('\mywishlist\models\Utilisateurs', 'id'));
    }

}