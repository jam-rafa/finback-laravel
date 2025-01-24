<?php

namespace App\Http\Controllers\Api\DashBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoneyAmmountPanoram extends Controller
{
    public function index(Request $request)
    {
        // Validação para garantir que as datas sejam enviadas corretamente
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'id' => 'required|integer' // ID obrigatório e deve ser um número inteiro
        ]);

        // Obtém os parâmetros do request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $accountId = $request->input('id');

        // Calcula a diferença de dias entre as datas
        $diffDays = (new \DateTime($startDate))->diff(new \DateTime($endDate))->days;

        // Determina o agrupamento (dia ou mês) com base no intervalo
        $groupBy = $diffDays <= 30 ? 'DATE(movements.date)' : 'DATE_FORMAT(movements.date, "%Y-%m")';

        // Consulta para obter os dados agregados de entradas e saídas
        $results = DB::table('movements')
            ->whereBetween('movements.date', [$startDate, $endDate])
            ->where('movements.account_id', '=', $accountId)
            ->selectRaw("
                $groupBy as period,
                movements.moviment_type,
                SUM(movements.value) as total_value
            ")
            ->groupBy(DB::raw($groupBy), 'movements.moviment_type')
            ->orderBy(DB::raw($groupBy), 'Asc')
            ->get();

        // Inicializa o saldo acumulado
        $cumulativeRevenue = 0;

        // Formatar o resultado para agrupar entradas e saídas por período
        $formattedResults = $results->groupBy('period')->map(function ($items, $period) use (&$cumulativeRevenue) {
            $entradas = $items->where('moviment_type', 'Entrada')->sum('total_value');
            $saidas = $items->where('moviment_type', 'Saida')->sum('total_value');
            $dailyRevenue = $entradas - $saidas;

            // Atualiza o saldo acumulado
            $cumulativeRevenue += $dailyRevenue;

            return [
                'period' => $period,
                'entradas' => $entradas,
                'saidas' => $saidas,
                'revenue' => $cumulativeRevenue, // Usa o saldo acumulado
            ];
        })->values();

        // Retorna os resultados formatados como JSON
        return response()->json($formattedResults);
    }
}
