<?php

namespace App\Livewire\Hki\Proposal;

use App\Models\HkiProposal;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Detail extends Component
{
    use AuthorizesRequests;

    public $proposal;

    public function mount($id)
    {
        $this->proposal = HkiProposal::with(['type', 'members', 'documents', 'auditLogs.user'])
            ->findOrFail($id);

        if ($this->proposal->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak melihat dokumen forensik ini.');
        }
    }

    public function render()
    {
        return view('livewire.hki.proposal.detail');
    }
}