@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-edit text-warning me-2"></i>Edit Payment</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Payment Code</label>
                            <input type="text" class="form-control" value="{{ $payment->payment_code }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="user_id" class="form-label">User *</label>
                            <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ (old('user_id', $payment->user_id) == $user->id) ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount (Rp) *</label>
                            <input type="number" 
                                   name="amount" 
                                   id="amount" 
                                   class="form-control @error('amount') is-invalid @enderror" 
                                   value="{{ old('amount', $payment->amount) }}"
                                   step="0.01"
                                   min="0"
                                   required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method *</label>
                            <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                <option value="">Select Payment Method</option>
                                <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="credit_card" {{ old('payment_method', $payment->payment_method) == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="e_wallet" {{ old('payment_method', $payment->payment_method) == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                                <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ old('status', $payment->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ old('status', $payment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="failed" {{ old('status', $payment->status) == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" {{ old('status', $payment->status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="reference_number" class="form-label">Reference Number</label>
                            <input type="text" 
                                   name="reference_number" 
                                   id="reference_number" 
                                   class="form-control @error('reference_number') is-invalid @enderror" 
                                   value="{{ old('reference_number', $payment->reference_number) }}">
                            @error('reference_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" 
                                      id="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="3">{{ old('description', $payment->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Payment
                            </button>
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection