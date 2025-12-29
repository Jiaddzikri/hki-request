<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LTRSubmissionMember extends Model
{
    protected $table = 'ltr_submission_members';

    protected $fillable = [
        'submission_id',
        'name',
        'role',
        'identifier_number'
    ];
}
