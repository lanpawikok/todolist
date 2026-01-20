<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.payments.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:bank_transfer,credit_card,e_wallet,cash',
            'description' => 'nullable|string',
            'auto_complete' => 'nullable|boolean',
        ]);

        // Create payment data
        $payment = Payment::create([
            'user_id' => $validated['user_id'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'status' => $request->has('auto_complete') ? 'completed' : 'pending',
            'description' => $validated['description'] ?? null,
            'payment_code' => 'PAY-' . strtoupper(Str::random(8)),
            'paid_at' => $request->has('auto_complete') ? now() : null,
        ]);

        // Update user balance if auto_complete checked
        if ($request->has('auto_complete')) {
            $user = User::find($validated['user_id']);
            if ($user) {
                $user->balance += $validated['amount'];
                $user->save();
            }
        }

        return redirect()->route('admin.payments.index')->with('success', 'Payment created successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load('user');
        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $users = User::all();
        return view('admin.payments.edit', compact('payment', 'users'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:bank_transfer,credit_card,e_wallet,cash',
            'status' => 'required|in:pending,processing,completed,failed,refunded',
            'description' => 'nullable|string',
            'reference_number' => 'nullable|string',
        ]);

        if ($validated['status'] === 'completed' && $payment->status !== 'completed') {
            $validated['paid_at'] = now();

            // Update saldo user saat payment berhasil
            $user = User::find($validated['user_id']);
            if ($user) {
                $user->balance += $payment->amount; // gunakan amount payment lama
                $user->save();
            }
        }

        $payment->update($validated);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment updated successfully');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully');
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,failed,refunded',
            'reference_number' => 'nullable|string',
        ]);

        if ($validated['status'] === 'completed' && $payment->status !== 'completed') {
            $validated['paid_at'] = now();

            // Update saldo user saat payment berhasil
            $user = $payment->user;
            if ($user) {
                $user->balance += $payment->amount;
                $user->save();
            }
        }

        $payment->update($validated);

        return redirect()->back()
            ->with('success', 'Payment status updated successfully');
    }
}
