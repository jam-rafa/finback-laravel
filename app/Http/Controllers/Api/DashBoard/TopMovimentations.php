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

        $top_entradas = DB::table('movements')
            ->join('cost_centers as cost', 'movements.cost_center_id', '=', 'cost.id')
            ->join('payments as pay', 'movements.id', '=', 'pay.movements_id')
            ->select('movements.name', 'cost.name as cost_center_name', DB::raw('SUM(pay.installment_value) AS total_value'))
            ->whereBetween('pay.expiration_date', [$startDate, $endDate])
            ->where('movements.moviment_type', '=', 'Entrada')
            ->where('movements.account_id', $accountId)
            ->groupBy('movements.name', 'cost.name')
            ->orderByDesc('total_value')
            ->limit(7)
            ->get();


        // Top 7 saídas
        $top_saidas = DB::table('movements')
            ->join('cost_centers as cost', 'movements.cost_center_id', '=', 'cost.id')
            ->join('payments as pay', 'movements.id', '=', 'pay.movements_id')
            ->select('movements.name', 'cost.name as cost_center_name', DB::raw('SUM(pay.installment_value) AS total_value'))
            ->whereBetween('pay.expiration_date', [$startDate, $endDate])
            ->where('movements.moviment_type', '=', 'saida')
            ->where('movements.account_id', $accountId)
            ->groupBy('movements.name', 'cost.name')
            ->orderByDesc('total_value')
            ->limit(7)
            ->get();

        // Retorna os resultados em formato JSON
        return response()->json([
            'top_entradas' => $top_entradas,
            'top_saidas' => $top_saidas,
        ]);
    }
}
