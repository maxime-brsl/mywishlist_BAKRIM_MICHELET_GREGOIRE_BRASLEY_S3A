<?php


require_once __DIR__ . '/vendor/autoload.php';

use mywishlist\bd\Eloquent;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

Eloquent::start('src/conf/conf.ini');

$app = new \Slim\App();

$app->get('/item/{id}', 
    function (Request $rq, Response $rp, $args):Response{
        $id = $args['id'];
        $control = new \mywishlist\controleurs\ControleurParticipant();
        $rp->getBody()->write($control->page_un_item($id));
        return($rp);
    }
);

$app->get('/liste/{id}', 
    function (Request $rq, Response $rp, $args):Response{
        $id = $args['id'];
        $control = new \mywishlist\controleurs\ControleurParticipant();
        $rp->getBody()->write($control->page_une_liste($id));
        return($rp);
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