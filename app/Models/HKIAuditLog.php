<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HKIAuditLog extends Model
{
    protected $table = 'hki_audit_logs';

    protected $guarded = [];

    protected $casts = [
        'payload' => 'array',
        'model_id' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject()
    {
        return $this->morphTo('model');
    }
}