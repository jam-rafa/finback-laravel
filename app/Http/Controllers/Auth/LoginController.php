<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            die('true');
        } else {
            die('false');
        }
    }

    public function store(Request $request)
    {
        try {
            // Validação dos campos do request
            $credentials = $request->validate([
                'email' => 'required',
                'password' => 'required|string',
            ]);

            // Tentativa de autenticação
            if (Auth::attempt($credentials)) {
                return response()->json(['success' => true, 'message' => 'Login realizado com sucesso.'], 200);
            }
        } catch (\Exception $e) {
            // Captura de erros inesperados
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao tentar realizar o login.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
