<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HKIProposal extends Model
{
    use HasUuids;
    protected $table = 'hki_proposals';

    protected $fillable = [
        'user_id',
        'hki_type_id',
        'title',
        'publication_country',
        'publication_city',
        'publication_date',
        'status',
        'description',
        'url_detail'
    ];

    public function members()
    {
        return $this->hasMany(HKIProposalMember::class, 'hki_proposal_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(HKIType::class, 'hki_type_id');
    }

    public function documents()
    {
        return $this->hasMany(HKIProposalDocument::class, 'hki_proposal_id');
    }

    public function auditLogs()
    {
        return $this->morphMany(HKIAuditLog::class, 'model', 'model_type', 'model_id', 'id')->latest();
    }
}
