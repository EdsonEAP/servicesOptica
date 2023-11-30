<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescripcionController extends Controller
{
    public function insertPrescripcion(Request $request)
    {
        $id_cliente = $request->id_cliente;
        $esfera_od_lejos = $request->esfera_od_lejos;
        $cilindro_od_lejos = $request->cilindro_od_lejos;
        $eje_od_lejos = $request->eje_od_lejos;
        $agudeza_visual_od_lejos = $request->agudeza_visual_od_lejos;
        $esfera_oi_lejos = $request->esfera_oi_lejos;
        $cilindro_oi_lejos = $request->cilindro_oi_lejos;
        $eje_oi_lejos = $request->eje_oi_lejos;
        $agudeza_visual_oi_lejos = $request->agudeza_visual_oi_lejos;
        $esfera_od_cerca = $request->esfera_od_cerca;
        $cilindro_od_cerca = $request->cilindro_od_cerca;
        $eje_od_cerca = $request->eje_od_cerca;
        $agudeza_visual_od_cerca = $request->agudeza_visual_od_cerca;
        $esfera_oi_cerca = $request->esfera_oi_cerca;
        $cilindro_oi_cerca = $request->cilindro_oi_cerca;
        $eje_oi_cerca = $request->eje_oi_cerca;
        $agudeza_visual_oi_cerca = $request->agudeza_visual_oi_cerca;
        $lunas = $request->lunas;
        $monturas = $request->monturas;

        if (!$id_cliente) {
            return response()->json(["status" => false, "message" => "El id del cliente es requerido"], 200);
        }

        $body = [
            "id_cliente" => $id_cliente,
            "esfera_od_lejos" => $esfera_od_lejos ?? "",
            "cilindro_od_lejos" => $cilindro_od_lejos ?? "",
            "eje_od_lejos" => $eje_od_lejos ?? "",
            "agudeza_visual_od_lejos" => $agudeza_visual_od_lejos ?? "",
            "esfera_oi_lejos" => $esfera_oi_lejos ?? "",
            "cilindro_oi_lejos" => $cilindro_oi_lejos ?? "",
            "eje_oi_lejos" => $eje_oi_lejos ?? "",
            "agudeza_visual_oi_lejos" => $agudeza_visual_oi_lejos ?? "",
            "esfera_od_cerca" => $esfera_od_cerca ?? "",
            "cilindro_od_cerca" => $cilindro_od_cerca ?? "",
            "eje_od_cerca" => $eje_od_cerca ?? "",
            "agudeza_visual_od_cerca" => $agudeza_visual_od_cerca ?? "",
            "esfera_oi_cerca" => $esfera_oi_cerca ?? "",
            "cilindro_oi_cerca" => $cilindro_oi_cerca ?? "",
            "eje_oi_cerca" => $eje_oi_cerca ?? "",
            "agudeza_visual_oi_cerca" => $agudeza_visual_oi_cerca  ?? ""
        ];

        try {
            $valueBusquedaPrescripcion =  DB::table("cliente_medidas")->where("cliente_medidas.id_cliente", "=", $id_cliente)->get();
            if (count($valueBusquedaPrescripcion) == 0) {
                //Inserta a la bd las medidas y prescripcion
                $valueIdMedidas = DB::table('medidas')->insertGetId($body);
                $valueIdClienteMedidas = DB::table('cliente_medidas')->insertGetId([
                    "id_cliente" => $id_cliente,
                    "id_medida" => $valueIdMedidas
                ]);
                DB::table('prescripcion')->insert([
                    "id_cliente_medidas" => $valueIdClienteMedidas,
                    "lunas" => $lunas ?? "",
                    "monturas" => $monturas ?? "",
                    "fecha" => date("d-m-y")
                ]);
                return response()->json(["status" => true, "message" => 'Se insertó correctamente'], 200);
            }else{
                //Actualiza a la bd las medidas y prescripcion
                DB::table("medidas")
                    -> where("medidas.id_medidas", "=", $valueBusquedaPrescripcion[0]->id_medida)
                    ->update($body);
                DB::table('prescripcion')
                    ->where("prescripcion.id_cliente_medidas", "=", $valueBusquedaPrescripcion[0]->id_cliente_medidas)
                    ->update([
                        "lunas" => $lunas ?? "",
                        "monturas" => $monturas ?? "",
                        //"fecha" => date("d-m-y")
                    ]);
                return response()->json(["status" => true, "message" => "Se actualizó correctamente"], 200);
            }
        } catch (\Exception $e) {
            return response()->json(["status" => false, "message" => "Error al insertar prescripción", "error" => $e], 200);
        }
    }
}
