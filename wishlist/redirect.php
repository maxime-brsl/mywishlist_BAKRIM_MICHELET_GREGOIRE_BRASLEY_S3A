<?php

$token = $_POST['token'];
$iditem = $_POST['iditem'];
$nom = $_POST['nom'];
$msg = $_POST['msg'];

if(isset($token)){
    header("Location: http://localhost/wishlist/liste/$token");
}
else if(isset($iditem)){
    header("Location: http://localhost/wishlist/item/$iditem");
}
else if(isset($nom)){
    
    $html = <<<END

    <!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <title>Wishlist de phpMyAdmin</title>
        <link rel="stylesheet" href="css/renduMain.css">
    </head>
    <body>

        <script>alert("Votre reservation a été ajoutée");</script>

    </body>

    END;
    echo $html;
    header("Location: http://localhost/wishlist/");
    
}
else{
    header("Location: http://localhost/wishlist/");
}

exit();
?>