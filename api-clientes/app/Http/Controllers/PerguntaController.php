<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pergunta;

class PerguntaController extends Controller
{
   
    public function index(){
        return Pergunta::all();
    }

    public function show($id){
        $pergunta = Pergunta::find($id);

        if(!$pergunta){
            return response(['erro' => 'Pergunta nao encontrada'], 404);
        }

        return response()->json($pergunta, 200);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'texto_pergunta' => 'required|string|'
        ]);

        $pergunta = Pergunta::create($validated);

        return response()->json($pergunta);
    }

    public function destroy($id){
        $pergunta = Pergunta::find($id);

        if(!$pergunta){
            return response(['erro' => 'Pergunta nao encontrada'], 404);
        }

        $pergunta::delete();

        return response(['sucesso' => 'Pergunta apagada']);
    }

}
