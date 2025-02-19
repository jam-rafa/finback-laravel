<?php

namespace App\Http\Controllers\Api\DashBoard;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MounthAverage extends Controller
{
    public function index(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'id' => 'required|integer',
            'cost_centers' => 'sometimes',
            'entities' => 'sometimes',
            'natures' => 'sometimes',
        ]);

        // Obtendo os parâmetros do request
        $startDate = Carbon::parse($request->input('start_date'))->startOfMonth();
        $endDate = Carbon::parse($request->input('end_date'))->endOfMonth();
        $accountId = $request->input('id');
        $costCenters = $request->input('cost_centers');
        $natures = $request->input('natures');
        $entities = $request->input('entities');

        // Calculando a data de 6 meses atrás
        $sixMonthsAgoStart = Carbon::now()->subMonths(6)->startOfMonth();
        $sixMonthsAgoEnd = Carbon::now()->subMonths(6)->endOfMonth();

        // Construindo a query base
        $queryCurrent = DB::table('movements')->where('account_id', $accountId);
        $querySixMonthsAgo = DB::table('movements')->where('account_id', $accountId);

        // Aplicando filtros adicionais
        if (!empty($costCenters)) {
            if (is_string($costCenters)) {
                $costCenters = json_decode($costCenters, true);
            }
            if (is_array($costCenters) && count($costCenters) > 0) {
                $queryCurrent->whereIn('cost_center_id', $costCenters);
                $querySixMonthsAgo->whereIn('cost_center_id', $costCenters);
            }
        }

        if (!empty($natures)) {
            if (is_string($natures)) {
                $natures = json_decode($natures, true);
            }
            if (is_array($natures) && count($natures) > 0) {
                $queryCurrent->whereIn('nature_id', $natures);
                $querySixMonthsAgo->whereIn('nature_id', $natures);
            }
        }

        if (!empty($entities)) {
            if (is_string($entities)) {
                $entities = json_decode($entities, true);
            }
            if (is_array($entities) && count($entities) > 0) {
                $queryCurrent->whereIn('entities_id', $entities);
                $querySixMonthsAgo->whereIn('entities_id', $entities);
            }
        }

        // Filtrando os movimentos do mês atual
        $currentMonthMovements = $queryCurrent->whereBetween('date', [$startDate, $endDate])->get();

        // Filtrando os movimentos de 6 meses atrás
        $sixMonthsAgoMovements = $querySixMonthsAgo->whereBetween('date', [$sixMonthsAgoStart, $sixMonthsAgoEnd])->get();

        // Calculando a receita do mês atual
        $currentMonthRevenue = $currentMonthMovements->where('moviment_type', 'Entrada')->sum('value') -
            $currentMonthMovements->where('moviment_type', 'Saida')->sum('value');

        // Calculando a receita de 6 meses atrás
        $sixMonthsAgoRevenue = $sixMonthsAgoMovements->where('moviment_type', 'Entrada')->sum('value') -
            $sixMonthsAgoMovements->where('moviment_type', 'Saida')->sum('value');

        $growthRate = 0; // Inicializa a taxa de crescimento como 0
        if ($sixMonthsAgoRevenue != 0) { // Evita divisão por zero
            $ratio = $currentMonthRevenue / $sixMonthsAgoRevenue;
            $growthRate = pow($ratio, 1 / 6) - 1; // n = 6 (6 meses)
            $growthRate *= 100; // Convertendo para porcentagem
        }

        $profit_revenue = $currentMonthRevenue - $sixMonthsAgoRevenue;

        // Retornando os resultados
        return response()->json([
            'current_month_revenue' => round($currentMonthRevenue, 2),
            'six_months_ago_revenue' => round($sixMonthsAgoRevenue, 2),
            'growth' => round($growthRate, 2),
            'profit_revenue' => round($profit_revenue, 2)
        ]);
    }
}
