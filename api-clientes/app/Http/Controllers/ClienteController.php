<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index(){
        return Cliente::all();
    }

    public function show($id){
        
        $cliente = Cliente::find($id);

        if(!$cliente){
            return response(['erro' => 'Cliente nao encontrado'], 404);
        }
        return response()->json($cliente);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|digits:11',
        ]);

        $cliente = Cliente::create($validated);

        return response()->json($cliente, 201); 
    }

    public function destroy($id){
        $cliente = Cliente::find($id);

        if(!$cliente){
            return response(['erro' => 'Cliente nao encontrado'], 404);
        }

        $cliente->delete();

        return response(['successo' => 'cliente apagado'], 200);
    }
}
