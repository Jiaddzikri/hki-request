<?php

namespace App\Livewire\Letter;

use App\Models\LTRSubmission;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class LetterList extends Component
{
    use WithPagination;

    public function render()
    {
        $submissions = LTRSubmission::with(['scheme', 'period'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('livewire.letter.letter-list', [
            'submissions' => $submissions
        ]);
    }
}