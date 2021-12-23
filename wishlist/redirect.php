<?php

// on filtre les donnees transmises dans les formulaires
$token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);
$iditem = filter_var($_POST['iditem'], FILTER_SANITIZE_STRING);

// ce trois variables sont liees
// le nom est forcement set si on reserve un item mais le message 
// n a peut etre aucun contenu
$nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
$msg = filter_var($_POST['msg'], FILTER_SANITIZE_STRING);
$nomItem = $_GET['nomItem'];

if(isset($nomItem)){
    // si le nomItem est set cela indique que l on a reserver un item

    // on met un cookie sur l item concerne
    setcookie($nomItem, $nom . " a ecrit : " . $msg, time() + 60*60, "/");

    // enfin on redirige l utilisateur sur la page principale
    header("Location: http://localhost/wishlist/");
}
else if(isset($_POST['token'])){
    // si le token est set cela indique que l on voulait aller sur une liste
    header("Location: http://localhost/wishlist/liste/$token");
}
else if(isset($_POST['iditem'])){
    // si l iditem est set cela indique que l on voulait aller sur un item
    header("Location: http://localhost/wishlist/item/$iditem");
}

exit();
?>