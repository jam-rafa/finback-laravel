<?php

namespace App\Http\Controllers;

use App\Models\CostCenter;
use Illuminate\Http\Request;

class CostCenterController extends Controller
{
    /**
     * Lista todos os centros de custo.
     */
    public function index()
    {
        // Obtém todos os registros de centros de custo
        $costCenters = CostCenter::all();

        // Retorna uma resposta com todos os centros de custo (ou exibe em uma view)
        return response()->json($costCenters);
    }

    /**
     * Exibe o formulário de criação (opcional para APIs).
     */
    public function create()
    {
        // Normalmente usado para exibir um formulário em aplicações web
        // Em APIs, esse método geralmente não é necessário
    }

    /**
     * Armazena um novo centro de custo.
     */
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
     * Exibe um centro de custo específico.
     */
    public function show($id)
    {
        // Busca o centro de custo pelo ID
        $costCenter = CostCenter::findOrFail($id);

        // Retorna o centro de custo encontrado
        return response()->json($costCenter);
    }

    /**
     * Exibe o formulário de edição (opcional para APIs).
     */
    public function edit($id)
    {
        // Normalmente usado para exibir um formulário em aplicações web
        // Em APIs, esse método geralmente não é necessário
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
