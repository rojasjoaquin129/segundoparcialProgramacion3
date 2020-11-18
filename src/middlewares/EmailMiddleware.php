<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Slim\Factory\AppFactory;
use App\Models\User;
class EmailMiddleware {

    public function __invoke (Request $request, RequestHandler $handler) {
        $app = AppFactory::create();
        $body = $request->getParsedBody();
        $email = $body['email'];
        $exist =  User::where('email', $email)->first();
        if (!empty($exist)) {
            $response = new Response();

            $rta = array("rta" => "el email ya esta en la lista");

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