<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LtrAssignmentReview extends Model
{
  use HasUuids;

  protected $table = 'ltr_assignment_reviews';

  protected $fillable = [
    'assignment_request_id',
    'reviewer_id',
    'decision',
    'notes',
    'reviewed_at',
  ];

  protected $casts = [
    'reviewed_at' => 'datetime',
  ];

  public function assignmentRequest(): BelongsTo
  {
    return $this->belongsTo(LtrAssignmentRequest::class, 'assignment_request_id');
  }

  public function reviewer(): BelongsTo
  {
    return $this->belongsTo(User::class, 'reviewer_id');
  }
}
