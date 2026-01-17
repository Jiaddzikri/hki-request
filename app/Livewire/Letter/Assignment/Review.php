<?php

namespace App\Livewire\Letter\Assignment;

use Livewire\Component;
use App\Models\LtrAssignmentRequest;
use App\Models\LtrAssignmentReview;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]

class Review extends Component
{
  public LtrAssignmentRequest $assignment;
  public $review_notes = '';
  public $decision = '';

  public function mount($id)
  {
    $this->assignment = LtrAssignmentRequest::with(['user', 'members', 'review'])->findOrFail($id);

    // Load existing review if any
    if ($this->assignment->review) {
      $this->decision = $this->assignment->review->decision;
      $this->review_notes = $this->assignment->review->notes;
    }
  }

  public function submitReview()
  {
    $this->validate([
      'decision' => 'required|in:APPROVED,REJECTED,REVISION',
      'review_notes' => 'required_if:decision,REJECTED,REVISION|string|max:1000',
    ], [
      'decision.required' => 'Keputusan review wajib dipilih',
      'review_notes.required_if' => 'Catatan review wajib diisi untuk status Rejected atau Revision',
    ]);

    try {
      LtrAssignmentReview::updateOrCreate(
        ['assignment_request_id' => $this->assignment->id],
        [
          'reviewer_id' => auth()->id(),
          'decision' => $this->decision,
          'notes' => $this->review_notes,
          'reviewed_at' => now(),
        ]
      );

      $this->assignment->update([
        'status' => $this->decision,
        'reviewed_at' => now(),
      ]);

      session()->flash('success', 'Review berhasil disubmit. Status ajuan: ' . $this->decision);
      return redirect()->route('letter.assignment.reviewer.inbox');

    } catch (\Exception $e) {
      session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }

  public function downloadReport()
  {
    if (!$this->assignment->report_file_path) {
      session()->flash('error', 'File laporan tidak ditemukan.');
      return;
    }

    return response()->download(storage_path('app/public/' . $this->assignment->report_file_path));
  }

  public function render()
  {
    return view('livewire.letter.assignment.review');
  }
}
