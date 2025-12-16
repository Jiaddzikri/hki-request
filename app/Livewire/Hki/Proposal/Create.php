<?php

namespace App\Livewire\Hki\Proposal;

use App\Models\HkiType;
use Livewire\Component;
use Livewire\Attributes\Layout;
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
    public $meta_data = [];

    public $members = [
        ['name' => '', 'nidn' => '', 'npwp' => '', 'nik' => '', 'detail' => '', 'email' => '', 'role' => 'Pencipta Ke 1']
    ];


    public $uploads = [
        'ktp' => null,
        'pernyataan' => null,
        'contoh_ciptaan' => null,
        'pengalihan' => null,
        'link_ciptaan' => null,
    ];

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
                'uploads.link_ciptaan' => 'required'
            ], [
                'uploads.ktp.required' => 'Scan KTP wajib diupload',
                'uploads.pernyataan.required' => 'Surat Pernyataan wajib diupload',
                'uploads.contoh_ciptaan.required' => 'Contoh Ciptaan wajib diupload',
                'uploads.link_ciptaan.required' => 'Link wajib diisi'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.hki.proposal.create');
    }
}