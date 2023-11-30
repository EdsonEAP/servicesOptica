<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PrescripcionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/searchCliente', [ClienteController::class, 'searchCliente']);

Route::post('/inserCliente', [ClienteController::class, 'insertCliente']);

Route::post('/insertPrescripcion',[PrescripcionController::class,'insertPrescripcion']);

Route::post('/createUser',[UserController::class, 'createUser']);
// Route::get('/clienteMedidas/{id_cliente}', function ($id_cliente) {
//     $clienteMedidas =  DB::table("cliente_medidas")
//         ->where("cliente_medidas.id_cliente", $id_cliente)
//         //->select("cliente.*")
//         ->join("cliente", "cliente_medidas.id_cliente", "=", "cliente.id_cliente")
//         ->join("medidas", "cliente_medidas.id_medida", "=", "medidas.id_medidas")
//         ->get();
//     return response()->json(["status" => true, "message" => "Medida encontrada", "data" => $clienteMedidas], 200);
// });

