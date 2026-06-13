<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Biometrics extends Component
{
    public function delete($id)
    {
        $user = Auth::user();
        $credential = $user->webAuthnCredentials()->find($id);

        if ($credential) {
            $credential->delete();

            // If no more credentials, also clear the SSS master secret to prevent leftovers
            if ($user->webAuthnCredentials()->count() === 0) {
                \App\Models\UserMasterSecret::where('user_id', $user->id)->delete();
            }

            session()->flash('status', 'Biometrik berhasil dihapus.');
        }
    }

    public function render()
    {
        return view('livewire.settings.biometrics', [
            'credentials' => Auth::user()->webAuthnCredentials()->get(),
        ]);
    }
}
