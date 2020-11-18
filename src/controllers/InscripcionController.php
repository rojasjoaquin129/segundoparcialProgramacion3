<?php
namespace App\Controllers;
use Firebase\JWT\JWT;
use App\Models\Inscripcion;
use App\Models\Materia;
use App\Models\User;
use Slim\Factory\AppFactory;
$app = AppFactory::create();
class InscripcionController
{

    public function getALL( $request, $response, $args) {

        $inscripcion =  Inscripcion::where('materia_id', $args['idMateria'] )->get();

        $alumnos = [];
        for ($i=0; $i < count($inscripcion); $i++) { 
            if($inscripcion[$i] ){
                $nombre =  User::where('id', $inscripcion[$i]->alumno_id)->first();
                array_push($alumnos, $nombre->nombre);
            }
        }


        $response->getBody()->write(json_encode($alumnos));
        return $response;
    }


    public  function add ($request, $response, $args) {

        $Key = "segundoparcial";
        $token = $_SERVER['HTTP_TOKEN'];
        $decode = JWT::decode($token,$Key,array('HS256'));    
        
        $incripcion = new Inscripcion;

        $existMateria =  Materia::where('id', $args['idMateria'] )->first();
        //echo $existMateria;
        //die();
        if(empty($existMateria)){ // si  existe
            
            $result =  array("ERROR" => "NO EXISTE LA MATERIA");
            $response->getBody()->write(json_encode($result));
        }else{

            if($existMateria->vacantes > 0){
                $incripcion->alumno_id = $decode->id;
                $incripcion->materia_id = $existMateria->id;
    
                $incripcion->save();

                $existMateria->vacantes --;
                $existMateria->save();
                
                $result = array("True" => $incripcion);
                $response->getBody()->write(json_encode($result));

            }else{
               
                $result= array("ERROR" => "NO HAY CUPOS");
                $response->getBody()->write(json_encode($result));
            }
           
        }
        

        return $response;
    }

}
    

