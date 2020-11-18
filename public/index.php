<?php

use App\Controllers\InscripcionController;
use App\Controllers\MateriasController;
use \Firebase\JWT\JWT;
use Clases\Usuario;
use App\Middlewares\UserMiddleware;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\JsonMiddleware;
use App\Controllers\UserController;
use App\Middlewares\AlumnoMiddleware;
use App\Middlewares\tipoMiddleware;
use App\Middlewares\StringMiddleware;
use App\Middlewares\ClaveMiddleware;
use App\Middlewares\EmailMiddleware;
use App\Middlewares\PandAMiddleware;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Config\Database;

require __DIR__ . '/../vendor/autoload.php';
$app = AppFactory::create();
$app->setBasePath("/PHP/clase_8/public");
new Database();

//punto 1
$app->group('/users',function(RouteCollectorProxy $group){
    $group->post('[/]', UserController::class.":add")-> add(new tipoMiddleware)
    ->add(new ClaveMiddleware)->add(new EmailMiddleware)->add(new StringMiddleware);
     
});

//punto 2
$app->group('/login',function(RouteCollectorProxy $group){
    $group->post('[/]', UserController::class.":login");

});

//punto 3
$app->group('/materia',function(RouteCollectorProxy $group){
    $group->post('[/]', MateriasController::class.":add")->add(new AuthMiddleware);
    $group->get('[/]', MateriasController::class.":getAll");//punto 7
});
//punto 4
$app->group('/inscripcion',function(RouteCollectorProxy $group){
    $group->post('/id', InscripcionController::class.":add")->add(new AlumnoMiddleware);
    $group->get('/id', InscripcionController::class.":getAll")->add(new PandAMiddleware);
});

$app->add(new JsonMiddleware);

$app->run();