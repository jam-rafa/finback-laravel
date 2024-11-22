<?php

namespace App\Http\Controllers;

use App\Models\Nature;
use Illuminate\Http\Request;

class NatureController extends Controller
{
    // Listar todas as natures
    public function index()
    {
        $natures = Nature::all();
        return response()->json($natures, 200);
    }

    // Criar uma nova nature
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:natures,name',
        ]);

        $nature = Nature::create($validated);

        return response()->json($nature, 201);
    }

    // Exibir uma nature específica
    public function show($id)
    {
        $nature = Nature::find($id);

        if (!$nature) {
            return response()->json(['error' => 'Nature not found'], 404);
        }

        return response()->json($nature, 200);
    }

    // Atualizar uma nature existente
    public function update(Request $request, $id)
    {
        $nature = Nature::find($id);

        if (!$nature) {
            return response()->json(['error' => 'Nature not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|unique:natures,name,' . $id,
        ]);

        $nature->update($validated);

        return response()->json($nature, 200);
    }

    // Deletar uma nature
    public function destroy($id)
    {
        $nature = Nature::find($id);

        if (!$nature) {
            return response()->json(['error' => 'Nature not found'], 404);
        }

        $nature->delete();

        return response()->json(['message' => 'Nature deleted'], 200);
    }
}
