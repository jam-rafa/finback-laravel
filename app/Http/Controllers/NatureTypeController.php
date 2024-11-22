<?php

namespace App\Http\Controllers;

use App\Models\NatureType;
use Illuminate\Http\Request;

class NatureTypeController extends Controller
{
    // GET /nature-types
    public function index()
    {
        $natureTypes = NatureType::all();
        return response()->json($natureTypes, 200);
    }

    // POST /nature-types
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'nature_id' => 'required|exists:natures,id',
        ]);

        $natureType = NatureType::create($validatedData);

        return response()->json($natureType, 201);
    }

    // GET /nature-types/{id}
    public function show($id)
    {
        $natureType = NatureType::find($id);

        if (!$natureType) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json($natureType, 200);
    }

    // PUT /nature-types/{id}
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'nature_id' => 'required|exists:natures,id',
        ]);

        $natureType = NatureType::find($id);

        if (!$natureType) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $natureType->update($validatedData);

        return response()->json($natureType, 200);
    }

    // DELETE /nature-types/{id}
    public function destroy($id)
    {
        $natureType = NatureType::find($id);

        if (!$natureType) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $natureType->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }
}
