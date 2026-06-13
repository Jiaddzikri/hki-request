<?php

namespace App\Livewire\Hki\Proposal;

use App\Models\HKIProposal;
use App\Models\HKIType;
use App\Services\HKI\AuditLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]

class DetailSimple extends Component
{
    use WithFileUploads;

    public $proposalId;

    public $isEditMode = false;

    // Review fields
    public $showReviewModal = false;

    public $reviewDecision = '';

    public $reviewNotes = '';

    // Member edit
    public $editingMemberId = null;

    public $editMemberName = '';

    public $editMemberRole = '';

    public $editMemberNidn = '';

    // Document replacement
    public $replacingDocumentId = null;

    public $newDocumentFile = null;

    // Form fields for editing
    public $title;

    public $hki_type_id;

    public $publication_country;

    public $publication_city;

    public $publication_date;

    public $description;

    public $auditResults = null;

    public function auditHashChain(AuditLogService $auditLogService)
    {
        $this->auditResults = $auditLogService->verifyChain($this->proposalId);
    }

    public function mount($id)
    {
        $this->proposalId = $id;

        // Check authorization
        $proposal = HKIProposal::findOrFail($id);
        if ($proposal->user_id !== auth()->id() && ! auth()->user()->hasRole('super-admin|reviewer')) {
            abort(403);
        }
    }

    public function enableEditMode()
    {
        $proposal = HKIProposal::findOrFail($this->proposalId);

        // Only allow edit if status is REVISION
        if ($proposal->status !== 'REVISION') {
            session()->flash('error', 'Hanya proposal dengan status revisi yang dapat diubah.');

            return;
        }

        $this->isEditMode = true;

        // Populate form fields with current data
        $this->title = $proposal->title;
        $this->hki_type_id = $proposal->hki_type_id;
        $this->publication_country = $proposal->publication_country;
        $this->publication_city = $proposal->publication_city;
        $this->publication_date = $proposal->publication_date;
        $this->description = $proposal->description;
    }

    public function cancelEdit()
    {
        $this->isEditMode = false;
        $this->reset(['title', 'hki_type_id', 'publication_country', 'publication_city', 'publication_date', 'description']);
    }

    public function initiateSaveRevision()
    {
        $proposal = HKIProposal::findOrFail($this->proposalId);

        if ($proposal->isIntegrityLocked()) {
            session()->flash('error', 'AKSES DIBLOKIR: Proposal ini dikunci oleh sistem karena terdeteksi manipulasi pada rantai audit log. Hubungi Administrator.');

            return;
        }

        $this->validate([
            'title' => 'required|string|max:500',
            'hki_type_id' => 'required|exists:hki_types,id',
            'publication_country' => 'nullable|string|max:2',
            'publication_city' => 'nullable|string|max:100',
            'publication_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $user = Auth::user();
        if ($user->webAuthnCredentials()->count() === 0) {
            session()->flash('error', 'Anda belum mendaftarkan biometrik. Silakan ke pengaturan keamanan.');

            return;
        }

        // Generate standard WebAuthn assertion options
        $options = $user->generateLoginOptions();
        $this->dispatch('webauthn-sign-revision', options: $options);
    }

    public function submitRevisionWithSignature($assertion, AuditLogService $auditLogService)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $credential = $user->validateLogin($assertion);

            if (! $credential) {
                throw new \Exception('Verifikasi biometrik gagal.');
            }

            $proposal = HKIProposal::findOrFail($this->proposalId);

            $proposal->update([
                'title' => $this->title,
                'hki_type_id' => $this->hki_type_id,
                'publication_country' => $this->publication_country,
                'publication_city' => $this->publication_city,
                'publication_date' => $this->publication_date,
                'description' => $this->description,
                'status' => 'SUBMITTED', // Change status back to submitted after revision
            ]);

            // Store Signature Evidence
            $proposal->signatures()->create([
                'user_id' => $user->id,
                'credential_id' => $assertion['id'],
                'signature' => $assertion['response']['signature'],
                'authenticator_data' => $assertion['response']['authenticatorData'],
                'client_data_json' => $assertion['response']['clientDataJSON'],
                'signed_at' => now(),
            ]);

            // Create audit log using service for global chaining
            $auditLogService->logActivityGlobal([
                'model_type' => HKIProposal::class,
                'model_id' => $proposal->id,
                'user_id' => auth()->id(),
                'action' => 'Proposal direvisi dan diajukan ulang',
                'payload' => [
                    'title' => $this->title,
                    'hki_type_id' => $this->hki_type_id,
                    'status' => 'SUBMITTED',
                    'auth_id' => $assertion['id'],
                ],
                'digital_signature' => $assertion['response']['signature'],
            ]);

            DB::commit();
            $this->isEditMode = false;
            session()->flash('success', 'Revisi proposal berhasil disimpan dan divalidasi biometrik.');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Kesalahan Biometrik: '.$e->getMessage());
        }
    }

    public function initiateSubmitReview()
    {
        if (! Gate::allows('review-hki')) {
            session()->flash('error', 'Anda tidak memiliki akses sebagai Reviewer.');

            return;
        }

        $proposal = HKIProposal::findOrFail($this->proposalId);

        if ($proposal->isIntegrityLocked()) {
            session()->flash('error', 'AKSES DIBLOKIR: Proposal ini dikunci oleh sistem karena terdeteksi manipulasi pada rantai audit log. Hubungi Administrator.');

            return;
        }

        // Validation rules
        $rules = [
            'reviewDecision' => 'required|in:approved,rejected,revision',
        ];

        // Notes required for rejection and revision
        if (in_array($this->reviewDecision, ['rejected', 'revision'])) {
            $rules['reviewNotes'] = 'required|string|min:10';
        }

        $this->validate($rules, [
            'reviewDecision.required' => 'Silakan pilih keputusan review',
            'reviewDecision.in' => 'Keputusan review tidak valid',
            'reviewNotes.required' => 'Catatan review wajib diisi untuk keputusan tolak atau revisi',
            'reviewNotes.min' => 'Catatan review minimal 10 karakter',
        ]);

        $user = Auth::user();
        if ($user->webAuthnCredentials()->count() === 0) {
            session()->flash('error', 'Anda belum mendaftarkan biometrik. Silakan ke pengaturan keamanan.');

            return;
        }

        // Generate standard WebAuthn assertion options
        $options = $user->generateLoginOptions();
        $this->dispatch('webauthn-sign-review', options: $options);
    }

    public function submitReviewWithSignature($assertion, AuditLogService $auditLogService)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $credential = $user->validateLogin($assertion);

            if (! $credential) {
                throw new \Exception('Verifikasi biometrik gagal.');
            }

            $proposal = HKIProposal::findOrFail($this->proposalId);

            // Create review record
            \App\Models\HKIReview::create([
                'hki_proposal_id' => $proposal->id,
                'reviewer_id' => Auth::id(),
                'review_notes' => $this->reviewNotes,
                'decision' => $this->reviewDecision,
                'reviewed_at' => now(),
            ]);

            // Update proposal status based on decision
            $statusMap = [
                'approved' => 'APPROVED',
                'rejected' => 'REJECTED',
                'revision' => 'REVISION',
            ];

            $proposal->update([
                'status' => $statusMap[$this->reviewDecision],
            ]);

            // Store Signature Evidence
            $proposal->signatures()->create([
                'user_id' => $user->id,
                'credential_id' => $assertion['id'],
                'signature' => $assertion['response']['signature'],
                'authenticator_data' => $assertion['response']['authenticatorData'],
                'client_data_json' => $assertion['response']['clientDataJSON'],
                'signed_at' => now(),
            ]);

            // Create audit log using service for global chaining
            $auditLogService->logActivityGlobal([
                'model_type' => HKIProposal::class,
                'model_id' => $proposal->id,
                'user_id' => Auth::id(),
                'action' => 'Review: '.strtoupper($this->reviewDecision),
                'payload' => [
                    'decision' => $this->reviewDecision,
                    'review_notes' => $this->reviewNotes,
                    'status' => $statusMap[$this->reviewDecision],
                    'auth_id' => $assertion['id'],
                ],
                'digital_signature' => $assertion['response']['signature'],
            ]);

            DB::commit();
            $this->showReviewModal = false;
            $this->reset(['reviewDecision', 'reviewNotes']);
            session()->flash('success', 'Review berhasil divalidasi biometrik dan disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Kesalahan Biometrik: '.$e->getMessage());
        }
    }

    public function editMember($memberId)
    {
        $proposal = HKIProposal::findOrFail($this->proposalId);

        // Only allow edit if user is owner and status is REVISION
        if ($proposal->user_id !== auth()->id() || $proposal->status !== 'REVISION') {
            session()->flash('error', 'Edit member hanya dapat dilakukan saat status REVISION.');

            return;
        }

        $member = \App\Models\HKIProposalMember::findOrFail($memberId);

        $this->editingMemberId = $memberId;
        $this->editMemberName = $member->name;
        $this->editMemberRole = $member->role;
        $this->editMemberNidn = $member->nidn;
    }

    public function saveMember()
    {
        $this->validate([
            'editMemberName' => 'required|string|max:255',
            'editMemberRole' => 'required|string|max:255',
            'editMemberNidn' => 'nullable|string|max:50',
        ], [
            'editMemberName.required' => 'Nama member wajib diisi',
            'editMemberRole.required' => 'Role member wajib diisi',
        ]);

        try {
            $member = \App\Models\HKIProposalMember::findOrFail($this->editingMemberId);

            $member->update([
                'name' => $this->editMemberName,
                'role' => $this->editMemberRole,
                'nidn' => $this->editMemberNidn,
            ]);

            $this->cancelEditMember();
            session()->flash('success', 'Data member berhasil diupdate.');

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function cancelEditMember()
    {
        $this->reset(['editingMemberId', 'editMemberName', 'editMemberRole', 'editMemberNidn']);
    }

    public function startReplaceDocument($documentId)
    {
        $proposal = HKIProposal::findOrFail($this->proposalId);

        // Only owner can replace documents when status is REVISION
        if ($proposal->user_id !== auth()->id() || $proposal->status !== 'REVISION') {
            session()->flash('error', 'Ganti dokumen hanya dapat dilakukan saat status REVISION.');

            return;
        }

        $this->replacingDocumentId = $documentId;
    }

    public function cancelReplaceDocument()
    {
        $this->reset(['replacingDocumentId', 'newDocumentFile']);
    }

    public function replaceDocument()
    {
        $this->validate([
            'newDocumentFile' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ], [
            'newDocumentFile.required' => 'File wajib dipilih',
            'newDocumentFile.mimes' => 'File harus berformat PDF, DOC, DOCX, JPG, JPEG, atau PNG',
            'newDocumentFile.max' => 'Ukuran file maksimal 10MB',
        ]);

        try {
            $document = \App\Models\HKIProposalDocument::findOrFail($this->replacingDocumentId);

            // Delete old file
            if (\Storage::exists($document->file_path)) {
                \Storage::delete($document->file_path);
            }

            // Upload new file
            $file = $this->newDocumentFile;
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('hki_documents', $fileName, 'public');

            // Update document record
            $document->update([
                'file_path' => $filePath,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'file_hash' => hash_file('sha256', $file->getRealPath()),
            ]);

            $this->cancelReplaceDocument();
            session()->flash('success', 'Dokumen berhasil diganti.');

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function render()
    {
        $proposal = HKIProposal::with([
            'user',
            'type',
            'auditLogs.user',
            'members.user',
            'documents',
        ])->findOrFail($this->proposalId);

        // Load reviews sorted by latest first
        $proposal->load([
            'reviews' => function ($query) {
                $query->with('reviewer')->orderBy('reviewed_at', 'desc');
            },
        ]);

        $hkiTypes = HKIType::all();

        return view('livewire.hki.proposal.detail-simple', [
            'proposal' => $proposal,
            'hkiTypes' => $hkiTypes,
        ]);
    }
}
