<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookAuthor extends Model
{
  protected $fillable = [
    'book_submission_id',
    'role_category',
    'name',
    'nidn_nip',
    'affiliation',
    'email',
    'position',
    'is_corresponding',
  ];

  protected $casts = [
    'position' => 'integer',
    'is_corresponding' => 'boolean',
  ];

  // Relasi ke BookSubmission
  public function bookSubmission(): BelongsTo
  {
    return $this->belongsTo(BookSubmission::class);
  }

  // Scope untuk corresponding author
  public function scopeCorresponding($query)
  {
    return $query->where('is_corresponding', true);
  }

  // Scope untuk ordering by position
  public function scopeOrdered($query)
  {
    return $query->orderBy('position');
  }
}
