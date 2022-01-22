<?php

require_once __DIR__ . '/vendor/autoload.php';
use mywishlist\bd\Eloquent;
Eloquent::start('src/conf/conf.ini');

/**
 * le but de ce fichier est de rajouter des items a une liste deja existante 
 */


$id_item = $_GET['id_item'];
$nom_item = filter_var($_POST['nomitem'], FILTER_SANITIZE_STRING);
$descr_item = filter_var($_POST['descritem'], FILTER_SANITIZE_STRING);
$prix_item = filter_var($_POST['prixitem'], FILTER_SANITIZE_NUMBER_FLOAT);
$url = filter_var($_POST['url'], FILTER_SANITIZE_STRING);

$nom_image = "";

// on verifie si une url a ete passe pour l image
// on privilegie les url aux upload pour le moment car plus simple
if(isset($_POST['url_img']) && $_POST['url_img'] != ""){
    $nom_image = filter_var($_POST['url_img'], FILTER_SANITIZE_URL);
}
else if(isset($_FILES["file_img"])){
    // si une image etait donnee par upload on va verifier qu elle est recevable
    $image_name = $_FILES['file_img']['name'];
    $image_temp_name = $_FILES['file_img']['tmp_name'];
    $image_type = $_FILES['file_img']['type'];
    $repertoire = "img/";
    $fichierAutorisee = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");

    // on verifie l extension
    $extension = pathinfo($image_name, PATHINFO_EXTENSION);
    if(array_key_exists($extension, $fichierAutorisee)){
        
        // on verifie le type de fichier
        if(in_array($image_type, $fichierAutorisee)){

            if(file_exists($repertoire . $image_name)){
                // si le fichier existe deja on va faire un peu la meme technique que Windows
                $indice = 1;
                $nom_image = '(' . $indice . ')' . $image_name;
                while(file_exists($repertoire . $nom_image)){
                    $indice += 1;
                    $nom_image = '(' . $indice . ')' . $image_name;
                }

                // on deplace le fichier vers le repertoire d images une fois le bon nom trouve
                if(move_uploaded_file($image_temp_name, $repertoire . $nom_image)){
                    echo "fichier envoye";
                }
                else{
                    echo "fichier non envoye";
                }
            }
            else{
                $nom_image = $image_name;
                // on deplace le fichier vers le repertoire d images
                if(move_uploaded_file($image_temp_name, $repertoire . $nom_image)){
                    echo "fichier envoye";
                }
                else{
                    echo "fichier non envoye";
                }
            }
        }
    }
}

// une fois les donnees recuperees et filtrees on peut les modifier dans la table
$item = \mywishlist\models\Item::where('id', '=', $id_item)->first();
// on verifie chaque attribut pour ne modifier que ce qui a ete reellement change
if($nom_item != ""){
    $item->nom = $nom_item;
}
if($descr_item != ""){
    $item->descr = $descr_item;
}
if($prix_item != "" && $prix_item != $item->tarif){
    $item->tarif = $prix_item;
}
if($url != $item->url){
    $item->url = $url;
}
if($nom_image != ""){

    // on supprime l'ancienne image si personne d autre ne s en sert et si ce n est pas l image vide
    if($item->img != "no_image.jpg"){
        $items = \mywishlist\models\Item::where('img', '=', $item->img)->get();
        if($items->count() === 1){
            unlink("img/" . $item->img);
        }
    }

    // et on met la nouvelle
    $item->img = $nom_image;
}

// on peut enfin sauvegarder l item
$item->save();
header("Location: http://localhost/wishlist/item/$id_item");
exit();

?>