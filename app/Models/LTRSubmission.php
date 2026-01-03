<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LtrSubmission extends Model
{
  protected $table = 'ltr_submissions';

  protected $fillable = [
    'user_id',
    'ltr_category_id',
    'ltr_unit_id',
    'description',
    'indicators',
    'budget',
    'planned_start_date',
    'planned_end_date',
    'url_documentation',
    'status',
    'reviewer_id',
    'review_notes',
    'reviewed_at',
  ];

  protected $casts = [
    'budget' => 'double',
    'planned_start_date' => 'datetime',
    'planned_end_date' => 'datetime',
    'reviewed_at' => 'datetime',
  ];

  /**
   * Get the user that owns the submission
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  /**
   * Get the category for this submission
   */
  public function category(): BelongsTo
  {
    return $this->belongsTo(LtrCategory::class, 'ltr_category_id');
  }

  /**
   * Get the unit for this submission
   */
  public function unit(): BelongsTo
  {
    return $this->belongsTo(LtrUnit::class, 'ltr_unit_id');
  }

  /**
   * Get the reviewer that reviewed this submission
   */
  public function reviewer(): BelongsTo
  {
    return $this->belongsTo(User::class, 'reviewer_id');
  }
}
