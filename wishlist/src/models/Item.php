<?php

namespace mywishlist\models;

/**
 * Script de creation de la table item
 * 
 * CREATE TABLE `item` (
 * `id` int(11) NOT NULL AUTO_INCREMENT,
 * `liste_id` int(11) NOT NULL,
 * `nom` text NOT NULL,
 * `descr` text,
 * `img` text,
 * `url` text,
 * `tarif` decimal(5,2) DEFAULT NULL,
 * PRIMARY KEY (`id`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 */

class Item extends \Illuminate\Database\Eloquent\Model{

    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function liste(){
        return($this->belongsTo('\mywishlist\models\Liste', 'no'));
    }

}