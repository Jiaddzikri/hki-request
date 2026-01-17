<?php

namespace App\Livewire\Letter\Assignment;

use App\Models\LtrAssignmentRequest;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('components.layouts.app')]

class Detail extends Component
{
  use AuthorizesRequests, WithFileUploads;

  public LtrAssignmentRequest $assignment;
  public bool $isEditMode = false;

  // Edit mode properties
  public $assignment_type;
  public $full_name;
  public $nidn;
  public $faculty;
  public $academic_positions = [];
  public $start_date;
  public $end_date;
  public $academic_year;
  public $institution_name;
  public $institution_address;
  public $research_title;
  public $estimated_budget;
  public $leader_name;
  public $pic_name;
  public $report_file;
  public $publication_link;

  public function mount($id)
  {
    $this->assignment = LtrAssignmentRequest::with(['user', 'members', 'review.reviewer'])->findOrFail($id);

    if ($this->assignment->user_id !== auth()->id()) {
      abort(403, 'Anda tidak memiliki akses untuk melihat ajuan ini.');
    }

    $this->initializeEditProperties();
  }

  protected function initializeEditProperties()
  {
    $this->assignment_type = $this->assignment->assignment_type;
    $this->full_name = $this->assignment->full_name;
    $this->nidn = $this->assignment->nidn;
    $this->faculty = $this->assignment->faculty;
    $this->academic_positions = $this->assignment->academic_positions ?? [];
    $this->start_date = $this->assignment->start_date ? $this->assignment->start_date->format('Y-m-d') : null;
    $this->end_date = $this->assignment->end_date ? $this->assignment->end_date->format('Y-m-d') : null;
    $this->academic_year = $this->assignment->academic_year;
    $this->institution_name = $this->assignment->institution_name;
    $this->institution_address = $this->assignment->institution_address;
    $this->research_title = $this->assignment->research_title;
    $this->estimated_budget = $this->assignment->estimated_budget;
    $this->leader_name = $this->assignment->leader_name;
    $this->pic_name = $this->assignment->pic_name;
    $this->publication_link = $this->assignment->publication_link;
  }

  public function enableEditMode()
  {
    if ($this->assignment->status !== 'REVISION') {
      session()->flash('error', 'Edit mode hanya tersedia untuk ajuan dengan status REVISION.');
      return;
    }

    $this->isEditMode = true;
  }

  public function cancelEdit()
  {
    $this->isEditMode = false;
    $this->initializeEditProperties();
    $this->reset('report_file');
  }

  public function saveRevision()
  {
    $validated = $this->validate([
      'assignment_type' => 'required|in:penelitian,pkm,penunjang,seminar_workshop',
      'full_name' => 'required|string|max:255',
      'nidn' => 'required|string|max:50',
      'faculty' => 'required|string|max:100',
      'academic_positions' => 'required|array|min:1',
      'start_date' => 'required|date',
      'end_date' => 'required|date|after_or_equal:start_date',
      'academic_year' => 'required|string|max:20',
      'institution_name' => 'required|string|max:255',
      'institution_address' => 'required|string',
      'research_title' => 'required|string|max:500',
      'estimated_budget' => 'required|numeric|min:0',
      'leader_name' => 'required|string|max:255',
      'pic_name' => 'required|string|max:255',
      'report_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
      'publication_link' => 'nullable|url|max:500',
    ]);

    if ($this->report_file) {
      if ($this->assignment->report_file_path && \Storage::disk('public')->exists($this->assignment->report_file_path)) {
        \Storage::disk('public')->delete($this->assignment->report_file_path);
      }

      $validated['report_file_path'] = $this->report_file->store('assignment-reports', 'public');
    }

    $this->assignment->update([
      'assignment_type' => $validated['assignment_type'],
      'full_name' => $validated['full_name'],
      'nidn' => $validated['nidn'],
      'faculty' => $validated['faculty'],
      'academic_positions' => $validated['academic_positions'],
      'start_date' => $validated['start_date'],
      'end_date' => $validated['end_date'],
      'academic_year' => $validated['academic_year'],
      'institution_name' => $validated['institution_name'],
      'institution_address' => $validated['institution_address'],
      'research_title' => $validated['research_title'],
      'estimated_budget' => $validated['estimated_budget'],
      'leader_name' => $validated['leader_name'],
      'pic_name' => $validated['pic_name'],
      'publication_link' => $validated['publication_link'] ?? null,
      'report_file_path' => $validated['report_file_path'] ?? $this->assignment->report_file_path,
      'status' => 'SUBMITTED', // Change status back to SUBMITTED after revision
      'submitted_at' => now(),
    ]);

    $this->isEditMode = false;
    $this->assignment->refresh();

    session()->flash('success', 'Revisi berhasil disimpan dan diajukan kembali untuk review.');
  }

  public function downloadReport()
  {
    if (!$this->assignment->report_file_path) {
      session()->flash('error', 'File laporan tidak ditemukan.');
      return;
    }

    return response()->download(storage_path('app/public/' . $this->assignment->report_file_path));
  }

  public function confirmDelete()
  {
    if ($this->assignment->status !== 'DRAFT') {
      session()->flash('error', 'Hanya ajuan dengan status DRAFT yang bisa dihapus.');
      return;
    }

    // Check ownership
    if ($this->assignment->user_id !== auth()->id()) {
      session()->flash('error', 'Anda tidak memiliki akses untuk menghapus ajuan ini.');
      return;
    }

    // Delete associated file if exists
    if ($this->assignment->report_file_path && \Storage::disk('public')->exists($this->assignment->report_file_path)) {
      \Storage::disk('public')->delete($this->assignment->report_file_path);
    }

    $this->assignment->delete();
    session()->flash('success', 'Ajuan berhasil dihapus.');
    return redirect()->route('letter.assignment.index');
  }

  public function submitForReview()
  {
    // Only allow submit if status is DRAFT
    if ($this->assignment->status !== 'DRAFT') {
      session()->flash('error', 'Hanya ajuan dengan status DRAFT yang bisa disubmit.');
      return;
    }

    // Check ownership
    if ($this->assignment->user_id !== auth()->id()) {
      session()->flash('error', 'Anda tidak memiliki akses untuk submit ajuan ini.');
      return;
    }

    $this->assignment->update([
      'status' => 'SUBMITTED',
      'submitted_at' => now(),
    ]);

    session()->flash('success', 'Ajuan berhasil disubmit dan menunggu review.');

    // Refresh the assignment
    $this->assignment->refresh();
  }

  public function render()
  {
    return view('livewire.letter.assignment.detail');
  }
}
