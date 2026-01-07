<?php

namespace App\Livewire\Book;

use App\Models\BookSubmission;
use Livewire\Component;
use Livewire\WithPagination;

class ReviewerIndex extends Component
{
  use WithPagination;

  public $search = '';
  public $statusFilter = '';
  public $isbnTypeFilter = '';
  public $mediaFilter = '';

  protected $queryString = [
    'search' => ['except' => ''],
    'statusFilter' => ['except' => ''],
    'isbnTypeFilter' => ['except' => ''],
    'mediaFilter' => ['except' => ''],
  ];

  public function updatingSearch()
  {
    $this->resetPage();
  }

  public function updatingStatusFilter()
  {
    $this->resetPage();
  }

  public function updatingIsbnTypeFilter()
  {
    $this->resetPage();
  }

  public function updatingMediaFilter()
  {
    $this->resetPage();
  }

  public function resetFilters()
  {
    $this->search = '';
    $this->statusFilter = '';
    $this->isbnTypeFilter = '';
    $this->mediaFilter = '';
    $this->resetPage();
  }

  public function render()
  {
    $submissions = BookSubmission::query()
      ->with(['user', 'authors', 'reviews'])
      // Only show submissions that are in review status or need reviewer attention
      ->whereIn('status', ['submitted', 'review', 'revision'])
      ->when($this->search, function ($query) {
        $query->where(function ($q) {
          $q->where('title', 'like', '%' . $this->search . '%')
            ->orWhere('isbn', 'like', '%' . $this->search . '%')
            ->orWhereHas('user', function ($userQuery) {
              $userQuery->where('name', 'like', '%' . $this->search . '%');
            });
        });
      })
      ->when($this->statusFilter, function ($query) {
        $query->where('status', $this->statusFilter);
      })
      ->when($this->isbnTypeFilter, function ($query) {
        $query->where('isbn_request_type', $this->isbnTypeFilter);
      })
      ->when($this->mediaFilter, function ($query) {
        $query->where('publication_media', $this->mediaFilter);
      })
      ->orderBy('created_at', 'desc')
      ->paginate(15);

    return view('livewire.book.reviewer-index', [
      'submissions' => $submissions,
    ]);
  }
}
