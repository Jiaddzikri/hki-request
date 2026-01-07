<?php

namespace App\Livewire\Book;

use App\Models\BookSubmission;
use App\Models\BookReview;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ReviewerDetail extends Component
{
  public $submission;
  public $showReviewForm = false;
  public $reviewStatus = '';
  public $reviewNotes = '';

  public function mount($id)
  {
    $this->submission = BookSubmission::with(['user', 'authors', 'files', 'reviews.reviewer'])
      ->findOrFail($id);
  }

  public function toggleReviewForm()
  {
    $this->showReviewForm = !$this->showReviewForm;

    if (!$this->showReviewForm) {
      $this->resetReviewForm();
    }
  }

  public function resetReviewForm()
  {
    $this->reviewStatus = '';
    $this->reviewNotes = '';
  }

  public function submitReview()
  {
    $this->validate([
      'reviewStatus' => 'required|in:approved,revision,rejected',
      'reviewNotes' => 'required|min:10',
    ], [
      'reviewStatus.required' => 'Keputusan review harus dipilih',
      'reviewStatus.in' => 'Keputusan review tidak valid',
      'reviewNotes.required' => 'Catatan review harus diisi',
      'reviewNotes.min' => 'Catatan review minimal 10 karakter',
    ]);

    // Create review
    BookReview::create([
      'book_submission_id' => $this->submission->id,
      'reviewer_id' => Auth::id(),
      'decision' => $this->reviewStatus,
      'review_notes' => $this->reviewNotes,
      'reviewed_at' => now(),
    ]);

    // Update submission status based on review
    $this->submission->update([
      'status' => $this->reviewStatus === 'approved' ? 'approved' :
        ($this->reviewStatus === 'revision' ? 'revision' : 'rejected'),
    ]);

    session()->flash('success', 'Review berhasil disimpan');

    $this->showReviewForm = false;
    $this->resetReviewForm();
    $this->submission->refresh();
  }

  public function render()
  {
    return view('livewire.book.reviewer-detail');
  }
}
