<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use App\Models\UsersAccount;
use Illuminate\Http\Request;

class accoutController extends Controller
{
    /**
     * Exibe uma lista de contas bancárias.
     */
    public function index()
    {
        // Carrega todas as contas com os usuários associados
        $accounts = Account::all();
        return response()->json($accounts);
    }

    /**
     * Cria uma nova conta bancária e associa a um usuário.
     */
    public function store(Request $request)
    {
        try {
            $account = Account::create([
                'nome' => $request->nome,
                'numero_conta' => $request->numero_conta,
                'agencia' => $request->agencia,
                'saldo' => 0.00, // ou defina outro valor se necessário
                'account_type' => $request->account_type,
                'status' => $request->status,
            ]);
    
            // Associa a conta ao usuário
            $user = User::findOrFail($request->id_cliente);
    
            UsersAccount::create([
                'user_id' => $user->id,
                'account_id' => $account->id,
            ]);
    
            return response()->json(['message' => 'Conta criada com sucesso!', 'account' => $account], 201);
    
        } catch (\Exception $error) {
            // Retorna uma resposta com o erro em formato JSON e código de status 500
            return response()->json([
                'message' => 'Erro ao criar conta',
                'error' => $error->getMessage()
            ], 500);
        }
    }
    

    /**
     * Exibe uma conta bancária específica.
     */
    public function show($id)
    {
        $account = Account::with('users')->findOrFail($id);
        return response()->json($account);
    }

    /**
     * Atualiza uma conta bancária existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'numero_conta' => 'required|unique:accounts,numero_conta,' . $id,
            'agencia' => 'required',
            'saldo' => 'required|numeric',
            'account_type' => 'required',
            'status' => 'required',
        ]);

        $account = Account::findOrFail($id);

        $account->update($request->all());



        return response()->json(['message' => 'Conta atualizada com sucesso!', 'account' => $account]);
    }

    /**
     * Remove uma conta bancária.
     */
    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return response()->json(['message' => 'Conta deletada com sucesso!']);
    }
}
