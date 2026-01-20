<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Balance - ToDoList</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold text-primary mb-0">
                <i class="fas fa-wallet"></i> My Balance
            </span>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ url('/profile') }}" class="text-decoration-none">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </div>
                </a>
                <div class="d-none d-md-block">
                    <div class="fw-semibold small">{{ Auth::user()->name }}</div>
                    <div class="text-muted" style="font-size: 0.75rem;">{{ Auth::user()->email }}</div>
                </div>
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold text-primary mb-0">
                <i class="fas fa-wallet"></i> My Balance
            </h1>
            <a href="{{ route('tasks.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Tasks
            </a>
        </div>

        <!-- Balance Card -->
        <div class="card border-0 shadow-sm bg-primary text-white mb-4">
            <div class="card-body p-4">
                <div class="mb-3">
                    <small class="opacity-75"><i class="fas fa-money-bill-wave me-2"></i>Current Balance</small>
                </div>
                <h2 class="display-4 fw-bold mb-4">
                    {{ $user->formatted_balance }}
                </h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2 small opacity-75">Total Received</div>
                        <h4 class="fw-semibold">Rp {{ number_format($totalReceived, 0, ',', '.') }}</h4>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2 small opacity-75">Total Transactions</div>
                        <h4 class="fw-semibold">{{ $payments->total() }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h4 class="fw-semibold mb-4">
                    <i class="fas fa-history me-2"></i>Transaction History
                </h4>

                @if($payments->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($payments as $payment)
                            <div class="list-group-item border-0 border-bottom px-0 py-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="fw-bold text-success mb-1">
                                            + {{ $payment->formatted_amount }}
                                        </h5>
                                        <small class="text-primary fw-semibold">{{ $payment->payment_code }}</small>
                                    </div>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> Completed
                                    </span>
                                </div>
                                <div class="d-flex gap-3 flex-wrap mb-2">
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-credit-card"></i> {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                    </span>
                                    <small class="text-muted">
                                        <i class="far fa-calendar"></i> {{ $payment->paid_at->format('d M Y H:i') }}
                                    </small>
                                </div>
                                @if($payment->description)
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i> {{ $payment->description }}
                                    </small>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $payments->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <i class="fas fa-receipt fa-5x text-muted mb-3"></i>
                        <h3 class="text-muted">No Transactions Yet</h3>
                        <p class="text-muted">You haven't received any payments</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>