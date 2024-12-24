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
            'id' => 'required'
        ]);

        $accountId = $request->input('id');

        // Consulta agrupada por dia da semana
        $outPerWeek = Movement::select(
            DB::raw('DAYNAME(payments.expiration_date) as week_day'), // Nome do dia da semana (Monday, Tuesday, etc.)
            DB::raw('SUM(payments.installment_value) as total_value') // Soma do valor por dia da semana
        )
            ->where('movements.account_id', $accountId)
            ->where('movements.moviment_type', 'Saída') // Filtro por tipo de movimentação
            ->whereBetween('payments.expiration_date', [$request->input('start_date'), $request->input('end_date')]) // Filtro por data
            ->join('payments', 'payments.movements_id', '=', 'movements.id') // Confirme se "movements_id" é correto
            ->groupBy(
                DB::raw('DAYNAME(payments.expiration_date)'),
                DB::raw('DAYOFWEEK(payments.expiration_date)')
            ) // Agrupando pelo nome do dia e pelo número do dia da semana para garantir a ordenação correta
            ->orderBy(DB::raw('DAYOFWEEK(payments.expiration_date)')) // Ordenando pela ordem dos dias da semana
            ->get();

        // Retorna o resultado no formato JSON
        return response()->json(
            $outPerWeek
        );
    }
}
