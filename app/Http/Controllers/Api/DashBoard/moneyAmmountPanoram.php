<?php

namespace App\Http\Controllers\Api\DashBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class moneyAmmountPanoram extends Controller
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
        $groupBy = $diffDays <= 30 ? 'DATE(pay.expiration_date)' : 'DATE_FORMAT(pay.expiration_date, "%Y-%m")';

        // Consulta para obter os dados agregados
        $results = DB::table('movements')
            ->join('payments as pay', 'movements.id', '=', 'pay.movements_id')
            ->where('movements.moviment_type', '=', 'Saida')
            ->whereBetween('pay.expiration_date', [$startDate, $endDate])
            ->where('movements.account_id', '=', $accountId)
            ->selectRaw("
                $groupBy as period,
                SUM(pay.installment_value) as total_value
            ")
            ->groupBy(DB::raw($groupBy))
            ->orderBy(DB::raw($groupBy), 'DESC')
            ->get();

        // Retorna os resultados como JSON
        return response()->json($results);
    }
}
