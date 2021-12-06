<?php


require_once __DIR__ . '/src/vendor/autoload.php';

use mywishlist\bd\Eloquent;

Eloquent::start('src/conf/conf.ini');


echo "connecte !! </br>";
echo "</br>";
echo "<a href=\"BDD.php\">Connexion base de donnees";
