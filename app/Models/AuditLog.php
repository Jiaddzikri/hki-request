<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $fillable = [
        'model_type',
        'model_id',
        'user_id',
        'action',
        'payload',
        'previous_hash',
        'current_hash',
        'digital_signature',
    ];
}
