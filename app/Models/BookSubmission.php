<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookSubmission extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'user_id',
    'title',
    'isbn_request_type',
    'publication_media',
    'reader_group',
    'library_type',
    'library_category',
    'has_kdt',
    'estimated_publish_month',
    'estimated_publish_year',
    'province',
    'city',
    'distributor',
    'description',
    'total_pages',
    'book_height_cm',
    'edition',
    'series',
    'has_illustration',
    'publication_url',
    'isbn',
    'e_isbn',
    'publication_year',
    'similarity_score',
    'status',
    'submitted_at',
    'published_at',
  ];

  protected $casts = [
    'total_pages' => 'integer',
    'book_height_cm' => 'decimal:2',
    'publication_year' => 'integer',
    'estimated_publish_year' => 'integer',
    'similarity_score' => 'float',
    'has_kdt' => 'boolean',
    'has_illustration' => 'boolean',
    'submitted_at' => 'datetime',
    'published_at' => 'datetime',
    'deleted_at' => 'datetime',
  ];

  // Relasi ke User (Pengusul)
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  // Relasi ke Authors
  public function authors(): HasMany
  {
    return $this->hasMany(BookAuthor::class);
  }

  // Relasi ke Files
  public function files(): HasMany
  {
    return $this->hasMany(BookFile::class);
  }

  // Relasi ke Reviews
  public function reviews(): HasMany
  {
    return $this->hasMany(BookReview::class);
  }

  // Relasi ke Trackings
  public function trackings(): HasMany
  {
    return $this->hasMany(BookTracking::class);
  }

  // Helper method untuk mendapatkan corresponding author
  public function correspondingAuthor()
  {
    return $this->authors()->where('is_corresponding', true)->first();
  }

  // Helper method untuk mendapatkan latest tracking
  public function latestTracking()
  {
    return $this->trackings()->latest()->first();
  }

  // Scope untuk filter berdasarkan status
  public function scopeByStatus($query, $status)
  {
    return $query->where('status', $status);
  }

  // Scope untuk filter berdasarkan user
  public function scopeByUser($query, $userId)
  {
    return $query->where('user_id', $userId);
  }
}
