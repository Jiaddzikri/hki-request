<?php

namespace App\Livewire\Hki\Proposal;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\HkiProposal;
use App\Services\HKI\AuditLogService;
use App\Request\HKI\LogActivityRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]

class Detail extends Component
{
    public ?HKIProposal $proposal;
    
    public $showReviewModal = false;
    public $reviewAction = '';
    public $reviewNote = '';
    public $pin = '';

    public function mount($id)
    {
        $this->proposal = HKIProposal::with(['user', 'type', 'auditLogs.user'])->findOrFail($id);
    }
    public function confirmReview($action)
    {
        if (!Gate::allows('review-hki')) {
            abort(403, 'Anda tidak memiliki akses sebagai Reviewer.');
        }

        $this->reviewAction = $action;
        $this->showReviewModal = true;
        $this->reset(['reviewNote', 'pin']);
    }

    public function submitReview(AuditLogService $auditService)
    {
        $this->validate([
            'reviewNote' => 'required|string|min:5',
            'pin' => 'required|digits:6',
        ]);

        $newStatus = ($this->reviewAction === 'APPROVE') ? 'APPROVED' : 'REJECTED';
        $logAction = ($this->reviewAction === 'APPROVE') ? 'APPROVE_PROPOSAL' : 'REJECT_PROPOSAL';

        try {
            $this->proposal->status = $newStatus;

            $this->proposal->save();
            
            $request = new LogActivityRequest();
            $request->user = Auth::user();
            $request->action = $logAction;
            $request->modelType = $this->proposal;
            $request->modelId = $this->proposal->id;
            
            $request->payload = [
                'decision' => $newStatus,
                'note' => $this->reviewNote,
                'reviewer_name' => Auth::user()->name,
                'timestamp' => now()->format('Y-m-d H:i:s')
            ];
            

            $request->pin = trim((string) $this->pin); 

            $auditService->logActivity($request);

            $this->showReviewModal = false;
            session()->flash('success', "Proposal berhasil di-{$this->reviewAction}.");
            
            return redirect()->route('hki.reviewer.inbox');

        } catch (\Exception $e) {
            $this->addError('pin', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.hki.proposal.detail');
    }
}