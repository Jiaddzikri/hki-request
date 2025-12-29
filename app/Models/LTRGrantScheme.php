<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LTRGrantScheme extends Model
{
    protected $table = 'ltr_grant_schemes';
    protected $guarded = [];

    protected $casts = [
        'max_budget' => 'decimal:2',
        'requires_external_partner' => 'boolean',
        'requires_student_member' => 'boolean',
    ];

}