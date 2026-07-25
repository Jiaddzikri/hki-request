<?php

namespace App\Livewire\Hki\Forensic;

use Livewire\Component;
use App\Models\HKIProposal;
use Livewire\Attributes\Layout;

class PublicVerifier extends Component
{
    public $proposalId;
    public $isValid = false;
    public $isForensicsDisabled = false;
    public $proposal;

    #[Layout('layouts.auth')] 

    public function mount($id, \App\Services\HKI\AuditLogService $auditLogService)
    {
        $this->proposalId = $id;
        
        $this->proposal = HKIProposal::with(['user', 'auditLogs'])->find($id);

        if ($this->proposal && $this->proposal->status === 'APPROVED') {
            $this->isValid = true;
        }

        // Verify forensic chain
        $chainState = $auditLogService->verifyChain($id);
        
        if (isset($chainState['status']) && $chainState['status'] === 'FORENSICS_DISABLED') {
            $this->isForensicsDisabled = true;
            $this->isValid = false; // Override to prevent false positive green checkmark
        }
    }
    public function render()
    {
        return view('livewire.hki.forensic.public-verifier');
    }
}