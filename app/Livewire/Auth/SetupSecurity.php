<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
  public function completeRegistration($attestation, $institutionalShare = null, $secretHash = null)
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
        $user->id . $credential->public_key,
        config('app.key')
      );

      $credential->forceFill([
        'public_key_checksum' => $checksum,
      ])->save();

      // THESIS INNOVATION: SSS Institutional Share (Decentralized Recovery)
      if ($institutionalShare && $secretHash) {
        // Delete any old master secret to prevent deadlock issues
        \App\Models\UserMasterSecret::where('user_id', $user->id)->delete();

        \App\Models\UserMasterSecret::create([
          'user_id' => $user->id,
          'secret_hash' => $secretHash,
          'institutional_share' => $institutionalShare,
        ]);
      }

      DB::commit();

      $this->registered = true;
      session()->flash('status', 'Identitas Biometrik Berhasil Dibuat!');

    } catch (\Exception $e) {
      DB::rollBack();
      $this->addError('registration', 'Gagal mendaftarkan biometrik: ' . $e->getMessage());
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
