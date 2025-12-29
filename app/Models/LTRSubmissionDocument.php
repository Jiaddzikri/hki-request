<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LTRSubmissionDocument extends Model
{
    protected $table = 'ltr_submission_documents';

    protected $fillable = [
        'submission_id',
        'type',
        'file_path',
        'original_name',
        'file_size',
        'file_hash',
        'created_at',
        'updated_at'
    ];
}
