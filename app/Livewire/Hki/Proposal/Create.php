<?php

namespace App\Livewire\Hki\Proposal;

use App\Helpers\Countries;
use App\Models\HKIProposal;
use App\Models\HkiType;
use App\Models\User;
use App\Request\HKI\DecryptPrivateKeyRequest;
use App\Request\HKI\LogActivityRequest;
use App\Services\HKI\AuditLogService;
use App\Services\HKI\KeyManagementService;
use Auth;
use DB;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
class Create extends Component
{
  use WithFileUploads;
  public int $step = 1;
  public $showPinModal = true;
  public $pin = '';
  public $hki_type_parent_id = '';
  public $hki_type_id = '';
  public $title = '';
  public $abstract = '';
  public $publication_date;
  public $publication_city;
  public $publication_country = "ID";
  public $url_detail;


  public $members = [
    ['name' => '', 'nidn' => '', 'npwp' => '', 'nik' => '', 'detail' => '', 'email' => '', 'role' => 'Pencipta Ke 1']
  ];


  public $uploads = [
    'ktp' => null,
    'pernyataan' => null,
    'contoh_ciptaan' => null,
    'pengalihan' => null,
  ];

  public function getAllCountries(): array
  {
    return Countries::countries();
  }

  public function getParentTypesProperty()
  {
    return HkiType::whereNull('parent_id')->get();
  }

  public function getChildTypesProperty()
  {
    if (!$this->hki_type_parent_id)
      return [];
    return HkiType::where('parent_id', $this->hki_type_parent_id)->get();
  }

  public function updatedHkiTypeParentId()
  {
    $this->hki_type_id = '';
  }

  public function nextStep()
  {
    $this->validateStep();
    $this->step++;
  }

  public function prevStep()
  {
    $this->step--;
  }

  public function addMember()
  {
    $this->members[] = ['name' => '', 'nidn' => '', 'nik' => '', 'npwp' => '', 'email' => '', 'detail' => '', 'identifier' => '', 'role' => "Pencipta ke " . count($this->members) + 1];
  }

  public function removeMember($index)
  {
    if ($index > 0) {
      unset($this->members[$index]);
      $this->members = array_values($this->members);
    }
  }

  public function validateStep()
  {
    if ($this->step === 1) {
      $this->validate([
        'hki_type_parent_id' => 'required',
        'hki_type_id' => 'required',
        'title' => 'required',
        'abstract' => 'required',
        'publication_date' => 'required',
        'publication_country' => 'required',
        'publication_city' => 'required'
      ]);
    }

    if ($this->step === 2) {
      $this->validate([
        'members.*.name' => 'required',
        'members.*.nidn' => 'required',
        'members.*.nik' => 'required',
        'members.*.email' => 'required|email',
        'members.*.npwp' => 'required',
        'members.*.detail' => 'required'
      ], [
        'members.*.name.required' => 'Nama tidak boleh kosong',
        'members.*.nidn.required' => 'NIDN tidak boleh kosong',
        'members.*.nik.required' => 'NIK tidak boleh kosong',
        'members.*.email.required' => 'Email tidak boleh kosong',
        'members.*.email.email' => 'Email tidak valid',
        'members.*.npwp.required' => 'NPWP tidak boleh kosong',
        'members.*.detail.required' => 'Detail Pencipta tidak boleh kosong'
      ]);
    }

    if ($this->step === 3) {
      $this->validate([
        'uploads.ktp' => 'required|mimes:pdf,|max:10240',
        'uploads.pernyataan' => 'required|mimes:pdf|max:10240',
        'uploads.contoh_ciptaan' => 'required|mimes:pdf|max:10240',
        'uploads.pengalihan' => 'required|mimes:pdf|max:10240',
        'url_detail' => 'required'
      ], [
        'uploads.ktp.required' => 'Scan KTP wajib diupload',
        'uploads.pernyataan.required' => 'Surat Pernyataan wajib diupload',
        'url_detail.required' => 'Contoh Ciptaan wajib diupload',

      ]);
    }
  }

  public function render()
  {
    return view('livewire.hki.proposal.create');
  }

  public function submitProposal(AuditLogService $auditService)
  {

    $this->validate([
      'pin' => 'required|digits:6',
    ]);

    DB::beginTransaction();

    try {
      $user = User::where('id', Auth::id())->select('private_key_encrypted')->first();

      $keyManagementService = new KeyManagementService();

      $decryptRequest = new DecryptPrivateKeyRequest();
      $decryptRequest->pin = $this->pin;
      $decryptRequest->encryptedKey = $user->private_key_encrypted;

      $keyManagementService->decryptPrivateKey($decryptRequest);

      $proposal = HKIProposal::create([
        'user_id' => Auth::id(),
        'hki_type_id' => $this->hki_type_id,
        'title' => $this->title,
        'description' => $this->abstract,
        'status' => 'SUBMITTED',
        'publication_date' => $this->publication_date,
        'publication_country' => $this->publication_country,
        'publication_city' => $this->publication_city,
        'url_detail' => $this->url_detail
      ]);

      foreach ($this->members as $member) {
        $proposal->members()->create([
          'user_id' => null,
          'name' => $member['name'],
          'nidn' => $member['nidn'],
          'nik' => $member['nik'],
          'npwp' => $member['npwp'],
          'email' => $member['email'],
          'role' => $member['role'],
          'detail' => $member['detail'],
        ]);
      }
      foreach ($this->uploads as $type => $file) {
        if ($file) {
          $hash = hash_file('sha256', $file->getRealPath());

          $path = $file->store('hki-documents/' . $proposal->id, 'public');

          $proposal->documents()->create([
            'name' => strtoupper(str_replace('_', ' ', $type)),
            'file_path' => $path,
            'file_hash' => $hash,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
          ]);
        }
      }

      $request = new LogActivityRequest();
      $request->user = Auth::user();
      $request->action = 'SUBMIT_PROPOSAL';
      $request->modelType = $proposal;
      $request->modelId = $proposal->id;
      $request->payload = $proposal->toArray();
      $request->pin = $this->pin;

      $auditService->logActivity(
        $request
      );

      DB::commit();

      session()->flash('success', 'Proposal Berhasil Diajukan & Ditandatangani Secara Digital!');
      return redirect()->route('hki.list');

    } catch (\Exception $e) {
      DB::rollBack();
      if ($e->getCode() >= 400 && $e->getCode() < 500) {
        $this->addError('pin', $e->getMessage());
      } else {
        $this->addError('server error', 'Terjadi Kesalahan Sistem');
      }
    }
  }
}