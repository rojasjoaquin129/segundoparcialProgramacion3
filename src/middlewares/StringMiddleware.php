<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Models\User;
class StringMiddleware {

    public function __invoke (Request $request, RequestHandler $handler) {
        $body = $request->getParsedBody();
        $nombre = $body['nombre'];
        $flag=ctype_punct($nombre);
        
        $exist =  User::where('nombre', $nombre)->first();
        
        if ($flag || !empty($exist)) {
            $response = new Response();

            $rta = array("rta" => "nombre incorrecto o repetido");

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