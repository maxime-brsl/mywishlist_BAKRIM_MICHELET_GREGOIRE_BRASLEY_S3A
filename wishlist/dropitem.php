<?php
require_once __DIR__ . '/vendor/autoload.php';
use mywishlist\bd\Eloquent;
Eloquent::start('src/conf/conf.ini');


try {
    //code...
    // on recupere l id de l item a supprimer
    $id_item = $_GET['id_item'];

    
    // on recupere l item dans la bdd
    $item = \mywishlist\models\Item::where('id', '=', $id_item)->first();
    // on recupere la liste de l item
    $liste = \mywishlist\models\Liste::where('no', '=', $item->liste_id)->first();
    
    // on retire l image que si ce n est pas l image vide
    if($item->img != "no_image.jpg"){
        
        // et on la retire si aucun autre item ne s en sert
        $items = \mywishlist\models\Item::where('img', '=', $item->img)->get();
        if($items->count() === 1){
            echo "image $item->img retiree";
            unlink("img/" . $item->img);
        }
        else{
            $n = $items->count();
            echo "on doit garder l image $item->img car $n items on l image";
        }
        
    }

    // on supprime enfin l item et son image dans le serveur
    $item->delete();
    
    // on redirige sur la liste d items
    header("Location: http://localhost/wishlist/liste/$liste->token");
    exit();
} catch (\Throwable $th) {
    echo $th;
}


?>