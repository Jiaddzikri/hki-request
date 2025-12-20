<?php

namespace App\Livewire\Hki;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HKIProposal;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.hki.dashboard', [
            'proposals' => HKIProposal::with('type') 
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10)
        ]);
    }
}