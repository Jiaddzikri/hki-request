<?php

namespace App\Livewire\Hki\Proposal;

use App\Helpers\Countries;
use App\Models\HKIProposal;
use App\Models\HkiType;
use App\Services\HKI\AuditLogService;
use Auth;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
class Create extends Component
{
    use WithFileUploads;

    public int $step = 1;

    public $hki_type_parent_id = '';

    public $hki_type_id = '';

    public $title = '';

    public $abstract = '';

    public $publication_date;

    public $publication_city;

    public $publication_country = 'ID';

    public $url_detail;

    public $members = [
        ['name' => '', 'nidn' => '', 'npwp' => '', 'nik' => '', 'detail' => '', 'email' => '', 'role' => 'Pencipta Ke 1'],
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
        if (! $this->hki_type_parent_id) {
            return [];
        }

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
        $this->members[] = ['name' => '', 'nidn' => '', 'nik' => '', 'npwp' => '', 'email' => '', 'detail' => '', 'identifier' => '', 'role' => 'Pencipta ke '.(count($this->members) + 1)];
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
                'publication_city' => 'required',
            ]);
        }

        if ($this->step === 2) {
            $this->validate([
                'members.*.name' => 'required',
                'members.*.nidn' => 'required',
                'members.*.nik' => 'required',
                'members.*.email' => 'required|email',
                'members.*.npwp' => 'required',
                'members.*.detail' => 'required',
            ]);
        }

        if ($this->step === 3) {
            $this->validate([
                'uploads.ktp' => 'required|mimes:pdf|max:10240',
                'uploads.pernyataan' => 'required|mimes:pdf|max:10240',
                'uploads.contoh_ciptaan' => 'required|mimes:pdf|max:10240',
                'uploads.pengalihan' => 'required|mimes:pdf|max:10240',
                'url_detail' => 'required',
            ]);
        }
    }

    public function fillDummyData(): void
    {
        $type = HkiType::whereNotNull('parent_id')->inRandomOrder()->first();
        $this->hki_type_parent_id = (string) $type->parent_id;
        $this->hki_type_id = (string) $type->id;

        $this->title = 'Sistem Informasi '.fake()->words(3, true);
        $this->abstract = fake()->paragraph(4);
        $this->publication_date = now()->format('Y-m-d');
        $this->publication_country = 'ID';
        $this->publication_city = fake()->city();
        $this->url_detail = 'https://github.com/unsap/hki-test';

        $this->members = [
            [
                'name' => Auth::user()->name,
                'nidn' => '0412038901',
                'nik' => '3211012345678901',
                'npwp' => '12.345.678.9-012.000',
                'email' => Auth::user()->email,
                'role' => 'Pencipta Ke 1',
                'detail' => 'Dosen Tetap',
            ],
        ];
    }

    public function getSignOptions()
    {
        $user = Auth::user();
        if ($user->webAuthnCredentials()->count() === 0) {
            $this->addError('biometric', 'Anda belum mendaftarkan biometrik. Silakan ke pengaturan keamanan.');

            return;
        }

        // 1. Create Nonce (Anti Replay)
        $nonce = Str::random(32);
        $cacheKey = 'hki_sign_nonce_'.$user->id;
        Cache::put($cacheKey, $nonce, now()->addMinutes(10));

        // 2. Hash Document Data (for integrity verification after signing)
        $proposalData = json_encode([
            'title' => $this->title,
            'abstract' => $this->abstract,
            'members' => $this->members,
            'type' => $this->hki_type_id,
        ]);
        $documentHash = hash('sha256', $proposalData);

        // 3. Store document hash in cache for server-side verification
        Cache::put('hki_sign_hash_'.$user->id, $documentHash, now()->addMinutes(10));

        // 4. Generate standard WebAuthn assertion options
        $options = $user->generateLoginOptions();
        $this->dispatch('webauthn-sign', options: $options);
    }

    public function submitWithSignature($assertion, AuditLogService $auditService)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();

            // 1. Verify Assertion using the package
            $credential = $user->validateLogin($assertion);

            if (! $credential) {
                throw new \Exception('Verifikasi biometrik gagal.');
            }

            // 2. Create Proposal
            $proposal = HKIProposal::create([
                'user_id' => $user->id,
                'hki_type_id' => $this->hki_type_id,
                'title' => $this->title,
                'description' => $this->abstract,
                'status' => 'SUBMITTED',
                'publication_date' => $this->publication_date,
                'publication_country' => $this->publication_country,
                'publication_city' => $this->publication_city,
                'url_detail' => $this->url_detail,
            ]);

            // 3. Store Signature Evidence
            $proposal->signatures()->create([
                'user_id' => $user->id,
                'credential_id' => $assertion['id'],
                'signature' => $assertion['response']['signature'],
                'authenticator_data' => $assertion['response']['authenticatorData'],
                'client_data_json' => $assertion['response']['clientDataJSON'],
                'signed_at' => now(),
            ]);

            // 4. Create Audit Log with Biometric Evidence (Global Chain)
            $auditService->logActivityGlobal([
                'model_type' => HKIProposal::class,
                'model_id' => $proposal->id,
                'action' => 'SUBMIT_PROPOSAL_BIOMETRIC',
                'payload' => [
                    'title' => $this->title,
                    'type_id' => $this->hki_type_id,
                    'auth_id' => $assertion['id'],
                ],
                'digital_signature' => $assertion['response']['signature'],
            ]);

            // Save members and documents...
            $this->saveMembersAndDocuments($proposal);

            DB::commit();
            session()->flash('success', 'Proposal Berhasil Diajukan dengan Tanda Tangan Biometrik!');

            return redirect()->route('hki.list');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('biometric', 'Kesalahan: '.$e->getMessage());
        }
    }

    protected function saveMembersAndDocuments($proposal)
    {
        foreach ($this->members as $member) {
            $proposal->members()->create([
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
                $path = $file->store('hki-documents/'.$proposal->id, 'public');
                $proposal->documents()->create([
                    'name' => strtoupper(str_replace('_', ' ', $type)),
                    'file_path' => $path,
                    'file_hash' => hash_file('sha256', $file->getRealPath()),
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.hki.proposal.create');
    }
}
