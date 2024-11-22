<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    // GET /accounts
    public function index()
    {
        $accounts = Account::all();
        return response()->json($accounts, 200);
    }

    // POST /accounts
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|unique:accounts,nome|max:255',
            'numero_conta' => 'required|string|unique:accounts,numero_conta|max:255',
            'agencia' => 'required|string|max:255',
            'saldo' => 'nullable|numeric|min:0',
            'account_type' => 'required|string|max:255',
            'status' => 'nullable|string|in:ativa,inativa,suspensa',
        ]);

        $account = Account::create($validatedData);

        return response()->json($account, 201);
    }

    // GET /accounts/{id}
    public function show($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        return response()->json($account, 200);
    }

    // PUT /accounts/{id}
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nome' => 'sometimes|string|unique:accounts,nome,'.$id.'|max:255',
            'numero_conta' => 'sometimes|string|unique:accounts,numero_conta,'.$id.'|max:255',
            'agencia' => 'sometimes|string|max:255',
            'saldo' => 'sometimes|numeric|min:0',
            'account_type' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|in:ativa,inativa,suspensa',
        ]);

        $account = Account::find($id);

        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        $account->update($validatedData);

        return response()->json($account, 200);
    }

    // DELETE /accounts/{id}
    public function destroy($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        $account->delete();

        return response()->json(['message' => 'Account deleted successfully'], 200);
    }
}
