<?php

namespace App\Http\Controllers;

use App\Models\AccountCostCenter;
use Illuminate\Http\Request;

class AccountCostCenterController extends Controller
{
    // GET /account-cost-centers
    public function index()
    {
        $data = AccountCostCenter::all();
        return response()->json($data, 200);
    }

    // POST /account-cost-centers
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'cost_center_id' => 'required|exists:cost_centers,id',
        ]);

        $accountCostCenter = AccountCostCenter::create($validatedData);

        return response()->json($accountCostCenter, 201);
    }

    // GET /account-cost-centers/{id}
    public function show($id)
    {
        $accountCostCenter = AccountCostCenter::find($id);

        if (!$accountCostCenter) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json($accountCostCenter, 200);
    }

    // PUT /account-cost-centers/{id}
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'cost_center_id' => 'required|exists:cost_centers,id',
        ]);

        $accountCostCenter = AccountCostCenter::find($id);

        if (!$accountCostCenter) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $accountCostCenter->update($validatedData);

        return response()->json($accountCostCenter, 200);
    }

    // DELETE /account-cost-centers/{id}
    public function destroy($id)
    {
        $accountCostCenter = AccountCostCenter::find($id);

        if (!$accountCostCenter) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $accountCostCenter->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }
}
