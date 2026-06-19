<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\UserMasterSecret;
use App\Services\HKI\AuditLogService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class UserRecovery extends Component
{
    public User $targetUser;
    public ?string $institutionalShare = null;
    public bool $hasActiveSecret = false;

    public function mount(User $user)
    {
        $this->targetUser = $user;
        $secret = UserMasterSecret::where('user_id', $this->targetUser->id)->first();
        
        if ($secret) {
            $this->hasActiveSecret = true;
            $this->institutionalShare = $secret->institutional_share;
        }
    }

    public function verifyAndReset($secretHash, AuditLogService $auditService)
    {
        $masterSecret = UserMasterSecret::where('user_id', $this->targetUser->id)->first();

        if (! $masterSecret || $masterSecret->secret_hash !== $secretHash) {
            $this->addError('recovery', 'Rekonstruksi Kunci Gagal. Kunci Backup Fisik (Physical Share) tidak valid atau salah.');
            return;
        }

        DB::beginTransaction();
        try {
            // Delete all biometric credentials to reset access
            $this->targetUser->webAuthnCredentials()->delete();

            // Delete the master secret to prevent reuse
            $masterSecret->delete();

            // Log this extremely critical action
            $auditService->logActivityGlobal([
                'model_type' => User::class,
                'model_id' => $this->targetUser->id,
                'user_id' => auth()->id(), // Action done by super admin
                'action' => 'Super Admin Executed SSS Guided Recovery',
                'payload' => [
                    'target_user_id' => $this->targetUser->id,
                    'reason' => 'User lost device. Guided recovery via Institutional Share + Physical Share',
                ],
            ]);

            DB::commit();

            session()->flash('success', 'Biometrik untuk pengguna ' . $this->targetUser->name . ' berhasil di-reset secara paksa (SSS Valid).');
            return redirect()->route('admin.users');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('recovery', 'Terjadi kesalahan internal saat pemulihan: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.user-recovery');
    }
}
