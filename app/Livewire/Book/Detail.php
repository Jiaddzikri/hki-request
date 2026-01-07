<?php

namespace App\Livewire\Book;

use App\Models\BookSubmission;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
#[Title('Detail Permohonan ISBN')]
class Detail extends Component
{
  use WithFileUploads;

  public BookSubmission $submission;
  public $showDeleteConfirm = false;
  public $isEditMode = false;

  // Form fields for editing (matching database columns)
  public $title;
  public $authors_text;
  public $edition;
  public $series;
  public $publication_year;
  public $pages;  // Maps to total_pages
  public $size;   // Maps to book_height_cm
  public $summary;  // Maps to description
  public $publication_media;
  public $reader_group;
  public $library_type;
  public $library_category;
  public $has_kdt;
  public $estimated_publish_month;
  public $estimated_publish_year;
  public $province;
  public $city;
  public $distributor;

  // File uploads
  public $newCoverFile;
  public $newFullDraftFile;
  public $newAttachmentFile;

  public function mount($id)
  {
    $this->submission = BookSubmission::with([
      'user',
      'authors' => function ($query) {
        $query->ordered();
      },
      'files',
      'reviews' => function ($query) {
        $query->latest('reviewed_at');
      },
      'reviews.reviewer',
      'trackings' => function ($query) {
        $query->latest();
      }
    ])->findOrFail($id);

    // Check authorization
    if ($this->submission->user_id !== auth()->id() && !auth()->user()->hasRole('super-admin|reviewer')) {
      abort(403);
    }
  }

  public function downloadFile($fileId)
  {
    $file = $this->submission->files()->findOrFail($fileId);
    return response()->download(storage_path('app/public/' . $file->file_path));
  }

  public function confirmDelete()
  {
    $this->showDeleteConfirm = true;
  }

  public function cancelDelete()
  {
    $this->showDeleteConfirm = false;
  }

  public function delete()
  {
    // Only allow deletion if status is draft
    if ($this->submission->status !== 'draft') {
      session()->flash('error', 'Hanya pengajuan dengan status draft yang dapat dihapus.');
      return;
    }

    $this->submission->delete();
    session()->flash('message', 'Pengajuan buku berhasil dihapus.');
    return redirect()->route('book.index');
  }

  public function submitForReview()
  {
    // Only allow submission if status is draft
    if ($this->submission->status !== 'draft') {
      session()->flash('error', 'Hanya pengajuan dengan status draft yang dapat diajukan.');
      return;
    }

    // Validate required files
    $hasFullDraft = $this->submission->files()->where('type', 'FULL_DRAFT')->exists();
    $hasCover = $this->submission->files()->where('type', 'COVER')->exists();

    if (!$hasFullDraft || !$hasCover) {
      session()->flash('error', 'File dummy dan cover harus diupload sebelum mengajukan permohonan.');
      return;
    }

    // Update status to submitted
    $this->submission->update(['status' => 'submitted']);

    // Create tracking
    \App\Models\BookTracking::create([
      'book_submission_id' => $this->submission->id,
      'status' => 'submitted',
      'notes' => 'Permohonan ISBN diajukan untuk review',
      'actor_id' => auth()->id(),
    ]);

    $this->submission->refresh();
    session()->flash('success', 'Permohonan ISBN berhasil diajukan untuk review.');
  }

  public function enableEditMode()
  {
    // Only allow edit if status is revision
    if ($this->submission->status !== 'revision') {
      session()->flash('error', 'Hanya pengajuan dengan status revisi yang dapat diubah.');
      return;
    }

    $this->isEditMode = true;

    // Populate form fields with current data (using actual database column names)
    $this->title = $this->submission->title;
    $this->edition = $this->submission->edition;
    $this->series = $this->submission->series;
    $this->publication_year = $this->submission->publication_year;
    $this->pages = $this->submission->total_pages;
    $this->size = $this->submission->book_height_cm;
    $this->summary = $this->submission->description;
    $this->publication_media = $this->submission->publication_media;
    $this->reader_group = $this->submission->reader_group;
    $this->library_type = $this->submission->library_type;
    $this->library_category = $this->submission->library_category;
    $this->has_kdt = $this->submission->has_kdt;
    $this->estimated_publish_month = $this->submission->estimated_publish_month;
    $this->estimated_publish_year = $this->submission->estimated_publish_year;
    $this->province = $this->submission->province;
    $this->city = $this->submission->city;
    $this->distributor = $this->submission->distributor;

    // Get authors as comma-separated text
    $this->authors_text = $this->submission->authors->pluck('name')->implode(', ');
  }

  public function cancelEdit()
  {
    $this->isEditMode = false;
    $this->reset(['newCoverFile', 'newFullDraftFile', 'newAttachmentFile']);
  }

  public function saveRevision()
  {
    // Validate (using only fields that exist in database)
    $this->validate([
      'title' => 'required|string|max:255',
      'publication_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
      'pages' => 'required|integer|min:1',
      'size' => 'nullable|numeric|min:0',
      'summary' => 'required|string|min:50',
      'publication_media' => 'required|in:CETAK,DIGITAL_PDF,DIGITAL_EPUB,AUDIO_BOOK,AUDIO_VISUAL',
      'reader_group' => 'required|in:ANAK,DEWASA,SEMUA_UMUR',
      'library_type' => 'required|in:FIKSI,NON_FIKSI',
      'library_category' => 'required|in:TERJEMAHAN,NON_TERJEMAHAN',
      'has_kdt' => 'required|boolean',
      'estimated_publish_month' => 'nullable|string',
      'estimated_publish_year' => 'nullable|integer|min:' . date('Y') . '|max:' . (date('Y') + 5),
      'province' => 'nullable|string|max:255',
      'city' => 'nullable|string|max:255',
      'distributor' => 'nullable|string|max:255',
      'edition' => 'nullable|string|max:255',
      'series' => 'nullable|string|max:255',
      'authors_text' => 'required|string',
      'newCoverFile' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
      'newFullDraftFile' => 'nullable|file|mimes:pdf|max:10240',
      'newAttachmentFile' => 'nullable|file|mimes:pdf|max:10240',
    ]);

    // Update submission data (using actual database column names)
    $this->submission->update([
      'title' => $this->title,
      'edition' => $this->edition,
      'series' => $this->series,
      'publication_year' => $this->publication_year,
      'total_pages' => $this->pages,  // Database column is total_pages
      'book_height_cm' => $this->size,  // Database column is book_height_cm
      'description' => $this->summary,  // Database column is description
      'publication_media' => $this->publication_media,
      'reader_group' => $this->reader_group,
      'library_type' => $this->library_type,
      'library_category' => $this->library_category,
      'has_kdt' => $this->has_kdt,
      'estimated_publish_month' => $this->estimated_publish_month,
      'estimated_publish_year' => $this->estimated_publish_year,
      'province' => $this->province,
      'city' => $this->city,
      'distributor' => $this->distributor,
    ]);

    // Update authors if changed
    if ($this->authors_text !== $this->submission->authors->pluck('name')->implode(', ')) {
      // Delete old authors
      $this->submission->authors()->delete();

      // Create new authors
      $authorNames = array_map('trim', explode(',', $this->authors_text));
      foreach ($authorNames as $index => $name) {
        if (!empty($name)) {
          \App\Models\BookAuthor::create([
            'book_submission_id' => $this->submission->id,
            'name' => $name,
            'order' => $index + 1,
          ]);
        }
      }
    }

    // Handle file replacements
    if ($this->newCoverFile) {
      $this->replaceFile('COVER', $this->newCoverFile);
    }

    if ($this->newFullDraftFile) {
      $this->replaceFile('FULL_DRAFT', $this->newFullDraftFile);
    }

    if ($this->newAttachmentFile) {
      $this->replaceFile('STATEMENT_LETTER', $this->newAttachmentFile);
    }

    // Update status back to submitted for re-review
    $this->submission->update(['status' => 'submitted']);

    // Create tracking
    \App\Models\BookTracking::create([
      'book_submission_id' => $this->submission->id,
      'status' => 'submitted',
      'notes' => 'Permohonan direvisi dan diajukan kembali untuk review',
      'actor_id' => auth()->id(),
    ]);

    $this->submission->refresh();
    $this->isEditMode = false;
    session()->flash('success', 'Revisi berhasil disimpan dan diajukan kembali untuk review.');
  }

  private function replaceFile($type, $newFile)
  {
    // Delete old file from storage and database
    $oldFile = $this->submission->files()->where('type', $type)->first();
    if ($oldFile) {
      \Storage::disk('public')->delete($oldFile->file_path);
      $oldFile->delete();
    }

    // Store new file
    $path = $newFile->store('book-files', 'public');

    // Create new file record
    \App\Models\BookFile::create([
      'book_submission_id' => $this->submission->id,
      'type' => $type,
      'file_path' => $path,
      'file_name' => $newFile->getClientOriginalName(),
      'file_size' => $newFile->getSize(),
      'uploaded_by' => auth()->id(),
    ]);
  }

  public function render()
  {
    return view('livewire.book.detail');
  }
}
