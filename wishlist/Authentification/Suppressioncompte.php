<?php

require_once __DIR__ . '../../vendor/autoload.php';
use mywishlist\bd\Eloquent;
Eloquent::start('../src/conf/conf.ini');
session_start();

$username = $_SESSION['username'];
$user = \mywishlist\models\Utilisateurs::where('username', '=', $username)->first();
$listes = \mywishlist\models\Liste::where('user_id', '=', $user->id);
foreach ($listes->get() as $l) {
    $items = \mywishlist\models\Item::where('liste_id', '=', $l->id);
    foreach ($items->get() as $i) {
        $msg = \mywishlist\models\Message::where('no_liste', '=', $l->id)->where('id_item','=',$i->id);
        $msg->delete();
    }
    $items->delete();
}
$listes->delete();
$user->delete();
session_destroy();
header("Location: http://localhost/wishlist/");

