<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookTracking extends Model
{
    protected $fillable = [
        'book_submission_id',
        'status',
        'description',
        'actor_id',
    ];

    // Relasi ke BookSubmission
    public function bookSubmission(): BelongsTo
    {
        return $this->belongsTo(BookSubmission::class);
    }

    // Relasi ke User (actor yang melakukan perubahan)
    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk mendapatkan tracking terbaru
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Helper method untuk mendapatkan nama actor atau system
    public function getActorName()
    {
        return $this->actor ? $this->actor->name : 'System';
    }
}
