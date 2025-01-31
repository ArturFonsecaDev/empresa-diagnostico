<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resposta;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\RespostaCliente;

class RespostaController extends Controller
{
    public function index(){
        return Resposta::all();
    }

    public function show($id){
        $resposta = Resposta::find($id);

        if(!$resposta){
            return response(['erro' => 'Resposta nao encontrada'], 404);
        }
        return response()->json([$resposta]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'texto_resposta' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'pergunta_id' => 'required|exists:perguntas,id'
        ]);

        $resposta = Resposta::create($validated);

        return response()->json($resposta, 201);
    }

    public function destroy($id){
        $resposta = Resposta::find($id);

        if(!$resposta){
            return response(['erro' => 'Resposta nao encontrada'], 404);
        }

        $resposta->delete();

        return response(['sucesso' => 'Resposta apagada']);
    }

    public function respostasPorCliente($clienteId)
    {
        $cliente = Cliente::find($clienteId);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }

        $respostasCliente = RespostaCliente::where('cliente_id', $clienteId)
            ->with('resposta.categoria')
            ->get();

        $categoriasFixas = ['Categoria A', 'Categoria B', 'Categoria C', 'Categoria D'];

        $categorias = [];

        foreach ($categoriasFixas as $categoriaNome) {
            $categorias[$categoriaNome] = [
                'categoria' => $categoriaNome,
                'total_respostas' => 0,
            ];
        }

        foreach ($respostasCliente as $respostaCliente) {
            $categoriaNome = $respostaCliente->resposta->categoria->nome;

            if (in_array($categoriaNome, $categoriasFixas)) {
                $categorias[$categoriaNome]['total_respostas']++;
            }
        }

        return response()->json([
            'cliente_nome' => $cliente->nome,
            'categorias' => array_values($categorias),
        ]);
    }
}
