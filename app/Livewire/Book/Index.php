<?php

namespace App\Livewire\Book;

use App\Models\BookSubmission;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Permohonan ISBN')]
class Index extends Component
{
  use WithPagination;

  public $search = '';
  public $filterStatus = '';
  public $perPage = 10;

  protected $queryString = [
    'search' => ['except' => ''],
    'filterStatus' => ['except' => ''],
  ];

  public function updatingSearch()
  {
    $this->resetPage();
  }

  public function updatingFilterStatus()
  {
    $this->resetPage();
  }

  public function getBooks()
  {
    $query = BookSubmission::query()
      ->with([
        'user',
        'authors' => function ($query) {
          $query->ordered();
        },
        'trackings' => function ($query) {
          $query->latest()->limit(1);
        }
      ])
      ->where('user_id', auth()->id());

    if ($this->search) {
      $query->where(function ($q) {
        $q->where('title', 'like', '%' . $this->search . '%')
          ->orWhere('isbn_request_type', 'like', '%' . $this->search . '%')
          ->orWhere('publication_media', 'like', '%' . $this->search . '%')
          ->orWhere('description', 'like', '%' . $this->search . '%');
      });
    }

    if ($this->filterStatus) {
      $query->byStatus($this->filterStatus);
    }

    return $query->latest()->paginate($this->perPage);
  }

  public function viewDetail($id)
  {
    return redirect()->route('book.detail', $id);
  }

  public function render()
  {
    return view('livewire.book.index', [
      'submissions' => $this->getBooks(),
    ]);
  }
}
