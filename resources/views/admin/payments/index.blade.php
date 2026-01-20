@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2><i class="fas fa-money-bill-wave text-success me-2"></i>Payment Management</h2>
                <a href="{{ route('admin.payments.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Payment
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Payment Code</th>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td><strong>{{ $payment->payment_code }}</strong></td>
                                        <td>{{ $payment->user->name }}</td>
                                        <td>{{ $payment->formatted_amount }}</td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                            </span>
                                        </td>
                                        <td>{!! $payment->status_badge !!}</td>
                                        <td>{{ $payment->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.payments.show', $payment) }}" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.payments.edit', $payment) }}" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.payments.destroy', $payment) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No payments found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection