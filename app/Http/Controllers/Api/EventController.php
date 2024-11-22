<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CostCenter;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {

        // $users = Users::all();

        // dd($users);
        // return response()->json([
        //     'message' => 'Dados recebidos',
        //     'data' => $request->all()
        // ]);
    }

    public function store(Request $request)
    {
        try {
            // Verifica se a conta existe
            $account = Account::where('nome', $request['account_name'])->first();
            if (!$account) {
                return response()->json(['message' => 'Conta não encontrada'], 404);
            }

            foreach ($request['data'] as $item) {
                // Tenta encontrar o centro de custo
                $costCenter = CostCenter::where('name', $item['centroDeCusto'])->first();
                if (!$costCenter) {
                    // Cria o centro de custo se não existir
                    $costCenter = CostCenter::create([
                        'name' => $item['centroDeCusto']
                    ]);
                }

                // Aqui você pode continuar o processamento com $costCenter
            }

            return response()->json(['message' => 'Evento criado com sucesso!'], 201);
        } catch (\Exception $error) {
            return response()->json([
                'message' => 'Erro ao criar evento',
                'error' => $error->getMessage()
            ], 500);
        }
    }
}
