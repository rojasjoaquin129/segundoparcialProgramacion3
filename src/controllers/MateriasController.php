<?php
namespace App\Controllers;

use App\Models\Materia;

class MateriasController
{
    public  function getAll ($request, $response, $args) {
        $rta=Materia::get();//trae todos ;
     //find(numero de id) compara y trae si lo encuentra ;
         $response->getBody()->write(json_encode($rta));
         return $response;
     }


    public  function add ($request, $response, $args) {
        $user = new Materia();
        $user['nombre'] = $request->getParsedBody()['materia'] ?? '';
        $user['cupos'] = $request->getParsedBody()['cupos'] ?? '';
        $user['cuatrimestre'] = $request->getParsedBody()['cuatrimestre'] ?? '';
        $rta=$user->save();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }

}