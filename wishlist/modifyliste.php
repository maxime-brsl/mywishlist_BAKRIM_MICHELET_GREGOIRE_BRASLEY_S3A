<?php

require_once __DIR__ . '/vendor/autoload.php';
use mywishlist\bd\Eloquent;
Eloquent::start('src/conf/conf.ini');

$token = $_GET['token'];
$ntitre = filter_var($_POST['newtitle'], FILTER_SANITIZE_STRING);
$ndesc = filter_var($_POST['newdesc'], FILTER_SANITIZE_STRING);
$nexp = filter_var($_POST['newexp'], FILTER_SANITIZE_STRING);

$liste = \mywishlist\models\Liste::where('token', '=', $token)->first();

if($ntitre != ""){
    $liste->titre = $ntitre;
}

if($ndesc != ""){
    $liste->description = $ndesc;
}

if($nexp != ""){
    $liste->expiration = $nexp;
}

$liste->save();

header("Location: http://localhost/wishlist/liste/$token");
exit();