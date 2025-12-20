<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

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

    public function documents()
    {
        return $this->hasMany(HKIProposalDocument::class, 'hki_proposal_id');
    }
}
