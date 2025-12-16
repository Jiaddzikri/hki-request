<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HKIAuditLog extends Model
{
    protected $table = 'hki_audit_logs';

    protected $guarded = [];
    
    protected $casts = [
        'payload' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo('model');
    }
}