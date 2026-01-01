<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HKIProposalMember extends Model
{
  protected $table = 'hki_proposal_members';

  protected $fillable = [
    'hki_proposal_id',
    'user_id',
    'name',
    'role',
    'nik',
    'npwp',
    'detail',
    'nidn',
    'email'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function proposal(): BelongsTo
  {
    return $this->belongsTo(HKIProposal::class, 'hki_proposal_id', 'id');
  }
}
