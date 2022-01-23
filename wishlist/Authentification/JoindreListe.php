<?php

require_once __DIR__ . '../../vendor/autoload.php';
use mywishlist\bd\Eloquent;
Eloquent::start('../src/conf/conf.ini');
session_start();


$user = \mywishlist\models\Utilisateurs::where('username', '=', $_SESSION['username'])->first();
$liste = \mywishlist\models\Liste::where('token', '=', $_POST['token']);
$liste->update(['user_id' => $user->id]);
header("Location: http://localhost/wishlist/utilisateurs/$user->username");
