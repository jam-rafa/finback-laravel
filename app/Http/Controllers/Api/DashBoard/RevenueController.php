<?php

namespace App\Http\Controllers\Api\DashBoard;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        // Validação para garantir que as datas sejam enviadas corretamente
        $request->validate([
            'start_date' => 'required|date', // Data inicial obrigatória
            'end_date' => 'required|date|after_or_equal:start_date', // Data final obrigatória
            'id' => 'required' // ID da conta obrigatório
        ]);

        $accountId = $request->input('id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Cálculo de entradas
        $entry = Movement::where('movements.account_id', $accountId)
            ->where('movements.moviment_type', 'Entrada')
            ->where('movements.installments', 1)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('movements.value');

        // Cálculo de saídas
        $out = Movement::where('movements.account_id', $accountId)
            ->where('movements.moviment_type', 'Saida')
            ->where('movements.installments', 1)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('movements.value');


        // Receita líquida
        $revenue = $entry - $out;

        return response()->json([
            'revenue' => $revenue,
            'entry' => $entry,
            'out' => $out,
        ]);
    }
}
