<?php

namespace App\Livewire\Hki\Reviewer;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HkiProposal;
use Illuminate\Support\Facades\Gate;

#[Layout('components.layouts.app')]

class Inbox extends Component
{
    use WithPagination;

    public $search = '';

    public function mount()
    {
        if (!Gate::allows('review-hki')) {
            abort(403, 'Akses Ditolak. Halaman ini khusus Petugas Reviewer.');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $proposals = HKIProposal::with(['user', 'type'])
            ->where('status', 'SUBMITTED')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.hki.reviewer.inbox', [
            'proposals' => $proposals
        ]);
    }
}