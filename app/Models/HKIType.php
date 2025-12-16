<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HKIType extends Model
{
    protected $table = 'hki_types';
    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(HkiType::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(HkiType::class, 'parent_id');
    }
}