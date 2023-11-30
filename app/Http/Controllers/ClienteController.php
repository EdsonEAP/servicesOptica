<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    //Api para buscar cliente por nombre
    public function searchCliente(Request $request)
    {
        $valueSearch = $request->value;
        if ($valueSearch == null || $valueSearch == "") {
            return response()->json(["status" => false, "message" => "El campo es requerido"], 200);
        }
        $clientes =  DB::table("cliente")
            ->where("cliente.nombres_y_apellidos", "like", "%" . $valueSearch . "%")
            ->get();
        if (count($clientes) !== 0) {
            return response()->json(["status" => true, "message" => "Se encontraron resultados", "data" => $clientes], 200);
        } else {
            return response()->json(["status" => false, "message" => "No se encontraron resultados"], 200);
        }
    }

    //Api para insertar cliente
    public function insertCliente(Request $request)
    {
        $valueNombreCompleto = $request->nombreCompleto;
        $valueTelefono = $request->telefono;
        $valueDireccion = $request->direccion;
        $valueEdad = $request->edad;
        //Validaciones de que no sea vacio o null
        if (
            $valueNombreCompleto == null || $valueNombreCompleto == "" || $valueTelefono == null || $valueTelefono == "" || $valueDireccion == null || $valueDireccion == ""
            || $valueEdad == null || $valueEdad == ""
        ) {
            return response()->json(["status" => false, "message" => "Los campos son requerido"], 200);
        }
        //Validaciones de los campos
        if (is_numeric($valueNombreCompleto)) {
            return response()->json(["status" => false, "message" => "El nombre no puede tener números"], 200);
        }
        if (!is_numeric($valueTelefono)) {
            return response()->json(["status" => false, "message" => "El teléfono debe ser numérico"], 200);
        }
        if (!is_numeric($valueEdad)) {
            return response()->json(["status" => false, "message" => "La edad debe ser numérico"], 200);
        }

        try {
            DB::table("cliente")->insert([
                "nombres_y_apellidos" => $valueNombreCompleto,
                "telefono" => $valueTelefono,
                "direccion" => $valueDireccion,
                "edad" => $valueEdad
            ]);
            return response()->json(["status" => true, "message" => "Registro de cliente insertado correctamente"], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => false, "message" => "Error al insertar registro de cliente", "error" => $e], 200);
        }
    }

    
}
