<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laragear\WebAuthn\WebAuthn;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class SetupSecurity extends Component
{
    public bool $registered = false;

    public array $recoveryCodes = [];

    /**
     * Start the WebAuthn registration ceremony.
     */
    public function registerOptions($attachment = null)
    {
        $user = Auth::user();

        // Generate registration options from the package
        $options = $user->generateRegisterOptions();

        // Pass options to frontend to trigger browser's biometric prompt
        $this->dispatch('webauthn-register', options: $options, attachment: $attachment);
    }

    /**
     * Complete the registration after browser response.
     */
    public function completeRegistration($attestation)
    {
        $user = Auth::user();

        DB::beginTransaction();
        try {
            // Verify and save the credential using the package
            $credential = $user->addCredential($attestation);

            // THESIS INNOVATION: Calculate HMAC Checksum (Immutable Anchor)
            // Using APP_KEY as the master secret to prevent admin swapping public keys
            $checksum = hash_hmac(
                'sha256',
                $user->id.$credential->public_key,
                config('app.key')
            );

            $credential->forceFill([
                'public_key_checksum' => $checksum,
            ])->save();

            // THESIS INNOVATION: Generate Recovery Codes
            $this->generateRecoveryCodes($user);

            DB::commit();

            $this->registered = true;
            session()->flash('status', 'Identitas Biometrik Berhasil Dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('registration', 'Gagal mendaftarkan biometrik: '.$e->getMessage());
        }
    }

    protected function generateRecoveryCodes(User $user)
    {
        // Clear old codes if any (Backdoor prevention)
        $user->recoveryCodes()->delete();

        for ($i = 0; $i < 8; $i++) {
            $plainCode = strtoupper(Str::random(4).'-'.Str::random(4));
            $this->recoveryCodes[] = $plainCode;

            $user->recoveryCodes()->create([
                'id' => Str::uuid(),
                'code_hash' => Hash::make($plainCode),
            ]);
        }
    }

    public function finish()
    {
        return redirect()->route('portal');
    }

    public function render()
    {
        return view('livewire.auth.setup-security');
    }
}
