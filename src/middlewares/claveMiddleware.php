<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class ClaveMiddleware {

    public function __invoke (Request $request, RequestHandler $handler) {
        $body = $request->getParsedBody();
        $nombre = $body['clave'];

        $flag=true;
        if(strlen($nombre)>=4)
        {
            $flag=false;
        }
        if ($flag) {
            $response = new Response();

            $rta = array("rta" => "no hay cantidad minima de caracteres para la clave ");

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