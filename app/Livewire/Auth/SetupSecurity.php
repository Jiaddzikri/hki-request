<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Request\HKI\EncryptPrivateKeyRequest;
use App\Services\HKI\KeyManagementService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Flux\Flux;

#[Layout('components.layouts.auth')] 
class SetupSecurity extends Component
{
    public string $pin = '';
    public string $pin_confirmation = '';

    public function save(KeyManagementService $keyService)
    {
        $this->validate([
            'pin' => 'required|digits:6|confirmed',
        ]);

        try {
            $keys = $keyService->generateKeyPair();

            $request = new EncryptPrivateKeyRequest();
            $request->privateKey = $keys->privateKey;
            $request->pin = $this->pin;

            $encryptedResponse = $keyService->encryptPrivateKey($request);

            $user = auth()->user();
            
            $user->update([
                'public_key' => $keys->publicKey,
                'private_key_encrypted' => $encryptedResponse->base64,
            ]);

            session()->flash('status', 'Identitas Digital Berhasil Dibuat!');
            
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            if($e->getCode() >= 500) {
            $this->addError('pin', 'Terjadi kesalahan sistem: ');
            } else {
            $this->addError('pin', $e->getMessage());

            }
        } 
    }

    public function render()
    {
        return view('livewire.auth.setup-security');
    }
}