<?php
require_once __DIR__ . '../../vendor/autoload.php';
use mywishlist\bd\Eloquent;
Eloquent::start('../src/conf/conf.ini');

try {
    $users = \mywishlist\models\Utilisateurs::all();
    foreach ($users as $u) {
        $titre = "";
        $virgule = " ";
        $listes = \mywishlist\models\Liste::where('user_id', '=', $u->id)->get();
        if(!$listes->isempty()) {
            foreach ($listes as $v) {
                $titre = $titre . $virgule . $v->titre;
                $virgule = ' , ';
            }
            echo " $u->username possede comme liste(s) : $titre <br> ";
        }
    }
}
catch(Exception $e){
    echo $e;
}

