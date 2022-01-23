<?php

require_once __DIR__ . '/vendor/autoload.php';
use mywishlist\bd\Eloquent;
Eloquent::start('src/conf/conf.ini');

$token = $_GET['token'];
$ntitre = filter_var($_POST['newtitle'], FILTER_SANITIZE_STRING);
$ndesc = filter_var($_POST['newdesc'], FILTER_SANITIZE_STRING);
$nexp = filter_var($_POST['newexp'], FILTER_SANITIZE_STRING);

$liste = \mywishlist\models\Liste::where('token', '=', $token);

if($ntitre != ""){
    $liste->update(['titre' => $ntitre]);
}

if($ndesc != ""){
    $liste->update(['description' => $ndesc]);
}

if($nexp != ""){
    $liste->update(['expiration' => $nexp]);
}


header("Location: http://localhost/wishlist/liste/$token");
exit();