<?php

namespace App\Livewire\Hki\Proposal;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HKIProposal;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class Lists extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.hki.proposal.list', [
            'proposals' => HKIProposal::with('type') 
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10)
        ]);
    }
}