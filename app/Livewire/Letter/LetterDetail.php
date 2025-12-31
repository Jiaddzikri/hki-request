<?php

namespace App\Livewire\Letter;

use App\Models\LTRSubmission;
use App\Models\LTRSubmissionReport;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class LetterDetail extends Component
{
    use WithFileUploads;
    public $submission;
    public $reportFile;
    public $reportNotes;
    public $reportPhase = 'AKHIR';

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

    public function uploadReport()
    {
        $this->validate([
            'reportFile' => 'required|mimes:pdf|max:10240',
            'reportNotes' => 'required|min:10',
        ]);

        $path = $this->reportFile->store('reports', 'public');

        $hash = hash_file('sha256', storage_path('app/public/' . $path));

        LTRSubmissionReport::create([
            'submission_id' => $this->submission->id,
            'phase' => $this->reportPhase,
            'notes' => $this->reportNotes,
            'file_path' => $path,
            'original_name' => $this->reportFile->getClientOriginalName(),
            'file_hash' => $hash,
            'status' => 'PENDING'
        ]);

        $this->reset(['reportFile', 'reportNotes']);
 
        $this->submission->refresh();

        session()->flash('success', 'Laporan berhasil diunggah. Menunggu verifikasi admin.');
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