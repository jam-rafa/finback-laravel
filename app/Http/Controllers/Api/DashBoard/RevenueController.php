<?php

namespace App\Http\Controllers\Api\DashBoard;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        // Validação para garantir que as datas sejam enviadas corretamente
        $request->validate([
            'start_date' => 'required|date', // Data inicial obrigatória
            'end_date' => 'required|date|after_or_equal:start_date', // Data final obrigatória
            'id' => 'required'
        ]);

        $accountId = $request->input('id');

        $entry = Movement::where('movements.account_id', $accountId)
            ->where('movements.moviment_type', 'Entrada') // Filtro por tipo de movimentação
            ->whereBetween('payments.expiration_date', [$request->input('start_date'), $request->input('end_date')]) // Filtro por data
            ->join('payments', 'payments.movements_id', '=', 'movements.id') // Confirme se "movements_id" é correto
            ->sum('payments.installment_value');

        $out = Movement::where('movements.account_id', $accountId)
            ->where('movements.moviment_type', 'Saida') // Filtro por tipo de movimentação
            ->whereBetween('payments.expiration_date', [$request->input('start_date'), $request->input('end_date')]) // Filtro por data
            ->join('payments', 'payments.movements_id', '=', 'movements.id') // Confirme se "movements_id" é correto
            ->sum('payments.installment_value');


        $revenue = $entry - $out;
        return response()->json([
            'revenue' => $revenue,
            'entry' => $entry,
            'out' => $out,
        ]);
    }
}
