<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Lista todos os usuários
    public function index()
    {
        return response()->json(User::all());
    }

    // Retorna um usuário específico
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    // Cria um novo usuário
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'email' => 'required|string|email|unique:users',
            'cpf' => 'nullable|string',
            'cnpj' => 'nullable|string',
            'role_id' => 'required|exists:roles,id',
        ]);

        $validated['password'] = bcrypt($validated['password']); // Hash da senha
        $user = User::create($validated);

        return response()->json($user, 201);
    }

    // Atualiza um usuário
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'username' => 'sometimes|string|max:255',
            'password' => 'sometimes|string|min:6',
            'email' => 'sometimes|string|email|unique:users,email,' . $id,
            'cpf' => 'nullable|string',
            'cnpj' => 'nullable|string',
            'role_id' => 'sometimes|exists:roles,id',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return response()->json($user);
    }

    // Remove um usuário
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
