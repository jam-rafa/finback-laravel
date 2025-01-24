<?php

namespace App\Http\Controllers;

use App\Models\CostCenter;
use Illuminate\Http\Request;

class CostCenterController extends Controller
{
    /**
     * Lista todos os centros de custo.
     */
    public function index(Request $request)
    {

        $request->validate([
            'id' => 'required|integer', // ID é obrigatório e deve ser inteiro
        ]);
    
        // Obtém o ID da conta a partir do request
        $accountId = $request->input('id');
    
        // Executa a consulta utilizando Eloquent
        $costCenters = CostCenter::select('cost_centers.name', 'cost_centers.icon', 'cost_centers.id')
            ->join('account_cost_centers', 'cost_centers.id', '=', 'account_cost_centers.cost_center_id')
            ->where('account_cost_centers.account_id', $accountId)
            ->orderBy('cost_centers.name')
            ->get();
    
        // Retorna os resultados em formato JSON
        return response()->json($costCenters);
    }

    public function store(Request $request)
    {
        // Valida os dados recebidos
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // Cria o centro de custo com os dados recebidos
        $costCenter = CostCenter::create([
            'name' => $request->name
        ]);

        // Retorna uma resposta com o centro de custo criado
        return response()->json($costCenter, 201);
    }


    /**
     * Atualiza um centro de custo específico.
     */
    public function update(Request $request, $id)
    {
        // Valida os dados recebidos
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // Busca o centro de custo pelo ID e atualiza
        $costCenter = CostCenter::findOrFail($id);
        $costCenter->update([
            'name' => $request->name
        ]);

        // Retorna uma resposta com o centro de custo atualizado
        return response()->json($costCenter);
    }

    /**
     * Remove um centro de custo específico.
     */
    public function destroy($id)
    {
        // Busca o centro de custo pelo ID e exclui
        $costCenter = CostCenter::findOrFail($id);
        $costCenter->delete();

        // Retorna uma resposta de sucesso
        return response()->json(['message' => 'Centro de custo excluído com sucesso']);
    }
}
