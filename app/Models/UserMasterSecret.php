<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMasterSecret extends Model
{
    protected $fillable = [
        'user_id',
        'secret_hash',
        'institutional_share',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
