<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AccountCostCenterController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CostCenterController;
use App\Models\AccountCostCenter;
use App\Models\CostCenter;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {

        $users = User::all();


        return response()->json([
            'message' => 'Dados recebidos',
            'data' => $request->all()
        ]);
    }


    public function store(Request $request)
    {
        try {
            // Verifica se já existe um CostCenter com o nome fornecido
            $costCenter = CostCenter::where('name', $request->cost_center_name)->first();

            // Se não existe, cria usando o CostCenterController
            if (!$costCenter) {
                // Cria um novo Request com apenas o nome do centro de custo
                $customRequest = new Request([
                    'name' => $request->cost_center_name
                ]);

                // Instancia o CostCenterController e chama o método store
                $costCenterController = app(CostCenterController::class);
                $costCenterResponse = $costCenterController->store($customRequest);

                // Recupera o centro de custo criado
                $costCenterData = $costCenterResponse->getData();
                $costCenter = CostCenter::find($costCenterData->id);
            }

            $associationRequest = new Request([
                'cost_center_id' => $costCenter->id,
                'account_id' => $request->account_id
            ]);
            $accountCostCenterController = app(AccountCostCenterController::class);
            $accountCostCenterController->store($associationRequest);


            return response()->json(['message' => 'Conta criada com sucesso!'], 201);
        } catch (\Exception $error) {
            return response()->json([
                'message' => 'Erro ao criar conta',
                'error' => $error->getMessage()
            ], 500);
        }
    }
}
