<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // <== ditambahkan supaya role bisa diupdate
        'avatar',
        'balance',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * Format balance
     */
    public function getFormattedBalanceAttribute()
    {
        return 'Rp ' . number_format($this->balance, 0, ',', '.');
    }

    /**
     * Relation to payments
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Relation to tasks
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->is_admin === true;
    }
}
