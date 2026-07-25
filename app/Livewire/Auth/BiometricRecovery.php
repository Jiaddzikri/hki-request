<?php

namespace App\Livewire\Auth;

use App\Models\UserMasterSecret;
use App\Services\HKI\AuditLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class BiometricRecovery extends Component
{
    public $userShareInput = '';

    public function mount()
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $masterSecret = UserMasterSecret::where('user_id', $user->id)->first();
        if (! $masterSecret) {
            session()->flash('error', 'Anda tidak memiliki kunci pemulihan SSS. Ini mungkin karena Anda mendaftarkan biometrik sebelum sistem SSS diaktifkan. Silakan hubungi Admin atau daftarkan ulang biometrik Anda.');
        }
    }

    public function getInstitutionalShareProperty()
    {
        $secret = UserMasterSecret::where('user_id', Auth::id())->first();

        return $secret ? $secret->institutional_share : null;
    }

    public function verifyReconstructedSecret($secretHash, AuditLogService $auditService)
    {
        $user = Auth::user();
        $masterSecret = UserMasterSecret::where('user_id', $user->id)->first();

        if (! $masterSecret || $masterSecret->secret_hash !== $secretHash) {
            $this->addError('recovery', 'Rekonstruksi Kunci Gagal. Kunci Pribadi tidak valid.');

            return;
        }

        DB::beginTransaction();
        try {
            // REVOKE (Disable) old biometric credentials to preserve historical signatures (Forward Secrecy)
            $user->webAuthnCredentials()->update(['disabled_at' => now()]);

            // Delete the master secret to prevent reuse (they will generate a new one during setup)
            $masterSecret->delete();

            // Log this extremely critical action
            $auditService->logActivityGlobal([
                'model_type' => User::class,
                'model_id' => $user->id,
                'user_id' => $user->id,
                'action' => 'Biometric Reset via SSS Recovery',
                'payload' => [
                    'reason' => 'User used Shamirs Secret Sharing recovery process',
                ],
            ]);

            DB::commit();

            session()->flash('success', 'Biometrik berhasil di-reset. Silakan daftarkan perangkat baru Anda.');

            return redirect()->route('setup.security');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('recovery', 'Terjadi kesalahan saat pemulihan: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.biometric-recovery');
    }
}
