<?php

namespace App\Livewire\Letter\Assignment;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LtrAssignmentRequest;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]

class ReviewerInbox extends Component
{
  use WithPagination;

  public $search = '';
  public $statusFilter = '';

  public function render()
  {
    $assignments = LtrAssignmentRequest::with(['user', 'members'])
      ->when($this->search, function ($query) {
        $query->where(function ($q) {
          $q->where('full_name', 'like', '%' . $this->search . '%')
            ->orWhere('research_title', 'like', '%' . $this->search . '%')
            ->orWhere('institution_name', 'like', '%' . $this->search . '%');
        });
      })
      ->when($this->statusFilter, function ($query) {
        $query->where('status', $this->statusFilter);
      })
      ->whereIn('status', ['SUBMITTED', 'APPROVED', 'REJECTED', 'REVISION'])
      ->orderBy('created_at', 'desc')
      ->paginate(15);

    return view('livewire.letter.assignment.reviewer-inbox', [
      'assignments' => $assignments,
    ]);
  }
}
