<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

        protected $fillable = [
        'title',
        'description',
        'priority',
        'due_date',
        'status',
        'user_id',
        'created_by',
    ];


    protected $casts = [
        'due_date' => 'date',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}