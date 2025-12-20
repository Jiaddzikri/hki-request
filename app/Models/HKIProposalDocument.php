<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HKIProposalDocument extends Model
{
    protected $table = 'hki_proposal_documents';

    protected $fillable = [
        'hki_proposal_id',
        'name',
        'file_path',
        'mime_type',
        'file_size',
        'file_hash',
    ];
}
