<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/renduMain.css" />
</head>
<body>
<?php
require_once __DIR__ . '../../vendor/autoload.php';
use mywishlist\bd\Eloquent;
Eloquent::start('../src/conf/conf.ini');

try {
    $users = \mywishlist\models\Utilisateurs::all();
    foreach ($users as $u) {
        $titre = "";
        $listes = \mywishlist\models\Liste::where('user_id', '=', $u->id)->get();
        if(!$listes->isempty()) {
            foreach ($listes as $v) {
                $titre = $titre . " <br> " . $v->titre;
            }
            echo " <h2> $u->username possede comme liste(s) : </h2> $titre";
        }
    }
}
catch(Exception $e){
    echo $e;
}
?>
</body>
</html>

