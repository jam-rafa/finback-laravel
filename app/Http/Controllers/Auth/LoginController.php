<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  /**
   * Verifica se o usuário está autenticado.
   */
  public function index(Request $request)
  {
    $user = Auth::guard('sanctum')->user();

    if ($user) {
      return response()->json([
        'message' => 'Token válido',
        'valid' => true,
      ], 200);
    } else {
      return response()->json([
        'message' => 'Token inválido ou expirado',
        'valid' => false,

      ], 401);
    }
  }

  /**
   * Realiza login e gera um token de acesso.
   */
  public function store(Request $request)
  {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required|string',
    ]);

    // $request -> session()->regenerate();

    // Tentativa de autenticação
    if (Auth::attempt($credentials)) {
      $user = Auth::user(); // Recupera o usuário autenticado
      // Cria um token pessoal para o usuário
      $token = $user->createToken('user-token',  ['server:update'], now()->addHour(1));

      return response()->json([
        'success' => true,
        'message' => 'Login realizado com sucesso.',
        'token' => $token->plainTextToken,
      ], 200);
    }

    return response()->json([
      'success' => false,
      'message' => 'Credenciais inválidas.',
    ], 401);
  }
  public function destroy(Request $request)
  {
    $validatedData = $request->validate([
      'id' => 'required|integer', // 'number' deve ser 'integer'
    ]);

    // Recupera o usuário autenticado
    $user = $request->user();

    // Verifica se o token existe e o remove
    $deleted = $user->tokens()->where('id', $validatedData['id'])->delete();

    if ($deleted) {
      return response()->json([
        'success' => true,
        'message' => 'Token removido com sucesso.',
      ], 200);
    }

    return response()->json([
      'success' => false,
      'message' => 'Token não encontrado.',
    ], 404);
  }
}
