@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit User</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- NAME --}}
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}"
                        required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input 
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}"
                        required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PASSWORD (OPTIONAL) --}}
                <div class="mb-3">
                    <label class="form-label">Password Baru (opsional)</label>
                    <input 
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Kosongkan jika tidak ingin mengubah password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input 
                        type="password"
                        name="password_confirmation"
                        class="form-control">
                </div>

                {{-- ROLE --}}
                <div class="mb-3">
                    <label class="form-label">Role User</label>
                    <select 
                        name="is_admin" 
                        class="form-select @error('is_admin') is-invalid @enderror"
                        required>
                        
                        <option value="0" {{ old('is_admin', $user->is_admin) == 0 ? 'selected' : '' }}>
                            User Biasa
                        </option>

                        <option value="1" {{ old('is_admin', $user->is_admin) == 1 ? 'selected' : '' }}>
                            Admin
                        </option>

                    </select>

                    @error('is_admin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update
                    </button>

                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
