<?php

namespace App\Livewire\Letter;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\LtrSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('components.layouts.app')]

class ReviewerInbox extends Component
{
  use WithPagination, AuthorizesRequests;

  public $search = '';
  public $filterStatus = '';
  public $showReviewModal = false;
  public $selectedSubmission = null;
  public $reviewAction = '';
  public $reviewNotes = '';

  protected $queryString = [
    'search' => ['except' => ''],
    'filterStatus' => ['except' => ''],
  ];

  public function mount()
  {
    // Check if user has permission to review
    $this->authorize('review surat tugas');
  }

  public function updatingSearch()
  {
    $this->resetPage();
  }

  public function updatingFilterStatus()
  {
    $this->resetPage();
  }

  public function openReviewModal($id, $action)
  {
    $this->selectedSubmission = LtrSubmission::with(['user', 'category', 'unit'])->findOrFail($id);
    $this->reviewAction = $action;
    $this->reviewNotes = '';
    $this->showReviewModal = true;
  }

  public function closeReviewModal()
  {
    $this->showReviewModal = false;
    $this->selectedSubmission = null;
    $this->reviewAction = '';
    $this->reviewNotes = '';
    $this->resetValidation();
  }

  public function submitReview()
  {
    // Check permission based on action
    if ($this->reviewAction === 'approve') {
      $this->authorize('approve surat tugas');
    } else {
      $this->authorize('reject surat tugas');
    }

    $this->validate([
      'reviewNotes' => 'required|string|min:10',
    ], [
      'reviewNotes.required' => 'Catatan review wajib diisi.',
      'reviewNotes.min' => 'Catatan review minimal 10 karakter.',
    ]);

    if (!$this->selectedSubmission) {
      session()->flash('error', 'Submission tidak ditemukan.');
      return;
    }

    $status = $this->reviewAction === 'approve' ? 'approved' : 'rejected';

    $this->selectedSubmission->update([
      'status' => $status,
      'reviewer_id' => Auth::id(),
      'review_notes' => $this->reviewNotes,
      'reviewed_at' => now(),
    ]);

    $message = $status === 'approved' ? 'Submission berhasil disetujui!' : 'Submission berhasil ditolak!';
    session()->flash('success', $message);

    $this->closeReviewModal();
  }

  public function viewDetail($id)
  {
    $this->selectedSubmission = LtrSubmission::with(['user', 'category', 'unit', 'reviewer'])->findOrFail($id);
    $this->showReviewModal = true;
    $this->reviewAction = 'view';
  }

  public function render()
  {
    $query = LtrSubmission::with(['user', 'category', 'unit', 'reviewer']);

    if ($this->search) {
      $query->where(function ($q) {
        $q->where('description', 'like', '%' . $this->search . '%')
          ->orWhere('indicators', 'like', '%' . $this->search . '%')
          ->orWhereHas('user', function ($q) {
            $q->where('name', 'like', '%' . $this->search . '%');
          });
      });
    }

    if ($this->filterStatus) {
      $query->where('status', $this->filterStatus);
    }

    $submissions = $query->latest()->paginate(10);

    return view('livewire.letter.reviewer-inbox', [
      'submissions' => $submissions,
    ]);
  }
}
