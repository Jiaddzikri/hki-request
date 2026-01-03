<?php

namespace App\Livewire\Letter;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\LtrSubmission;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]

class Index extends Component
{
  use WithPagination;

  public $search = '';
  public $filterCategory = '';
  public $filterUnit = '';
  public $showModal = false;
  public $selectedSubmission = null;
  public $perPage = 10;

  protected $queryString = [
    'search' => ['except' => ''],
    'filterCategory' => ['except' => ''],
    'filterUnit' => ['except' => ''],
    'perPage' => ['except' => 10],
  ];

  public function updatingSearch()
  {
    $this->resetPage();
  }

  public function updatingFilterCategory()
  {
    $this->resetPage();
  }

  public function updatingFilterUnit()
  {
    $this->resetPage();
  }

  public function updatingPerPage()
  {
    $this->resetPage();
  }

  public function delete($id)
  {
    $submission = LtrSubmission::findOrFail($id);

    // Check if user owns this submission
    if ($submission->user_id !== Auth::id()) {
      session()->flash('error', 'Anda tidak memiliki akses untuk menghapus submission ini.');
      return;
    }

    $submission->delete();
    session()->flash('success', 'Submission berhasil dihapus!');
  }

  public function viewDetail($id)
  {
    $this->selectedSubmission = LtrSubmission::with(['user', 'category', 'unit', 'reviewer'])->findOrFail($id);
    $this->showModal = true;
  }

  public function closeModal()
  {
    $this->showModal = false;
    $this->selectedSubmission = null;
  }

  public function getIndicatorsArray()
  {
    if (!$this->selectedSubmission || !$this->selectedSubmission->indicators) {
      return [];
    }

    // Split by comma and filter empty values, trim whitespace
    return array_filter(array_map('trim', explode(',', $this->selectedSubmission->indicators)));
  }
  public function render()
  {
    $query = LtrSubmission::with(['user', 'category', 'unit'])
      ->where('user_id', Auth::id());

    if ($this->search) {
      $query->where(function ($q) {
        $q->where('description', 'like', '%' . $this->search . '%')
          ->orWhere('indicators', 'like', '%' . $this->search . '%')
          ->orWhere('url_documentation', 'like', '%' . $this->search . '%');
      });
    }

    if ($this->filterCategory) {
      $query->where('ltr_category_id', $this->filterCategory);
    }

    if ($this->filterUnit) {
      $query->where('ltr_unit_id', $this->filterUnit);
    }

    $submissions = $query->latest()->paginate($this->perPage);

    $categories = \App\Models\LtrCategory::all();
    $units = \App\Models\LtrUnit::all();

    return view('livewire.letter.index', [
      'submissions' => $submissions,
      'categories' => $categories,
      'units' => $units,
    ]);
  }
}
