<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Firebase\JWT\JWT;

class AlumnoMiddleware {

    public function __invoke (Request $request, RequestHandler $handler) {

        $valido = false;
        $token = $_SERVER['HTTP_TOKEN'];
        if(!empty($token))
        {
            $Key = "segundoparcial";
            try 
            {
                $decode = JWT::decode($token,$Key,array('HS256'));
                if($decode->tipo=="alumno")
                {
                    $valido=true;
                }
                

            } catch (\Throwable $th) 
            {
                $valido=false;

            }

        }
        //$jwt = true; // VALIDAR EL TOKEN

        if (!$valido) {
            $response = new Response();

            $rta = array("rta" => "Usted no es un alumno");

            $response->getBody()->write(json_encode($rta));

            return $response->withStatus(403);
        } else {
            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();

            $resp = new Response();
            $resp->getBody()->write($existingContent);

            return $resp;
        }

    }
}