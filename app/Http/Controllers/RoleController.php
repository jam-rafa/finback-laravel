<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Listar todos os roles
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles, 200);
    }

    // Criar um novo role
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $role = Role::create($validated);

        return response()->json($role, 201);
    }

    // Exibir um role específico
    public function show($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        return response()->json($role, 200);
    }

    // Atualizar um role existente
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
        ]);

        $role->update($validated);

        return response()->json($role, 200);
    }

    // Deletar um role
    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        $role->delete();

        return response()->json(['message' => 'Role deleted'], 200);
    }
}
