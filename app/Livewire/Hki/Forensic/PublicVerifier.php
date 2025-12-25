<?php

namespace App\Livewire\Hki\Forensic;

use Livewire\Component;
use App\Models\HkiProposal;
use Livewire\Attributes\Layout;

class PublicVerifier extends Component
{
    public $proposalId;
    public $isValid = false;
    public $proposal;

    #[Layout('layouts.auth')] 

    public function mount($id)
    {
        $this->proposalId = $id;
        
        $this->proposal = HkiProposal::with(['user', 'auditLogs'])->find($id);

        if ($this->proposal && $this->proposal->status === 'APPROVED') {
            $this->isValid = true;
        }
    }
    public function render()
    {
        return view('livewire.hki.forensic.public-verifier');
    }
}