<?php

namespace App\Livewire\Book;

use App\Models\BookSubmission;
use App\Models\BookAuthor;
use App\Models\BookFile;
use App\Models\BookTracking;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

#[Layout('components.layouts.app')]
#[Title('Permohonan ISBN Baru')]
class Create extends Component
{
  use WithFileUploads;

  public $currentStep = 1;

  // Step 1: Informasi ISBN & Kepengarangan
  public $isbn_request_type = 'LEPAS';
  public $title = '';
  public $authors = [];
  public $newAuthorRoleCategory = 'PENULIS';
  public $newAuthorName = '';
  public $newAuthorEmail = '';
  public $newAuthorAffiliation = '';
  public $newAuthorNidnNip = '';
  public $newAuthorIsCorresponding = false;
  public $publication_media = 'CETAK';
  public $reader_group = 'SEMUA_UMUR';
  public $library_type = 'NON_FIKSI';
  public $library_category = 'NON_TERJEMAHAN';
  public $has_kdt = false;

  // Step 2: Detail Publikasi & Spesifikasi
  public $estimated_publish_month = '';
  public $estimated_publish_year = '';
  public $province = '';
  public $city = '';
  public $distributor = '';
  public $description = '';
  public $total_pages = '';
  public $book_height_cm = '';
  public $edition = '';
  public $series = '';
  public $has_illustration = false;
  public $publication_url = '';

  // Step 3: Upload Files
  public $dummyFile; // PDF, EPUB, MP3, MP4, WAV
  public $coverFile;
  public $attachmentFile; // Lampiran: Surat Permohonan, Surat Keaslian, dll

  protected $messages = [
    'title.required' => 'Judul buku harus diisi.',
    'isbn_request_type.required' => 'Jenis permohonan ISBN harus dipilih.',
    'authors.required' => 'Minimal harus ada 1 penulis.',
    'dummyFile.required' => 'File dummy buku harus diupload.',
  ];

  public function mount()
  {
    $this->authors = [];
    $this->estimated_publish_year = date('Y');
  }

  public function nextStep()
  {
    $this->validateCurrentStep();
    $this->currentStep++;
  }

  public function previousStep()
  {
    $this->currentStep--;
  }

  private function validateCurrentStep()
  {
    if ($this->currentStep === 1) {
      $this->validate([
        'isbn_request_type' => 'required|in:LEPAS,JILID',
        'title' => 'required|string|max:255',
        'authors' => 'required|array|min:1',
        'authors.*.name' => 'required|string',
        'authors.*.email' => 'required|email',
        'publication_media' => 'required|in:CETAK,DIGITAL_PDF,DIGITAL_EPUB,AUDIO_BOOK,AUDIO_VISUAL',
        'reader_group' => 'required|in:ANAK,DEWASA,SEMUA_UMUR',
        'library_type' => 'required|in:FIKSI,NON_FIKSI',
        'library_category' => 'required|in:TERJEMAHAN,NON_TERJEMAHAN',
      ]);
    } elseif ($this->currentStep === 2) {
      $this->validate([
        'estimated_publish_month' => 'required|string',
        'estimated_publish_year' => 'required|integer|min:' . date('Y'),
        'province' => 'required|string',
        'city' => 'required|string',
        'description' => 'required|string',
        'total_pages' => 'nullable|integer|min:1',
        'book_height_cm' => 'nullable|numeric|min:1',
      ]);
    } elseif ($this->currentStep === 3) {
      $this->validate([
        'dummyFile' => 'required|mimes:pdf,epub,mp3,mp4,wav|max:51200', // 50MB
        'coverFile' => 'nullable|image|max:2048',
        'attachmentFile' => 'nullable|mimes:pdf|max:10240',
      ]);
    }
  }

  public function addAuthor()
  {
    $this->validate([
      'newAuthorName' => 'required|string|max:255',
      'newAuthorEmail' => 'required|email',
      'newAuthorAffiliation' => 'required|string|max:255',
    ]);

    // If this is the first author or newAuthorIsCorresponding is true, set as corresponding
    $isCorresponding = count($this->authors) === 0 || $this->newAuthorIsCorresponding;

    // If setting new author as corresponding, unset previous corresponding
    if ($isCorresponding && count($this->authors) > 0) {
      foreach ($this->authors as $key => $author) {
        $this->authors[$key]['is_corresponding'] = false;
      }
    }

    $this->authors[] = [
      'role_category' => $this->newAuthorRoleCategory,
      'name' => $this->newAuthorName,
      'email' => $this->newAuthorEmail,
      'affiliation' => $this->newAuthorAffiliation,
      'nidn_nip' => $this->newAuthorNidnNip,
      'is_corresponding' => $isCorresponding,
    ];

    // Reset form
    $this->newAuthorRoleCategory = 'PENULIS';
    $this->newAuthorName = '';
    $this->newAuthorEmail = '';
    $this->newAuthorAffiliation = '';
    $this->newAuthorNidnNip = '';
    $this->newAuthorIsCorresponding = false;
  }

  public function removeAuthor($index)
  {
    unset($this->authors[$index]);
    $this->authors = array_values($this->authors);

    if (count($this->authors) > 0 && !collect($this->authors)->contains('is_corresponding', true)) {
      $this->authors[0]['is_corresponding'] = true;
    }
  }

  public function setCorresponding($index)
  {
    foreach ($this->authors as $key => $author) {
      $this->authors[$key]['is_corresponding'] = ($key === $index);
    }
  }

  public function submit()
  {
    $this->validateCurrentStep();

    try {
      DB::beginTransaction();

      // Create submission
      $submission = BookSubmission::create([
        'user_id' => auth()->id(),
        'title' => $this->title,
        'isbn_request_type' => $this->isbn_request_type,
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
        'description' => $this->description,
        'total_pages' => $this->total_pages,
        'book_height_cm' => $this->book_height_cm,
        'edition' => $this->edition,
        'series' => $this->series,
        'has_illustration' => $this->has_illustration,
        'publication_url' => $this->publication_url,
        'status' => 'draft',
      ]);

      // Add authors
      foreach ($this->authors as $index => $authorData) {
        BookAuthor::create([
          'book_submission_id' => $submission->id,
          'role_category' => $authorData['role_category'],
          'name' => $authorData['name'],
          'email' => $authorData['email'],
          'affiliation' => $authorData['affiliation'],
          'nidn_nip' => $authorData['nidn_nip'] ?? null,
          'position' => $index + 1,
          'is_corresponding' => $authorData['is_corresponding'] ?? false,
        ]);
      }

      // Upload dummy file
      if ($this->dummyFile) {
        $dummyPath = $this->dummyFile->store('book-submissions/' . $submission->id . '/dummy', 'public');
        BookFile::create([
          'book_submission_id' => $submission->id,
          'type' => 'FULL_DRAFT',
          'file_path' => $dummyPath,
          'file_name' => $this->dummyFile->getClientOriginalName(),
          'file_size' => $this->dummyFile->getSize(),
          'version' => 1,
          'uploaded_by' => auth()->id(),
        ]);
      }

      // Upload cover file
      if ($this->coverFile) {
        $coverPath = $this->coverFile->store('book-submissions/' . $submission->id . '/covers', 'public');
        BookFile::create([
          'book_submission_id' => $submission->id,
          'type' => 'COVER',
          'file_path' => $coverPath,
          'file_name' => $this->coverFile->getClientOriginalName(),
          'file_size' => $this->coverFile->getSize(),
          'version' => 1,
          'uploaded_by' => auth()->id(),
        ]);
      }

      // Upload attachment file (Lampiran)
      if ($this->attachmentFile) {
        $attachmentPath = $this->attachmentFile->store('book-submissions/' . $submission->id . '/attachments', 'public');
        BookFile::create([
          'book_submission_id' => $submission->id,
          'type' => 'STATEMENT_LETTER',
          'file_path' => $attachmentPath,
          'file_name' => $this->attachmentFile->getClientOriginalName(),
          'file_size' => $this->attachmentFile->getSize(),
          'version' => 1,
          'uploaded_by' => auth()->id(),
        ]);
      }

      DB::commit();
      BookTracking::create([
        'book_submission_id' => $submission->id,
        'status' => 'draft',
        'notes' => 'Permohonan ISBN dibuat',
        'actor_id' => auth()->id(),
      ]);

      DB::commit();

      session()->flash('message', 'Permohonan ISBN berhasil dibuat.');
      return redirect()->route('book.index');
    } catch (\Exception $e) {
      DB::rollBack();
      session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }

  public function render()
  {
    return view('livewire.book.create');
  }
}
