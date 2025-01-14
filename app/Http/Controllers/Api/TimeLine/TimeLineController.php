<?php

namespace App\Http\Controllers\Api\TimeLine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimeLineController extends Controller
{
    public function index(Request $request)
    {
        // Validação dos parâmetros recebidos
        $request->validate([
            'start_date' => 'required|date', // Data inicial obrigatória
            'end_date' => 'required|date|after_or_equal:start_date', // Data final obrigatória
            'id' => 'sometimes|integer', // ID opcional
            'limit' => 'sometimes|integer|min:1', // Limite de registros por página
            'offset' => 'sometimes|integer|min:0', // Offset para paginação
        ]);

        // Obtendo os parâmetros
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $accountId = $request->input('id');
        $limit = $request->input('limit', 10); // Padrão para 10 registros
        $offset = $request->input('offset', 0); // Padrão para offset 0

        // Inicia a query
        $query = DB::table('movements')
            ->join('payments as pay', 'movements.id', '=', 'pay.movements_id')
            ->join('payment_types as pay_type', 'movements.payment_type_id', '=', 'pay_type.id')
            ->join('natures', 'movements.nature_id', '=', 'natures.id')
            ->join('cost_centers as cost', 'movements.cost_center_id', '=', 'cost.id')
            ->whereBetween('pay.expiration_date', [$startDate, $endDate]);

        // Adiciona o filtro por account_id, se enviado
        if (!is_null($accountId)) {
            $query->where('movements.account_id', '=', $accountId);
        }

        // Finaliza a query
        $results = $query
            ->select(
                'movements.id',
                'movements.name as movement_name',
                'movements.installments',
                'movements.moviment_type',
                'natures.name as nature',
                'pay.installment_value',
                'cost.name as cost_center',
                'pay.expiration_date',
                'pay_type.name as payment_type_name'
            )
            ->orderBy('pay.expiration_date')
            ->limit($limit)
            ->offset($offset)
            ->get();

        // Transformando o resultado em um array onde as chaves são os dias
        $groupedResults = $results->groupBy(function ($item) {
            return $item->expiration_date; // Agrupa pelo campo `expiration_date`
        })->map(function ($items, $day) {
            return [
                'group' => $day,
                'data' => $items->toArray(),
            ];
        })->values();

        // Retornando o resultado formatado como JSON
        return response()->json($groupedResults);
    }
}
