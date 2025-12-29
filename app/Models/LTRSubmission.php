<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LTRSubmission extends Model
{
    use SoftDeletes;

    protected $table = 'ltr_submissions';

    protected $guarded = [];

    protected $casts = [
        'total_budget_proposed' => 'decimal:2',
        'total_budget_approved' => 'decimal:2',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scheme() {
        return $this->belongsTo(LTRGrantScheme::class, 'grant_scheme_id');
    }

    public function period() {
        return $this->belongsTo(LTRAcademicPeriod::class, 'academic_period_id');
    }

    public function members() {
        return $this->hasMany(LTRSubmissionMember::class, 'submission_id');
    }

    public function budgetDetails() {
        return $this->hasMany(LTRSubmissionBudgetDetail::class, 'submission_id');
    }

    public function documents() {
        return $this->hasMany(LTRSubmissionDocument::class, 'submission_id');
    }
    
    public function isEditable() {
        return in_array($this->status, ['DRAFT', 'REVISION_REQUIRED']);
    }
}