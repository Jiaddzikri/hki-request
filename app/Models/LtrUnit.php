<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LtrUnit extends Model
{
  protected $table = 'ltr_units';

  protected $fillable = [
    'unit',
  ];

  public $timestamps = false;

  /**
   * Get all submissions for this unit
   */
  public function submissions(): HasMany
  {
    return $this->hasMany(LtrSubmission::class, 'ltr_unit_id');
  }
}
