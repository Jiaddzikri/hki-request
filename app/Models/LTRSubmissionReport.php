<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LTRSubmissionReport extends Model
{
    protected $table = 'ltr_submission_reports';
    protected $guarded = [];

    public function submission()
    {
        return $this->belongsTo(LTRSubmission::class, 'submission_id');
    }


}
