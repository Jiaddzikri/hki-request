<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookReview extends Model
{
    protected $fillable = [
        'book_submission_id',
        'reviewer_id',
        'review_notes',
        'review_file_path',
        'decision',
        'deadline_at',
        'reviewed_at',
    ];

    protected $casts = [
        'deadline_at' => 'date',
        'reviewed_at' => 'datetime',
    ];

    // Relasi ke BookSubmission
    public function bookSubmission(): BelongsTo
    {
        return $this->belongsTo(BookSubmission::class);
    }

    // Relasi ke User (reviewer)
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    // Helper method untuk cek apakah sudah direview
    public function isReviewed()
    {
        return !is_null($this->reviewed_at);
    }

    // Helper method untuk cek apakah melewati deadline
    public function isPastDeadline()
    {
        return $this->deadline_at && now()->isAfter($this->deadline_at);
    }

    // Scope untuk review yang belum selesai
    public function scopePending($query)
    {
        return $query->whereNull('reviewed_at');
    }

    // Scope untuk review yang sudah selesai
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('reviewed_at');
    }

    // Scope untuk filter berdasarkan decision
    public function scopeByDecision($query, $decision)
    {
        return $query->where('decision', $decision);
    }
}
