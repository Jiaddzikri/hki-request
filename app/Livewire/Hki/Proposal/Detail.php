<?php

namespace App\Livewire\Hki\Proposal;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;
use App\Models\HkiProposal;
use App\Services\HKI\AuditLogService;
use App\Request\HKI\LogActivityRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Countries;

#[Layout('components.layouts.app')]

class Detail extends Component
{
  #[Locked]
  public $proposalId;

  public $showReviewModal = false;
  public $reviewDecision = '';
  public $reviewNotes = '';
  public $isEditMode = false;

  // Form fields for editing
  public $title = '';
  public $hki_type_id = '';
  public $publication_country = '';
  public $publication_city = '';
  public $publication_date = '';
  public $description = '';

  public function mount($id)
  {
    $this->proposalId = $id;

    // Check authorization
    $proposal = HKIProposal::findOrFail($id);
    if ($proposal->user_id !== auth()->id() && !auth()->user()->hasRole('super-admin|reviewer')) {
      abort(403);
    }
  }

  private function getProposal()
  {
    return HKIProposal::with([
      'user',
      'type',
      'auditLogs.user',
      'members.user',
      'documents',
      'reviews' => function ($query) {
        $query->latest('reviewed_at');
      },
      'reviews.reviewer'
    ])->findOrFail($this->proposalId);
  }

  public function enableEditMode()
  {
    $proposal = $this->getProposal();

    // Only allow edit if status is REVISION
    if ($proposal->status !== 'REVISION') {
      session()->flash('error', 'Hanya proposal dengan status revisi yang dapat diubah.');
      return;
    }

    $this->isEditMode = true;

    // Populate form fields with current data - ensure all are strings
    $this->title = (string) $proposal->title;
    $this->hki_type_id = (string) $proposal->hki_type_id;
    $this->publication_country = (string) $proposal->publication_country;
    $this->publication_city = (string) $proposal->publication_city;
    $this->publication_date = $proposal->publication_date ? \Carbon\Carbon::parse($proposal->publication_date)->format('Y-m-d') : '';
    $this->description = (string) ($proposal->description ?? '');
  }

  public function cancelEdit()
  {
    $this->isEditMode = false;
    $this->reset([
      'title',
      'hki_type_id',
      'publication_country',
      'publication_city',
      'publication_date',
      'description'
    ]);
  }

  public function saveRevision()
  {
    // Validate
    $validated = $this->validate([
      'title' => 'required|string|max:255',
      'hki_type_id' => 'required|exists:hki_types,id',
      'publication_country' => 'required|string|max:2',
      'publication_city' => 'required|string|max:255',
      'publication_date' => 'required|date',
      'description' => 'nullable|string',
    ]);

    try {
      $proposal = $this->getProposal();

      // Update proposal
      $proposal->update([
        'title' => $validated['title'],
        'hki_type_id' => $validated['hki_type_id'],
        'publication_country' => $validated['publication_country'],
        'publication_city' => $validated['publication_city'],
        'publication_date' => $validated['publication_date'],
        'description' => $validated['description'],
      ]);

      // Update status back to SUBMITTED
      $proposal->update(['status' => 'SUBMITTED']);

      // Create audit log
      \App\Models\HKIAuditLog::create([
        'model_type' => HKIProposal::class,
        'model_id' => $proposal->id,
        'user_id' => Auth::id(),
        'action' => 'RESUBMIT_PROPOSAL',
        'payload' => [
          'message' => 'Proposal direvisi dan diajukan kembali',
          'timestamp' => now()->format('Y-m-d H:i:s')
        ],
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
      ]);

      $this->isEditMode = false;

      session()->flash('success', 'Proposal berhasil direvisi dan diajukan kembali.');

    } catch (\Exception $e) {
      session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }

  public function submitReview()
  {
    if (!Gate::allows('review-hki')) {
      abort(403, 'Anda tidak memiliki akses sebagai Reviewer.');
    }

    // Validation rules
    $rules = [
      'reviewDecision' => 'required|in:approved,rejected,revision',
    ];

    // Notes required for rejection and revision
    if (in_array($this->reviewDecision, ['rejected', 'revision'])) {
      $rules['reviewNotes'] = 'required|string|min:10';
    }

    $this->validate($rules);

    try {
      $proposal = $this->getProposal();

      // Create review record
      \App\Models\HKIReview::create([
        'hki_proposal_id' => $proposal->id,
        'reviewer_id' => Auth::id(),
        'review_notes' => $this->reviewNotes,
        'decision' => $this->reviewDecision,
        'reviewed_at' => now(),
      ]);

      // Update proposal status based on decision
      $statusMap = [
        'approved' => 'APPROVED',
        'rejected' => 'REJECTED',
        'revision' => 'REVISION',
      ];

      $proposal->update([
        'status' => $statusMap[$this->reviewDecision]
      ]);

      // Create audit log
      \App\Models\HKIAuditLog::create([
        'model_type' => HKIProposal::class,
        'model_id' => $proposal->id,
        'user_id' => Auth::id(),
        'action' => strtoupper($this->reviewDecision) . '_PROPOSAL',
        'payload' => [
          'decision' => $this->reviewDecision,
          'notes' => $this->reviewNotes,
          'reviewer_name' => Auth::user()->name,
          'timestamp' => now()->format('Y-m-d H:i:s')
        ],
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
      ]);

      $this->showReviewModal = false;
      $this->reset(['reviewDecision', 'reviewNotes']);

      session()->flash('success', 'Review berhasil disimpan.');

    } catch (\Exception $e) {
      session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }

  public function render()
  {
    $proposal = $this->getProposal();

    return view('livewire.hki.proposal.detail', [
      'proposal' => $proposal,
    ]);
  }
}