<?php

namespace App\Http\Controllers;

use App\Models\Nature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NatureController extends Controller
{
    // Listar todas as natures
    public function index(Request $request)
    {
        $request->validate([
            'id' => 'required|integer', // ID é obrigatório e deve ser inteiro
        ]);

        $accountId = $request->input('id');

        $natures = Nature::select('natures.id', 'natures.name')
            ->join('account_natures', 'natures.id', '=', 'account_natures.nature_id')
            ->where('account_natures.account_id', $accountId)
            ->get();

        return response()->json($natures);
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
