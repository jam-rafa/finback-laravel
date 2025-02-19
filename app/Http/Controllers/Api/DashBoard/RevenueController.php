<?php

namespace App\Http\Controllers\Api\DashBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        // Validação para garantir que as datas e outros parâmetros sejam enviados corretamente
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'id' => 'required|integer',
            'cost_centers' => 'sometimes',
            'entities' => 'sometimes',
            'natures' => 'sometimes',
            'group' => 'sometimes',
        ]);

        $accountId = $request->input('id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $costCenters = $request->input('cost_centers');
        $natures = $request->input('natures');
        $entities = $request->input('entities');

        // Inicia a query
        $query = DB::table('movements')
            ->where('movements.account_id', $accountId)
            ->whereBetween('date', [$startDate, $endDate]);

        // Aplicação dos filtros adicionais
        if (!empty($costCenters)) {
            if (is_string($costCenters)) {
                $costCenters = json_decode($costCenters, true);
            }
            if (is_array($costCenters) && count($costCenters) > 0) {
                $query->whereIn('movements.cost_center_id', $costCenters);
            }
        }

        if (!empty($natures)) {
            if (is_string($natures)) {
                $natures = json_decode($natures, true);
            }
            if (is_array($natures) && count($natures) > 0) {
                $query->whereIn('movements.nature_id', $natures);
            }
        }

        if (!empty($entities)) {
            if (is_string($entities)) {
                $entities = json_decode($entities, true);
            }
            if (is_array($entities) && count($entities) > 0) {
                $query->whereIn('movements.entities_id', $entities);
            }
        }

        // Cálculo de entradas
        $entry = (clone $query)
            ->where('movements.moviment_type', 'Entrada')
            ->sum('movements.value');

        // Cálculo de saídas
        $out = (clone $query)
            ->where('movements.moviment_type', 'Saida')
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
