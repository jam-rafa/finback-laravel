<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountCostCenter;
use App\Models\AccountEntities;
use App\Models\AccountNature;
use App\Models\CostCenter;
use App\Models\Entities;
use App\Models\Movement;
use App\Models\Nature;
use App\Models\NatureType;
use App\Models\PaymentType;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request) {}

    public function store(Request $request)
    {
        try {
            $account = Account::where('nome', $request['account_name'])->first();
            $account_id = $account ? $account->id : null;

            $data = $request->get('data');
            if (!is_array($data)) {
                return response()->json(['message' => $request['account_name']], 400);
            }

            foreach ($request['data'] as $item) {
                // Tenta encontrar ou criar o centro de custo
                $costCenter = CostCenter::firstOrCreate(
                    ['name' => $item['centroDeCusto']], // Condição para verificar se já existe
                    ['icon' => 'ti-bell'] // Valores padrão para criar se não existir
                );

                $existingAssociation = AccountCostCenter::where('account_id', $account_id)
                    ->where('cost_center_id', $costCenter->id)
                    ->exists();

                if (!$existingAssociation) {
                    AccountCostCenter::create([
                        'account_id' => $account_id,
                        'cost_center_id' => $costCenter->id
                    ]);
                }

                $nature = Nature::firstOrCreate([
                    'name' => $item['natureza']
                ]);

                $existingAccNature = AccountNature::where('account_id', $account_id)
                    ->where('nature_id', $nature->id)
                    ->exists();

                if (!$existingAccNature) {
                    AccountNature::create([
                        'account_id' => $account_id,
                        'nature_id' => $nature->id
                    ]);
                }

                $entities = Entities::firstOrCreate([
                    'name' => $item['nomeEmpresa'],
                ]);

                $existingAccEntities = AccountEntities::where('account_id', $account_id)
                    ->where('entities_id', $entities->id)
                    ->exists();

                if (!$existingAccEntities) {
                    AccountEntities::create([
                        'account_id' => $account_id,
                        'entities_id' => $entities->id
                    ]);
                }



                $nature_type = NatureType::where('name', $item['tipo_natureza'])->first();
                if (!$nature_type) {
                    $nature_type = NatureType::create([
                        'name' => $item['tipo_natureza'],
                        'nature_id' => $nature->id
                    ]);
                }

                $paymentType = PaymentType::where('name', $item['formaDePagamento'])->first();
                if (!$paymentType) {
                    $paymentType = PaymentType::create([
                        'name' => $item['formaDePagamento']
                    ]);
                }

                // Verifica se o pagamento é parcelado
                $installments = $item['payment']['installments'] ?? 1; // Default para 1 parcela
                $expirationDate = $item['data']; // Usa a data do movimento como base

                // Cria as parcelas ou o movimento único
                for ($i = 1; $i <= $installments; $i++) {
                    Movement::create([
                        'name' => $item['nomeEmpresa'],
                        'date' => \Carbon\Carbon::parse($expirationDate)->addMonths($i - 1), // Incrementa o mês para cada parcela
                        'cost_type' => $item['fixoVariavel'],
                        'value' => $item['payment']['installment_value'] / $installments, // Valor por parcela
                        'moviment_type' => $item['moviment_type'],
                        'installments' => $i, // Número total de parcelas
                        'current_installment' => $i, // Parcela atual
                        'account_id' => $account_id,
                        'nature_id' => $nature->id,
                        'payment_type_id' => $paymentType->id,
                        'cost_center_id' => $costCenter->id,
                        'entities_id' => $entities->id
                    ]);
                }
            }

            return response()->json(['message' => 'Dados inseridos com sucesso!'], 201);
        } catch (\Exception $error) {
            return response()->json([
                'message' => 'Erro ao processar dados',
                'error' => $error->getMessage()
            ], 500);
        }
    }
}
