<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LtrCategory extends Model
{
  protected $table = 'ltr_categories';

  protected $fillable = [
    'category',
  ];

  /**
   * Get all submissions for this category
   */
  public function submissions(): HasMany
  {
    return $this->hasMany(LtrSubmission::class, 'ltr_category_id');
  }
}
