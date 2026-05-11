<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HkiSystemState extends Model
{
    protected $fillable = ['key', 'current_global_hash', 'total_logs'];
}
