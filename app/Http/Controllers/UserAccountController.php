<?php

namespace App\Http\Controllers;

use App\Models\UserAccount;
use Illuminate\Http\Request;

class UserAccountController extends Controller
{
    // Listar todas as associações entre usuários e contas
    public function index()
    {
        try {
            $usersAccounts = UserAccount::with(['user', 'account'])->get();
            return response()->json($usersAccounts, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch UserAccounts', 'details' => $e->getMessage()], 500);
        }
    }

    // Salvando associação entre usuários e contas
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'account_id' => 'required|exists:accounts,id',
            ]);
            // Define um valor padrão para 'owner' caso não venha no request
            $validated['owner'] = $request->input('owner', false);

            $userAccount = UserAccount::create($validated);
            $userAccount = UserAccount::create($validated);

            return response()->json($userAccount, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create UserAccount', 'details' => $e->getMessage()], 500);
        }
    }

    // Exibir uma associação específica
    public function show($id)
    {
        try {
            $userAccount = UserAccount::with(['user', 'account'])->find($id);

            if (!$userAccount) {
                return response()->json(['error' => 'UserAccount not found'], 404);
            }

            return response()->json($userAccount, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch UserAccount', 'details' => $e->getMessage()], 500);
        }
    }

    // Atualizar uma associação existente
    public function update(Request $request, $id)
    {
        try {
            $userAccount = UserAccount::find($id);

            if (!$userAccount) {
                return response()->json(['error' => 'UserAccount not found'], 404);
            }

            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'account_id' => 'required|exists:accounts,id',
            ]);

            $userAccount->update($validated);

            return response()->json($userAccount, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update UserAccount', 'details' => $e->getMessage()], 500);
        }
    }

    // Deletar uma associação
    public function destroy($id)
    {
        try {
            $userAccount = UserAccount::find($id);

            if (!$userAccount) {
                return response()->json(['error' => 'UserAccount not found'], 404);
            }

            $userAccount->delete();

            return response()->json(['message' => 'UserAccount deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete UserAccount', 'details' => $e->getMessage()], 500);
        }
    }
}
