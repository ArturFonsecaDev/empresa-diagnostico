<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index(){
        return Categoria::all();
    }

    public function show($id){
        $categoria = Categoria::find($id);

        if(!$categoria){
            return response(['erro' => 'Categoria não encontrada'], 404);
        }

        return response()->json($categoria, 200);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nome' => 'required|string|max:300',
            'descricao' => 'nullable|string'
        ]);

        $categoria = Categoria::create($validated);

        return response()->json($categoria);
    }

    public function destroy($id){
        $categoria = Categoria::find($id);

        if(!$categoria){
            return response(['erro' => 'Categoria não encontrada'], 404);
        }

        $categoria->delete();

        return response(['sucesso' => 'Categoria apagada']);
    }
}
