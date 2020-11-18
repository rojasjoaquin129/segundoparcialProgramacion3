<?php
namespace App\Controllers;

use App\Models\User;
use \Firebase\JWT\JWT;
class UserController
{
   public  function getAll ($request, $response, $args) {
       $rta=User::get();//trae todos ;
    //find(numero de id) compara y trae si lo encuentra ;
        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public  function getOne ($request,$response, $args) {
        $response->getBody()->write("getOne");
        return $response;
    }
    public  function add ($request, $response, $args) {
        $user = new User;
        $user['nombre'] = $request->getParsedBody()['nombre'] ?? '';
        $user['clave'] = $request->getParsedBody()['clave'] ?? '';
        $user['tipo'] = $request->getParsedBody()['tipo'] ?? '';
        $user['email'] = $request->getParsedBody()['email'] ?? '';
        $rta=$user->save();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public  function update  ($request,  $response, $args) {
        //arg es lo q podes pedir para modificar 
        $id=$args['id'];
        $user=User::find($id);
        $user->nombre="peter";
        $rta=$user->save();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public  function delete ( $request, $response, $args) {
        $id=$args['id'];
        $user=User::find($id);
        $rta=$user->delete();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function login ($request,  $response) 
    {

        $body = $request->getParsedBody();
        $email = $body['email'];
        $clave = $body['clave'];

        $exist =  User::where('email', $email)->first();

        if(!empty($exist)){
           //verigficar contravceña

           //$pass = password_verify( $clave, $exist->clave); // boolean
           //echo $pass;
           $usuario = json_decode($exist);
          // var_dump($usuario);
          // die();
           if($exist->clave == $clave)
           {
                $Key = "segundoparcial";
                $payload = array(   
                    "id" => $usuario->id,
                    "email" => $usuario->email,
                    "nombre" => $usuario->nombre,
                    "tipo" => $usuario->tipo
                );
                $jwt = JWT::encode($payload,$Key);

                $rta = array("TOKEN" => $jwt);
                $response->getBody()->write(json_encode($rta));
            }else{
                $rta = array("ERROR" => "LOGIN INCORRECTO");
                $response->getBody()->write(json_encode($rta));
            }    
        }else
        {
            $rta = array("ERROR" => "EMAIL NO EXISTE");
            $response->getBody()->write(json_encode($rta));
        } 
        
        return $response;
    }

}