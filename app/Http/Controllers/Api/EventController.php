<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CostCenter;
use App\Models\Movement;
use App\Models\Nature;
use App\Models\NatureType;
use App\Models\Payment;
use App\Models\PaymentType;
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



            $account_id = 2;

            $data = $request->get('data');
            if (!is_array($data)) {
                return response()->json(['message' => $request['data']], 400);
            }

            foreach ($request['data'] as $item) {
                // Tenta encontrar ou criar o centro de custo
                $costCenter = CostCenter::where('name', $item['centroDeCusto'])->first();
                if (!$costCenter) {
                    $costCenter = CostCenter::create([
                        'name' => $item['centroDeCusto']
                    ]);
                }

                $nature = Nature::where('name', $item['natureza'])->first();
                if (!$nature) {
                    $nature = Nature::create([
                        'name' => $item['natureza']
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
                echo('teste');

                // Cria o movimento
                $movement = Movement::create([
                    'name' => $item['nomeEmpresa'],
                    'date' => $item['data'],
                    'cost_type' => $item['fixoVariavel'],
                    'value' => $item['valor'],
                    'moviment_type' => $item['moviment_type'],
                    'installments' => $item['payment']['installments'],
                    'account_id' => $account_id,
                    'nature_id' => $nature->id,
                    'payment_type_id' => $paymentType->id,
                    'cost_center_id' => $costCenter->id,
                ]);

                // Verifica se o pagamento é parcelado
                // Verifica se o pagamento é parcelado
                $installments = $item['payment']['installments'] ?? 1; // Default para 1 parcela
                $expirationDate = $item['data']; // Usa a data do movimento como base
                // Cria as parcelas
                for ($i = 1; $i <= $installments; $i++) {
                    Payment::create([
                        'status' => 'pendente', // Define o status inicial
                        'installment' => $i, // Número da parcela
                        'installment_value' => $item['payment']['installment_value'] / $installments, // Usa o valor da parcela do payload
                        'expiration_date' => \Carbon\Carbon::parse($expirationDate)->addMonths($i - 1), // Incrementa o mês para cada parcela
                        'movements_id' => $movement->id, // Relaciona ao movimento criado
                        'account_id' => $account_id,
                        'payment_type_id' => $paymentType->id, // Relaciona ao tipo de pagamento
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
