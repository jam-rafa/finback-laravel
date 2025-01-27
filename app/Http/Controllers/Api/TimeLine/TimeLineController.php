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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'id' => 'sometimes|integer',
            'limit' => 'sometimes|integer|min:1',
            'offset' => 'sometimes|integer|min:0',
            'cost_centers' => 'sometimes',
            'natures' => 'sometimes',
            'group' => 'sometimes', // Deve ser uma lista
        ]);

        // Obtendo os parâmetros
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $accountId = $request->input('id');
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $costCenters = $request->input('cost_centers');
        $natures = $request->input('natures');
        $groupFields = $request->input('group', ['date']); // Padrão para agrupar por data

        // Decodificando o parâmetro group se for um JSON
        if (!empty($groupFields) && is_string($groupFields)) {
            $groupFields = json_decode($groupFields, true);
        }

        // Garantindo que groupFields seja sempre um array
        if (!is_array($groupFields) || empty($groupFields)) {
            $groupFields = ['date']; // Fallback para 'date' se inválido
        }

        // Inicia a query
        $query = DB::table('movements')
            ->join('payment_types as pay_type', 'movements.payment_type_id', '=', 'pay_type.id')
            ->join('natures', 'movements.nature_id', '=', 'natures.id')
            ->join('cost_centers as cost', 'movements.cost_center_id', '=', 'cost.id')
            ->whereBetween('movements.date', [$startDate, $endDate]);

        // Adiciona o filtro por account_id, se enviado
        if (!is_null($accountId)) {
            $query->where('movements.account_id', '=', $accountId);
        }

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

        // Finaliza a query
        $results = $query
            ->select(
                'movements.id',
                'movements.name as movement_name',
                'movements.installments',
                'movements.moviment_type',
                'natures.name as nature',
                'movements.value as installment_value',
                'cost.name as cost_center',
                'movements.date as expiration_date',
                'pay_type.name as payment_type_name'
            )
            ->orderBy('movements.date')
            ->limit($limit)
            ->offset($offset)
            ->get();

        // Função para obter o valor do agrupamento dinâmico
        $groupedResults = $results->groupBy(function ($item) use ($groupFields) {
            $groupKeys = [];
            foreach ($groupFields as $field) {
                switch ($field) {
                    case 'cost_center':
                        $groupKeys[] = [
                            'field' => 'Centro de custo',
                            'value' => $item->cost_center
                        ];
                        break;
                    case 'nature':
                        $groupKeys[] = [
                            'field' => 'Natureza',
                            'value' => $item->nature
                        ];
                        break;
                    case 'moviment_type':
                        $groupKeys[] = [
                            'field' => 'movimento de',
                            'value' => $item->moviment_type
                        ];
                        break;
                    case 'date':
                        $groupKeys[] = [
                            'field' => 'Data',
                            'value' => $item->expiration_date
                        ];
                        break;
                }
            }

            // Gera uma string de agrupamento que inclui o campo e o valor
            return implode('|', array_map(function ($key) {
                return "{$key['field']}:{$key['value']}";
            }, $groupKeys));
        })->map(function ($items, $group) {
            // Divide o agrupamento de volta em arrays de 'field' e 'value'
            $fields = explode('|', $group);
            $formattedGroup = array_map(function ($field) {
                [$fieldName, $value] = explode(':', $field);
                return [
                    'field' => $fieldName,
                    'value' => $value
                ];
            }, $fields);

            return [
                'group' => $formattedGroup, // Campo e valor para cada grupo
                'data' => $items->toArray(), // Dados associados ao grupo
            ];
        })->values();

        // Retornando o resultado formatado como JSON
        return response()->json($groupedResults);
    }
}
