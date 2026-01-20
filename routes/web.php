<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\User\BalanceController;
use Illuminate\Support\Facades\Route;

// ===== PUBLIC ROUTES =====
Route::get('/', function () {
    return view('welcome');
});

// ===== AUTH ROUTES (Manual) =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===================================================================
// ======================== ADMIN ROUTES ==============================
// ===================================================================
// Semua route admin dipisah pakai prefix /admin agar tidak bentrok
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // ========== USER MANAGEMENT ==========
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('users.show');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.destroy');

        // ========== TASK MANAGEMENT (ADMIN) ==========
        // Tidak mengganggu routes user karena sudah berada di prefix /admin
        Route::get('/tasks', [AdminController::class, 'tasks'])->name('tasks.index');
        Route::get('/tasks/create', [AdminController::class, 'createTask'])->name('tasks.create');
        Route::post('/tasks', [AdminController::class, 'storeTask'])->name('tasks.store');
        Route::get('/tasks/{id}', [AdminController::class, 'showTask'])->name('tasks.show');
        Route::get('/tasks/{id}/edit', [AdminController::class, 'editTask'])->name('tasks.edit');
        Route::put('/tasks/{id}', [AdminController::class, 'updateTask'])->name('tasks.update');
        Route::delete('/tasks/{id}', [AdminController::class, 'deleteTask'])->name('tasks.destroy');
        Route::patch('/tasks/{id}/toggle', [AdminController::class, 'toggleTaskComplete'])->name('tasks.toggle');
        Route::get('/dashboard/stats', [AdminController::class, 'stats'])->name('dashboard.stats');

        // ========== PAYMENT MANAGEMENT ==========
        Route::resource('payments', PaymentController::class);
        Route::post('payments/{payment}/update-status', [PaymentController::class, 'updateStatus'])
            ->name('payments.update-status');
    });

// ===================================================================
// ====================== USER ROUTES =================================
// ===================================================================
Route::middleware('auth')->group(function () {

    // ===== PROFILE ROUTES =====
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');

    // ===== BALANCE ROUTES =====
    Route::get('/balance', [BalanceController::class, 'index'])->name('balance.index');

    // ===== RECYCLE BIN ROUTES =====
    Route::get('/tasks/trash', [TaskController::class, 'trash'])->name('tasks.trash');
    Route::post('/tasks/{id}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
    Route::delete('/tasks/{id}/force-delete', [TaskController::class, 'forceDelete'])->name('tasks.forceDelete');

    // ===== USER TASK ROUTES (CRUD) =====
    Route::resource('tasks', TaskController::class);

    // Toggle task completion
    Route::post('/tasks/{task}/toggle', [TaskController::class, 'toggleComplete'])->name('tasks.toggle');
});