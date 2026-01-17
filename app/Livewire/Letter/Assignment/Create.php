<?php

namespace App\Livewire\Letter\Assignment;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\LtrAssignmentRequest;
use App\Models\LtrAssignmentMember;

#[Layout('components.layouts.app')]

class Create extends Component
{
  use WithFileUploads;

  // Form fields - Main
  public $assignment_type = '';
  public $full_name = '';
  public $nidn = '';
  public $faculty = '';
  public $academic_positions = [];
  public $start_date = '';
  public $end_date = '';
  public $academic_year = '';

  // Detail Kegiatan
  public $institution_name = '';
  public $institution_address = '';
  public $research_title = '';
  public $estimated_budget = '';
  public $leader_name = '';
  public $pic_name = '';

  // Dokumen
  public $report_file = null;
  public $publication_link = '';

  // Members
  public $members = [];
  public $showAddMemberForm = false;

  // Temporary member form
  public $member_email = '';
  public $member_name = '';
  public $member_nidn_nip_nim = '';
  public $member_faculty = '';
  public $member_academic_positions = [];
  public $member_institutions = [];
  public $member_custom_institution = '';

  public function mount()
  {
    // Pre-fill user data
    $user = auth()->user();
    $this->full_name = $user->name ?? '';

    // Initialize with empty member array
    $this->members = [];
  }

  public function toggleAddMemberForm()
  {
    $this->showAddMemberForm = !$this->showAddMemberForm;
    if (!$this->showAddMemberForm) {
      $this->resetMemberForm();
    }
  }

  public function addMember()
  {
    $this->validate([
      'member_email' => 'required|email',
      'member_name' => 'required|string|max:255',
      'member_nidn_nip_nim' => 'nullable|string|max:50',
      'member_faculty' => 'nullable|string',
      'member_academic_positions' => 'nullable|array|min:1',
      'member_institutions' => 'required|array|min:1',
    ], [
      'member_email.required' => 'Email wajib diisi',
      'member_email.email' => 'Format email tidak valid',
      'member_name.required' => 'Nama wajib diisi',
      'member_institutions.required' => 'Minimal pilih 1 lembaga/instansi',
    ]);

    // Add custom institution if exists
    if ($this->member_custom_institution) {
      $this->member_institutions[] = $this->member_custom_institution;
    }

    $this->members[] = [
      'email' => $this->member_email,
      'name' => $this->member_name,
      'nidn_nip_nim' => $this->member_nidn_nip_nim,
      'faculty' => $this->member_faculty,
      'academic_positions' => $this->member_academic_positions,
      'institutions' => $this->member_institutions,
    ];

    $this->resetMemberForm();
    $this->showAddMemberForm = false;
    session()->flash('member_success', 'Anggota berhasil ditambahkan');
  }

  public function removeMember($index)
  {
    unset($this->members[$index]);
    $this->members = array_values($this->members);
  }

  public function resetMemberForm()
  {
    $this->reset([
      'member_email',
      'member_name',
      'member_nidn_nip_nim',
      'member_faculty',
      'member_academic_positions',
      'member_institutions',
      'member_custom_institution',
    ]);
  }

  public function save()
  {
    $this->validate([
      'assignment_type' => 'required|in:penelitian,pkm,penunjang,seminar_workshop',
      'full_name' => 'required|string|max:255',
      'nidn' => 'required|string|max:50',
      'faculty' => 'required|in:FKIP,FIB,FEB,FISIP,FTI,FIKES',
      'academic_positions' => 'required|array|min:1',
      'start_date' => 'required|date',
      'end_date' => 'required|date|after:start_date',
      'academic_year' => 'required|string|max:20',
      'institution_name' => 'required|string|max:500',
      'institution_address' => 'required|string',
      'research_title' => 'required|string|max:500',
      'estimated_budget' => 'nullable|numeric|min:0',
      'leader_name' => 'required|string|max:255',
      'pic_name' => 'required|string|max:255',
      'report_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
      'publication_link' => 'nullable|url|max:500',
    ], [
      'assignment_type.required' => 'Jenis ajuan wajib dipilih',
      'full_name.required' => 'Nama lengkap wajib diisi',
      'nidn.required' => 'NIDN wajib diisi',
      'faculty.required' => 'Fakultas wajib dipilih',
      'academic_positions.required' => 'Minimal pilih 1 jabatan akademik',
      'start_date.required' => 'Tanggal mulai wajib diisi',
      'end_date.required' => 'Tanggal berakhir wajib diisi',
      'end_date.after' => 'Tanggal berakhir harus setelah tanggal mulai',
      'academic_year.required' => 'Tahun akademik wajib diisi',
      'institution_name.required' => 'Nama instansi/lembaga wajib diisi',
      'institution_address.required' => 'Alamat instansi/lembaga wajib diisi',
      'research_title.required' => 'Judul/tema/topik wajib diisi',
      'leader_name.required' => 'Nama pimpinan wajib diisi',
      'pic_name.required' => 'Nama penanggung jawab wajib diisi',
    ]);

    try {
      $reportPath = null;
      if ($this->report_file) {
        $reportPath = $this->report_file->store('assignment_reports', 'public');
      }

      $assignment = LtrAssignmentRequest::create([
        'user_id' => auth()->id(),
        'assignment_type' => $this->assignment_type,
        'full_name' => $this->full_name,
        'nidn' => $this->nidn,
        'faculty' => $this->faculty,
        'academic_positions' => $this->academic_positions,
        'start_date' => $this->start_date,
        'end_date' => $this->end_date,
        'academic_year' => $this->academic_year,
        'institution_name' => $this->institution_name,
        'institution_address' => $this->institution_address,
        'research_title' => $this->research_title,
        'estimated_budget' => $this->estimated_budget,
        'leader_name' => $this->leader_name,
        'pic_name' => $this->pic_name,
        'report_file_path' => $reportPath,
        'publication_link' => $this->publication_link,
        'status' => 'DRAFT',
      ]);

      // Save members
      foreach ($this->members as $member) {
        LtrAssignmentMember::create([
          'ltr_assignment_request_id' => $assignment->id,
          'email' => $member['email'],
          'name' => $member['name'],
          'nidn_nip_nim' => $member['nidn_nip_nim'] ?? null,
          'faculty' => $member['faculty'] ?? null,
          'academic_position' => $member['academic_positions'] ?? null,
          'institutions' => $member['institutions'],
        ]);
      }

      session()->flash('success', 'Surat ajuan tugas berhasil disimpan sebagai draft');
      return redirect()->route('letter.assignment.index');

    } catch (\Exception $e) {
      session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }

  public function render()
  {
    return view('livewire.letter.assignment.create');
  }
}
