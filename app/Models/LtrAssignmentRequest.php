<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LtrAssignmentRequest extends Model
{
  use HasUuids, SoftDeletes;

  protected $table = 'ltr_assignment_requests';

  protected $fillable = [
    'user_id',
    'assignment_type',
    'full_name',
    'nidn',
    'faculty',
    'academic_positions',
    'start_date',
    'end_date',
    'academic_year',
    'institution_name',
    'institution_address',
    'research_title',
    'estimated_budget',
    'leader_name',
    'pic_name',
    'report_file_path',
    'publication_link',
    'status',
    'submitted_at',
    'reviewed_at',
  ];

  protected $casts = [
    'academic_positions' => 'array',
    'start_date' => 'datetime',
    'end_date' => 'datetime',
    'estimated_budget' => 'decimal:2',
    'submitted_at' => 'datetime',
    'reviewed_at' => 'datetime',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function members(): HasMany
  {
    return $this->hasMany(LtrAssignmentMember::class);
  }

  public function review(): HasOne
  {
    return $this->hasOne(LtrAssignmentReview::class, 'assignment_request_id');
  }
}
