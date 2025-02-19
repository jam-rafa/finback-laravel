<?php

namespace App\Http\Controllers\TableControllers;

use App\Http\Controllers\Controller;
use App\Models\Entities;
use Illuminate\Http\Request;

class EntitiesController extends Controller
{
    public function autocomplete(Request $request)
    {
        $query = $request->get('query'); // Obtém o termo de busca do parâmetro 'query'
        $accountId = $request->get('id');
        // Pesquisa no banco com base no termo fornecido
        $results = Entities::where('name', 'LIKE', "%{$query}%") // Substitua 'name' pelo campo que deseja pesquisar

            ->join('account_entities', 'entities.id', '=', 'account_entities.entities_id')
            ->where('account_entities.account_id', $accountId)
            ->take(7) // Limite a quantidade de resultados retornados
            ->get();

        // Retorne os resultados como JSON
        return response()->json($results);
    }
}
