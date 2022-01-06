<?php

// on filtre les donnees transmises dans les formulaires
$token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);
$iditem = filter_var($_POST['iditem'], FILTER_SANITIZE_STRING);

// ces quatres variables sont liees :
// le nom est forcement set si on reserve un item mais le message 
// n a peut etre aucun contenu
$nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
$msg = filter_var($_POST['msg'], FILTER_SANITIZE_STRING);
$nomItem = $_GET['nomItem'];
// on remplace les espace par des underscore pour pourvoir set un cookie
$nomItem = str_replace(" ", "_", $nomItem);
$duree = $_GET['duree'];

// si le nomItem est set cela indique que l on a reserver un item
if(isset($nomItem) && $duree > 0){

    // on met un cookie sur l item concerne
    // le nom est compose du nom de l item et du token de la liste
    // ainsi on s assure que l on parle d un item d une liste
    setcookie($nomItem, $msg, time() + $duree, "/");

    // enfin on redirige l utilisateur sur la page principale
    header("Location: http://localhost/wishlist/");
}
else if(isset($_POST['token'])){
    // si le token est set cela indique que l on voulait aller sur une liste
    // en revanche il faut savoir si on veut ajouter un item ou juste consulter la liste
    if(isset($_GET['ajout'])){
        header("Location: http://localhost/wishlist/liste/$token/add/item");
    }
    else{
        header("Location: http://localhost/wishlist/liste/$token");
    }
}
else if(isset($_POST['iditem'])){
    // si l iditem est set cela indique que l on voulait aller sur un item
    header("Location: http://localhost/wishlist/item/$iditem");
}

exit();
?>