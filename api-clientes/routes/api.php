<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PerguntaController;
use App\Http\Controllers\RespostaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\RespostaClienteController;

Route::apiResource('clientes', ClienteController::class);
Route::apiResource('perguntas', PerguntaController::class);
Route::apiResource('respostas', RespostaController::class);
Route::apiResource('categorias', CategoriaController::class);
Route::apiResource('respostas-clientes', RespostaClienteController::class);
Route::get('respostas-por-cliente/{clienteId}', [RespostaController::class, 'respostasPorCliente']);