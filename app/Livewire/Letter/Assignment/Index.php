<?php

namespace App\Livewire\Letter\Assignment;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\LtrAssignmentRequest;

#[Layout('components.layouts.app')]

class Index extends Component
{
  use WithPagination;

  public $search = '';
  public $statusFilter = '';

  public function render()
  {
    $assignments = LtrAssignmentRequest::query()
      ->with(['user', 'members'])
      ->where('user_id', auth()->id())
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
      ->latest()
      ->paginate(10);

    return view('livewire.letter.assignment.index', [
      'assignments' => $assignments
    ]);
  }

  public function deleteAssignment($id)
  {
    $assignment = LtrAssignmentRequest::findOrFail($id);

    if ($assignment->user_id !== auth()->id()) {
      session()->flash('error', 'Unauthorized action');
      return;
    }

    $assignment->delete();
    session()->flash('success', 'Surat ajuan tugas berhasil dihapus');
  }
}
