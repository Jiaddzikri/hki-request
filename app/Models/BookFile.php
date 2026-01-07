<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class BookFile extends Model
{
    protected $fillable = [
        'book_submission_id',
        'type',
        'file_path',
        'file_name',
        'file_size',
        'version',
        'uploaded_by',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'version' => 'integer',
    ];

    // Relasi ke BookSubmission
    public function bookSubmission(): BelongsTo
    {
        return $this->belongsTo(BookSubmission::class);
    }

    // Relasi ke User (uploader)
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Helper method untuk mendapatkan URL file
    public function getFileUrl()
    {
        return Storage::url($this->file_path);
    }

    // Helper method untuk mendapatkan ukuran file dalam format readable
    public function getReadableFileSize()
    {
        $size = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    // Scope untuk filter berdasarkan type
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope untuk mendapatkan versi terbaru
    public function scopeLatestVersion($query)
    {
        return $query->orderBy('version', 'desc');
    }
}
