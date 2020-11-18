<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
class TipoMiddleware {

    public function __invoke (Request $request, RequestHandler $handler) {
        $body = $request->getParsedBody();
        $tipo = $body['tipo'];
        $flag=true;
        if($tipo=="alumno"|| $tipo=="profesor" || $tipo=="admin")
        {
            $flag=false;
        }
        if ($flag) {
            $response = new Response();

            $rta = array("rta" => " mal escrito el tipo de miembro");

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