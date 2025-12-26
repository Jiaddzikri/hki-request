<?php

namespace App\Livewire\Hki;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\HkiProposal;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();

        $stats = [];
        $recentProposals = [];

        if ($user->hasRole(['super-admin', 'reviewer'])) {

            $stats['total'] = HkiProposal::count();
            $stats['approved'] = HkiProposal::where('status', 'APPROVED')->count();
            $stats['rejected'] = HkiProposal::where('status', 'REJECTED')->count();
            $stats['pending'] = HkiProposal::where('status', 'SUBMITTED')->count();

            $recentProposals = HkiProposal::with('user')
                ->where('status', 'SUBMITTED')
                ->latest()
                ->take(5)
                ->get();

        } else {

            $stats['total'] = HkiProposal::where('user_id', $user->id)->count();
            $stats['approved'] = HkiProposal::where('user_id', $user->id)->where('status', 'APPROVED')->count();
            $stats['rejected'] = HkiProposal::where('user_id', $user->id)->where('status', 'REJECTED')->count();
            $stats['pending'] = HkiProposal::where('user_id', $user->id)->where('status', 'SUBMITTED')->count();

            $recentProposals = HkiProposal::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('livewire.hki.dashboard', [
            'stats' => $stats,
            'recentProposals' => $recentProposals,
            'isOfficial' => $user->hasRole(['super-admin', 'reviewer'])
        ]);
    }
}