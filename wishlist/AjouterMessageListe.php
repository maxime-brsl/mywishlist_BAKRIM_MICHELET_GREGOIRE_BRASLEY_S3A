<?php

/**
 * ce fichier permet d ajouter de maniere automatique un message publique sur une liste 
 * en filtrant les donnees recue lors d un transfert de formulaire 
 */

/**
 * on n oublie pas de refaire la connection a la BDD
 */
require_once __DIR__ . '/vendor/autoload.php';
use mywishlist\bd\Eloquent;
Eloquent::start('src/conf/conf.ini');

//on recupere le message du formulaire
$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
$nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
$liste = $_GET['no_liste'];
$token = $_GET['token'];

// on enregistre les donnees 
$insertion = new \mywishlist\models\Message();
$insertion->no_liste = $liste;
$insertion->id_item = -1;
$insertion->nom = $nom;
$insertion->msg = $message;
// on sauve le nouveau message dans la base de donnee
$insertion->save();
// enfin on redirige vers la page de la liste dont on vient
header("Location: http://localhost/wishlist/liste/$token");
exit();

?>