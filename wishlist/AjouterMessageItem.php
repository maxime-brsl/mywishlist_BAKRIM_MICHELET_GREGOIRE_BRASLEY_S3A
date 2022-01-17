<?php

/**
 * ce fichier permet d ajouter de maniere automatique un message publique sur un item 
 * en filtrant les donnees recue lors d un transfert de formulaire 
 */

/**
 * on n oublie pas de refaire la connection a la BDD
 */
require_once __DIR__ . '/vendor/autoload.php';
use mywishlist\bd\Eloquent;
Eloquent::start('src/conf/conf.ini');

//on recupere le message du formulaire
$message = filter_var($_POST['msg'], FILTER_SANITIZE_STRING);
$nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
$no_liste = $_GET['no_liste'];
$iditem = $_GET['id_item'];
$token = $_GET['token'];
$duree = $_GET['duree'];
$nomCookie = $_GET['nomCookie'];

// on enregistre les donnees 
$insertion = new \mywishlist\models\Message();
$insertion->no_liste = $no_liste;
$insertion->id_item = $iditem;
$insertion->nom = $nom;
$insertion->msg = $message;
// on sauve le nouveau message dans la base de donnee
$insertion->save();

// on set un cookie pour indiquer que la reservation est prise en compte
setcookie($nomCookie, "reserve", time() + $duree, "/");

// enfin on redirige vers la page de la liste dont on vient
header("Location: http://localhost/wishlist/item/$iditem");
exit();

?>