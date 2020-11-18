<?php


/*
use \Firebase\JWT\JWT;
use Clases\Usuario;
use App\Middlewares\UserMiddleware;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\JsonMiddleware;
use App\Controllers\UserController;

use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Config\Database;

require __DIR__ . '/vendor/autoload.php';
$app = AppFactory::create();
$app->setBasePath("/PHP/clase_8");
new Database();

$app->group('/users',function(RouteCollectorProxy $group){

    $group->get('[/]', UserController::class.":getAll");

    $group->get('/{id}', UserController::class.":getOne");

    $group->post('[/]', UserController::class.":add");

    $group->put('/{id}', UserController::class.":update");

    $group->delete('/{id}', UserController::class.":delete");
     

})->add(new AuthMiddleware);

$app->add(new JsonMiddleware);

$app->run();
*/