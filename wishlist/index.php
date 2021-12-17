<?php


require_once __DIR__ . '/vendor/autoload.php';

use mywishlist\bd\Eloquent;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

Eloquent::start('src/conf/conf.ini');

session_start();

if(!isset($_SESSION['typeGens'])){
    if(isset($_GET['typeGens'])){
        $_SESSION['typeGens'] = "admin";
    }
    else{
        $_SESSION['typeGens'] = "participant";
    }
}


$app = new \Slim\App();

$app->get('/item/{id}', 
    function (Request $rq, Response $rp, $args):Response{

        $control = new \mywishlist\controleurs\ControleurParticipant($this);
        return($control->page_un_item($rq, $rp, $args));

    }
);

$app->get('/liste/{token}', 
    function (Request $rq, Response $rp, $args):Response{
        $control = new \mywishlist\controleurs\ControleurParticipant($this);
        return($control->page_une_liste($rq, $rp, $args));
    }
);

$app->get('/liste/{id}/item', 
    function (Request $rq, Response $rp, $args):Response{
        $name = $args['id'];
        $rp->getBody()->write("Hello, items de la liste n° $name");
        return($rp);
    }
);


$app->run();