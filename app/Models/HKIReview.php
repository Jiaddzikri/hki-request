<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HKIReview extends Model
{
  protected $table = 'hki_reviews';

  protected $fillable = [
    'hki_proposal_id',
    'reviewer_id',
    'review_notes',
    'decision',
    'reviewed_at',
  ];

  protected $casts = [
    'reviewed_at' => 'datetime',
  ];

  // Relasi ke HKIProposal
  public function proposal(): BelongsTo
  {
    return $this->belongsTo(HKIProposal::class, 'hki_proposal_id');
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

  // Scope untuk review yang sudah selesai
  public function scopeCompleted($query)
  {
    return $query->whereNotNull('reviewed_at');
  }
}
