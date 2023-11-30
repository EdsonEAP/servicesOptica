<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function createUser(Request $request){
        $nombre_usuario = $request->nombre_usuario;
        $clave = $request->clave;
        $pregunta_recuperacion = $request->pregunta_recuperacion;
        $respuesta = $request->respuesta;
        $estado = 'Activo';

        if(!$nombre_usuario || !$clave || !$pregunta_recuperacion || !$respuesta){
            return response()->json(["status" => false, "message" => "Los campos son requeridos"], 200);
        }

        
    }
}
