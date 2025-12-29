<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LTRSubmissionBudgetDetail extends Model
{
    protected $table = 'ltr_submission_budget_details';

    protected $fillable = [
        'submission_id',
        'item_description',
        'volume',
        'unit',
        'unit_cost',
        'total_cost',
        'category',
        'created_at',
        'updated_at'
    ];
}
