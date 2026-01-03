<?php

namespace App\Livewire\Letter;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\LtrSubmission;
use App\Models\LtrCategory;
use App\Models\LtrUnit;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]

class Create extends Component
{
  public $ltr_category_id;
  public $ltr_unit_id;
  public $description;
  public $indicators;
  public $budget;
  public $planned_start_date;
  public $planned_end_date;
  public $url_documentation;

  public function mount()
  {
    // Initialize dengan user yang sedang login
  }

  public function rules()
  {
    return [
      'ltr_category_id' => 'nullable|exists:ltr_categories,id',
      'ltr_unit_id' => 'nullable|exists:ltr_units,id',
      'description' => 'nullable|string',
      'indicators' => 'nullable|string',
      'budget' => 'nullable|numeric|min:0',
      'planned_start_date' => 'nullable|date',
      'planned_end_date' => 'nullable|date|after_or_equal:planned_start_date',
      'url_documentation' => 'nullable|url',
    ];
  }

  public function save()
  {
    $this->validate();

    try {
      LtrSubmission::create([
        'user_id' => Auth::id(),
        'ltr_category_id' => $this->ltr_category_id,
        'ltr_unit_id' => $this->ltr_unit_id,
        'description' => $this->description,
        'indicators' => $this->indicators,
        'budget' => $this->budget,
        'planned_start_date' => $this->planned_start_date,
        'planned_end_date' => $this->planned_end_date,
        'url_documentation' => $this->url_documentation,
      ]);

      session()->flash('success', 'Submission berhasil dibuat!');

      return redirect()->route('letter.index');
    } catch (\Exception $e) {
      session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }

  public function render()
  {
    $categories = LtrCategory::all();
    $units = LtrUnit::all();

    return view('livewire.letter.create', [
      'categories' => $categories,
      'units' => $units,
    ]);
  }
}
