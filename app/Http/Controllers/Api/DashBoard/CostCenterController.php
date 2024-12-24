<?php

namespace App\Http\Controllers\Api\DashBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostCenterController extends Controller
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

        // Consulta para obter os 7 principais centros de custo por saída
        $results = DB::table('movements')
            ->join('cost_centers as cost', 'movements.cost_center_id', '=', 'cost.id')
            ->join('payments as pay', 'movements.id', '=', 'pay.movements_id')
            ->select(
                'cost.name',
                DB::raw('SUM(pay.installment_value) AS total_spent')
            )
            ->whereBetween('pay.expiration_date', [$startDate, $endDate])
            ->where('movements.moviment_type', '=', 'Saida') // Ajuste conforme a nomenclatura do seu banco
            ->where('movements.account_id', $accountId)
            ->groupBy('cost.name')
            ->orderByDesc('total_spent')
            ->get();

        // Retorna os resultados
        return response()->json($results);
    }
}
