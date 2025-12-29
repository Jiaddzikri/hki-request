<?php

namespace App\Livewire\Letter;

use App\Models\LTRSubmission;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LetterDetail extends Component
{
    public $submission;

    public $score = 0;
    public $comment = '';
    public $decision = '';

    public function mount($id)
    {
        $this->submission = LTRSubmission::with([
            'scheme',
            'period',
            'members',
            'budgetDetails',
            'documents',
            'user'
        ])->findOrFail($id);

        $user = Auth::user();
        if ($this->submission->user_id !== $user->id && !$user->hasRole(['reviewer', 'super-admin'])) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function submitReview($decision)
    {
        $this->validate([
            'comment' => 'required|min:10',
            'score' => 'required|numeric|min:0|max:100',
        ]);
        $newStatus = ($decision === 'ACCEPT') ? 'APPROVED' : 'REJECTED';

        $this->submission->update([
            'status' => $newStatus,

        ]);

        session()->flash('success', "Proposal berhasil di-review dengan keputusan: $decision");
    }

    public function render()
    {
        return view('livewire.letter.letter-detail');
    }
}