<?php

namespace App\Http\Controllers\Api\Accounts;

use App\Http\Controllers\Controller;
use App\Models\AccountUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountsController extends Controller
{
    public function index(Request $request)
    {

        $userId = Auth::guard('sanctum')->user()->id;

        $accounts = AccountUser::where('user_id', $userId)
        ->join('accounts', 'accounts.id', '=', 'account_id')
        ->get();


        return response()->json(
            $accounts
        );
    }
}
