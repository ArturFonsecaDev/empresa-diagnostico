<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RespostaCliente;
use App\Models\Resposta;
use App\Models\Categoria;

class RespostaClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        return RespostaCliente::all();
    }

    public function store(Request $request)
{
    $respostas = $request->input('respostas');

    // Lista para armazenar as categorias das respostas
    $categoriasContagem = [];

    foreach ($respostas as $resposta) {
        RespostaCliente::create([
            'cliente_id' => $resposta['cliente_id'],
            'resposta_id' => $resposta['resposta_id'],
        ]);

        // Obter a resposta com base no resposta_id
        $respostaModel = Resposta::find($resposta['resposta_id']);
        
        if ($respostaModel) {
            $categoriaId = $respostaModel->categoria_id;

            $categoria = Categoria::find($categoriaId);
            if($categoria->descricao == "Categoria 'Não'"){
                continue;
            }

            // Incrementar a contagem da categoria
            if (isset($categoriasContagem[$categoriaId])) {
                $categoriasContagem[$categoriaId]++;
                continue;
            }
            $categoriasContagem[$categoriaId] = 1;
            
        }
    }

    $categoriaPredominanteId = array_keys($categoriasContagem, max($categoriasContagem))[0];

    $categoriaPredominante = Categoria::find($categoriaPredominanteId);

    if ($categoriaPredominante) {
        $descricaoCategoria = $categoriaPredominante->descricao;
    } else {
        $descricaoCategoria = null;
    }

    return response()->json([
        'message' => 'Respostas registradas com sucesso!',
        'categoria_predominante' => $categoriaPredominanteId,
        'descricao_categoria' => $descricaoCategoria
    ]);
}

    public function show(string $id){
        $resposta_cliente = RespostaCliente::find($id);

        if(!$resposta_cliente){
           return response(['erro' => 'Resposta nao encontrada'], 404);
        }

        return response()->json($resposta_cliente);
    }

    public function destroy(string $id){
        $resposta_cliente = RespostaCliente::find($id);

        if(!$resposta_cliente){
            return response(['erro' => 'Resposta do Cliente nao encontrada'], 404);
        }

        $resposta_cliente->delete();

        return response(['sucesso' => 'Resposta apagada']);
    }
}
