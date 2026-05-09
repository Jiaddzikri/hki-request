<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class HKIProposalSignature extends Model
{
    use HasUuids;

    protected $table = 'hki_proposal_signatures';

    protected $fillable = [
        'hki_proposal_id',
        'user_id',
        'credential_id',
        'signature',
        'authenticator_data',
        'client_data_json',
        'signed_at',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
    ];

    public function proposal()
    {
        return $this->belongsTo(HKIProposal::class, 'hki_proposal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
