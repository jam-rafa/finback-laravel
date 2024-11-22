<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    // GET /movements
    public function index()
    {
        $movements = Movement::all();
        return response()->json($movements, 200);
    }

    // POST /movements
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'cost_type' => 'required|string',
            'value' => 'required|numeric',
            'nature_id' => 'required|exists:natures,id',
            'payment_type_id' => 'required|exists:payment_types,id',
            'cost_center_id' => 'required|exists:cost_centers,id',
            'account_id' => 'required|exists:account_id,id'
        ]);

        $movement = Movement::create($validatedData);

        return response()->json($movement, 201);
    }

    // GET /movements/{id}
    public function show($id)
    {
        $movement = Movement::find($id);

        if (!$movement) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json($movement, 200);
    }

    // PUT /movements/{id}
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'cost_type' => 'required|string',
            'value' => 'required|numeric',
            'nature_id' => 'required|exists:natures,id',
            'payment_type_id' => 'required|exists:payment_types,id',
            'cost_center_id' => 'required|exists:cost_centers,id',
        ]);

        $movement = Movement::find($id);

        if (!$movement) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $movement->update($validatedData);

        return response()->json($movement, 200);
    }

    // DELETE /movements/{id}
    public function destroy($id)
    {
        $movement = Movement::find($id);

        if (!$movement) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $movement->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }
}
