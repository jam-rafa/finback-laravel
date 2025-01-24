<?php

namespace App\Http\Controllers\Api\DashBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopMovimentations extends Controller
{
    public function index(Request $request)
    {
        // Validação para garantir que as datas e o ID sejam enviados corretamente
        $request->validate([
            'start_date' => 'required|date', // Data inicial obrigatória
            'end_date' => 'required|date|after_or_equal:start_date', // Data final obrigatória
            'id' => 'required|integer' // ID obrigatório e deve ser um número inteiro
        ]);

        // Captura os dados validados
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $accountId = $request->input('id');

        // Top 7 entradas
        $top_entradas = DB::table('movements')
            ->join('cost_centers as cost', 'movements.cost_center_id', '=', 'cost.id') // Relaciona com os centros de custo
            ->select(
                'movements.name',
                'cost.name as cost_center_name',
                DB::raw('SUM(movements.value) AS total_value') // Soma dos valores das entradas
            )
            ->whereBetween('movements.date', [$startDate, $endDate]) // Filtro por data
            ->where('movements.moviment_type', '=', 'Entrada') // Filtro por tipo de movimentação
            ->where('movements.account_id', $accountId) // Filtro pelo ID da conta
            ->groupBy('movements.name', 'cost.name') // Agrupamento por nome e centro de custo
            ->orderByDesc('total_value') // Ordenação decrescente pelo valor total
            ->limit(7) // Retorna apenas os 7 maiores valores
            ->get();

        // Top 7 saídas
        $top_saidas = DB::table('movements')
            ->join('cost_centers as cost', 'movements.cost_center_id', '=', 'cost.id') // Relaciona com os centros de custo
            ->select(
                'movements.name',
                'cost.name as cost_center_name',
                DB::raw('SUM(movements.value) AS total_value') // Soma dos valores das saídas
            )
            ->whereBetween('movements.date', [$startDate, $endDate]) // Filtro por data
            ->where('movements.moviment_type', '=', 'Saída') // Filtro por tipo de movimentação
            ->where('movements.account_id', $accountId) // Filtro pelo ID da conta
            ->groupBy('movements.name', 'cost.name') // Agrupamento por nome e centro de custo
            ->orderByDesc('total_value') // Ordenação decrescente pelo valor total
            ->limit(7) // Retorna apenas os 7 maiores valores
            ->get();

        // Retorna os resultados em formato JSON
        return response()->json([
            'top_entradas' => $top_entradas,
            'top_saidas' => $top_saidas,
        ]);
    }
}
