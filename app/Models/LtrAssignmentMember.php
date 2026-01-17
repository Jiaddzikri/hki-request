<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LtrAssignmentMember extends Model
{
  protected $table = 'ltr_assignment_members';

  protected $fillable = [
    'ltr_assignment_request_id',
    'email',
    'name',
    'nidn_nip_nim',
    'faculty',
    'academic_position',
    'institutions',
  ];

  protected $casts = [
    'institutions' => 'array',
    'academic_position' => 'array'
  ];

  public function assignmentRequest(): BelongsTo
  {
    return $this->belongsTo(LtrAssignmentRequest::class, 'ltr_assignment_request_id');
  }
}
