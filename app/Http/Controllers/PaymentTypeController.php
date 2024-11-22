<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    // Listar todos os tipos de pagamento
    public function index()
    {
        $paymentTypes = PaymentType::all();
        return response()->json($paymentTypes, 200);
    }

    // Criar um novo tipo de pagamento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:payment_types,name',
        ]);

        $paymentType = PaymentType::create($validated);

        return response()->json($paymentType, 201);
    }

    // Exibir um tipo de pagamento específico
    public function show($id)
    {
        $paymentType = PaymentType::find($id);

        if (!$paymentType) {
            return response()->json(['error' => 'Payment type not found'], 404);
        }

        return response()->json($paymentType, 200);
    }

    // Atualizar um tipo de pagamento existente
    public function update(Request $request, $id)
    {
        $paymentType = PaymentType::find($id);

        if (!$paymentType) {
            return response()->json(['error' => 'Payment type not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|unique:payment_types,name,' . $id,
        ]);

        $paymentType->update($validated);

        return response()->json($paymentType, 200);
    }

    // Deletar um tipo de pagamento
    public function destroy($id)
    {
        $paymentType = PaymentType::find($id);

        if (!$paymentType) {
            return response()->json(['error' => 'Payment type not found'], 404);
        }

        $paymentType->delete();

        return response()->json(['message' => 'Payment type deleted'], 200);
    }
}
