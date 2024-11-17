<?php

namespace App\Http\Controllers;

use App\Models\AccountCostCenter;
use Illuminate\Http\Request;

class AccountCostCenterController extends Controller
{
    /**
     * Lista todos os relacionamentos entre contas e centros de custo.
     */
    public function index()
    {
        $accountCostCenters = AccountCostCenter::all();
        return response()->json($accountCostCenters);
    }

    /**
     * Armazena um novo relacionamento.
     */
    public function store(Request $request)
    {
        // Valida os dados
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'cost_center_id' => 'required|exists:cost_centers,id',
        ]);

        // Cria o relacionamento
        $accountCostCenter = AccountCostCenter::create([
            'account_id' => $request->account_id,
            'cost_center_id' => $request->cost_center_id,
        ]);

        return response()->json($accountCostCenter, 201);
    }

    /**
     * Exibe um relacionamento específico.
     */
    public function show($id)
    {
        $accountCostCenter = AccountCostCenter::with(['account', 'costCenter'])->findOrFail($id);
        return response()->json($accountCostCenter);
    }

    /**
     * Atualiza um relacionamento específico.
     */
    public function update(Request $request, $id)
    {
        // Valida os dados
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'cost_center_id' => 'required|exists:cost_centers,id',
        ]);

        // Busca e atualiza o relacionamento
        $accountCostCenter = AccountCostCenter::findOrFail($id);
        $accountCostCenter->update([
            'account_id' => $request->account_id,
            'cost_center_id' => $request->cost_center_id,
        ]);

        return response()->json($accountCostCenter);
    }

    /**
     * Remove um relacionamento específico.
     */
    public function destroy($id)
    {
        $accountCostCenter = AccountCostCenter::findOrFail($id);
        $accountCostCenter->delete();

        return response()->json(['message' => 'Relacionamento excluído com sucesso']);
    }
}
