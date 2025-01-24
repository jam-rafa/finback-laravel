<?php

namespace App\Http\Controllers\Api\DashBoard;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class weekendGrowth extends Controller
{
    public function index(Request $request)
    {
        // Validação dos dados de entrada
        $request->validate([
            'start_date' => 'required|date', // Data inicial obrigatória
            'end_date' => 'required|date|after_or_equal:start_date', // Data final obrigatória
            'id' => 'required' // ID da conta obrigatória
        ]);

        $accountId = $request->input('id');

        // Consulta agrupada por dia da semana
        $outPerWeek = Movement::select(
            DB::raw('DAYNAME(date) as week_day'), // Nome do dia da semana (Monday, Tuesday, etc.)
            DB::raw('SUM(value) as total_value') // Soma dos valores por dia da semana
        )
            ->where('account_id', $accountId) // Filtro pela conta
            ->where('moviment_type', 'Saída') // Filtro por tipo de movimentação
            ->whereBetween('date', [$request->input('start_date'), $request->input('end_date')]) // Filtro por intervalo de datas
            ->groupBy(
                DB::raw('DAYNAME(date)'),
                DB::raw('DAYOFWEEK(date)')
            ) // Agrupamento pelo nome e ordem do dia da semana
            ->orderBy(DB::raw('DAYOFWEEK(date)')) // Ordenando pela ordem dos dias da semana
            ->get();

        // Retorna o resultado no formato JSON
        return response()->json(
            $outPerWeek
        );
    }
}
