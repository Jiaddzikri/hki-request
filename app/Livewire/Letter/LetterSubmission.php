<?php

namespace App\Livewire\Letter;

use App\Models\LTRAcademicPeriod;
use App\Models\LTRGrantScheme;
use App\Models\LTRSubmission;
use DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class LetterSubmission extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 4;

    public $period;
    public $schemes;

    public $scheme_id;
    public $title;
    public $abstract;

    public $selectedSchemeConfig = null;

    public $members = [];

    public $budgetItems = [];
    public $totalBudget = 0;

    public $proposalFile;

    public function mount()
    {
        $this->period = LTRAcademicPeriod::where('is_active', true)->first();
        $this->schemes = LTRGrantScheme::all();

        if (!$this->period) {
            abort(403, 'Tidak ada periode hibah yang sedang aktif.');
        }

        $this->members[] = [
            'name' => Auth::user()->name,
            'role' => 'KETUA',
            'identifier' => Auth::user()->email,
            'is_locked' => true
        ];

        $this->budgetItems[] = [
            'description' => '',
            'volume' => 1,
            'unit' => 'Paket',
            'unit_cost' => 0,
            'total' => 0
        ];
    }

    public function updatedSchemeId($value)
    {
        $this->selectedSchemeConfig = $this->schemes->find($value);
    }

    public function addMember()
    {
        $this->members[] = [
            'name' => '',
            'role' => 'ANGGOTA',
            'identifier' => '',
            'is_locked' => false
        ];
    }

    public function removeMember($index)
    {
        if (!$this->members[$index]['is_locked']) {
            unset($this->members[$index]);
            $this->members = array_values($this->members);
        }
    }

    public function updatedBudgetItems()
    {
        $total = 0;
        foreach ($this->budgetItems as $key => $item) {
            $subtotal = (int) $item['volume'] * (int) $item['unit_cost'];
            $this->budgetItems[$key]['total'] = $subtotal;
            $total += $subtotal;
        }
        $this->totalBudget = $total;
    }

    public function addBudgetItem()
    {
        $this->budgetItems[] = [
            'description' => '',
            'volume' => 1,
            'unit' => 'Item',
            'unit_cost' => 0,
            'total' => 0
        ];
    }

    public function removeBudgetItem($index)
    {
        unset($this->budgetItems[$index]);
        $this->budgetItems = array_values($this->budgetItems);
        $this->updatedBudgetItems();
    }

    public function nextStep()
    {
        $this->validateStep($this->currentStep);
        $this->currentStep++;
    }

    public function prevStep()
    {
        $this->currentStep--;
    }

    public function validateStep($step)
    {
        if ($step == 1) {
            $this->validate([
                'title' => 'required|min:10',
                'abstract' => 'required',
                'scheme_id' => 'required',
            ]);
        }

        if ($step == 2) {
            $this->validate([
                'members.*.name' => 'required',
                'members.*.role' => 'required',
            ]);
        }

        if ($step == 3) {
            $this->validate([
                'budgetItems.*.description' => 'required',
                'budgetItems.*.unit_cost' => 'required|numeric|min:0',
            ]);

            if ($this->selectedSchemeConfig && $this->totalBudget > $this->selectedSchemeConfig->max_budget) {
                $this->addError('totalBudget', 'Total RAB melebihi batas maksimal skema (Rp ' . number_format($this->selectedSchemeConfig->max_budget) . ')');
                return false;
            }
        }
    }

    public function submit()
    {
        $this->validate(['proposalFile' => 'required|mimes:pdf|max:5120']);

        DB::transaction(function () {

            $submission = LTRSubmission::create([
                'user_id' => Auth::id(),
                'academic_period_id' => $this->period->id,
                'grant_scheme_id' => $this->scheme_id,
                'title' => $this->title,
                'abstract' => $this->abstract,
                'total_budget_proposed' => $this->totalBudget,
                'status' => 'SUBMITTED'
            ]);


            foreach ($this->members as $mem) {
                $submission->members()->create([
                    'name' => $mem['name'],
                    'role' => $mem['role'],
                    'identifier_number' => $mem['identifier'],
                ]);
            }

            foreach ($this->budgetItems as $rab) {
                $submission->budgetDetails()->create([
                    'item_description' => $rab['description'],
                    'volume' => $rab['volume'],
                    'unit' => $rab['unit'],
                    'unit_cost' => $rab['unit_cost'],
                    'total_cost' => $rab['total'],
                    'category' => 'UMUM'
                ]);
            }

            $path = $this->proposalFile->store('proposals', 'public');
            $submission->documents()->create([
                'type' => 'PROPOSAL_FULL',
                'file_path' => $path,
                'original_name' => $this->proposalFile->getClientOriginalName(),
                'file_size' => $this->proposalFile->getSize(),
            ]);
        });

        return redirect()->route('grants.list')->with('success', 'Proposal berhasil diajukan!');
    }

    public function render()
    {
        return view('livewire.letter.letter-submission');
    }
}