@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2><i class="fas fa-receipt text-info me-2"></i>Payment Details</h2>
                <div>
                    <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
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
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Payment Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Payment Code:</div>
                        <div class="col-md-8">
                            <span class="badge bg-dark fs-6">{{ $payment->payment_code }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">User:</div>
                        <div class="col-md-8">{{ $payment->user->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Email:</div>
                        <div class="col-md-8">{{ $payment->user->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Amount:</div>
                        <div class="col-md-8">
                            <span class="fs-4 text-success fw-bold">{{ $payment->formatted_amount }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Payment Method:</div>
                        <div class="col-md-8">
                            <span class="badge bg-secondary">
                                {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status:</div>
                        <div class="col-md-8">{!! $payment->status_badge !!}</div>
                    </div>

                    @if($payment->reference_number)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Reference Number:</div>
                        <div class="col-md-8">{{ $payment->reference_number }}</div>
                    </div>
                    @endif

                    @if($payment->description)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Description:</div>
                        <div class="col-md-8">{{ $payment->description }}</div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Created At:</div>
                        <div class="col-md-8">{{ $payment->created_at->format('d M Y H:i') }}</div>
                    </div>

                    @if($payment->paid_at)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Paid At:</div>
                        <div class="col-md-8">{{ $payment->paid_at->format('d M Y H:i') }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Status Update -->
            <div class="card">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="fas fa-sync-alt me-2"></i>Update Status</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.payments.update-status', $payment) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $payment->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $payment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="refunded" {{ $payment->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="reference_number" class="form-label">Reference Number</label>
                                <input type="text" 
                                       name="reference_number" 
                                       id="reference_number" 
                                       class="form-control"
                                       value="{{ $payment->reference_number }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection