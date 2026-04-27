<?php

namespace App\Livewire\Hki\Proposal;

use App\Models\HKIProposal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

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
                ->paginate(10),
        ]);
    }
}
