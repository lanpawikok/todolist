<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $payments = $user->payments()
            ->where('status', 'completed')
            ->latest()
            ->paginate(10);

        $totalReceived = $user->payments()
            ->where('status', 'completed')
            ->sum('amount');

        return view('user.balance.index', compact('user', 'payments', 'totalReceived'));
    }
}