<?php

require_once './src/vendor/autoload.php';

\mywishlist\bd\Eloquent::start("./src/conf/conf.ini");

$ligne = \mywishlist\models\Liste::get();

// affichage de l ensemble des liste d items
foreach($ligne as $kay => $value){
    echo "Liste n°" . $kay . "</br>";
    $infos = explode(",", $value);
    
    foreach($infos as $v){
        echo $v . "</br>";
    }

    echo "</br>";
}

echo "</br></br>";

$ligne = \mywishlist\models\Item::get();

//affichage de l ensemble des items
foreach($ligne as $kay => $value){
    echo "Item n°" . $kay . "</br>";
    $infos = explode(",", $value);
    
    foreach($infos as $v){

        $cle = explode(":", $v);

        if($cle[0] === "\"img\""){
            $image = explode("\"", $cle[1]);

            //echo $image[1] . "</br>";
            echo "<img src='./img/$image[1]'>";
        }
        else{
            echo $v . "</br>";
        }
    }

    echo "</br>";

}

echo "</br></br>";

if(isset($_GET['id'])){

    $ligne = \mywishlist\models\Item::where('id', '=', $_GET['id'])->first();
    echo $ligne;
    
}