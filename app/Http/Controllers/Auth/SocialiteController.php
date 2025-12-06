<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use Storage;

class SocialiteController extends Controller
{
    public function redirect() 
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
        $googleUser = Socialite::driver('google')->user();

        if (!str_ends_with($googleUser->getEmail(), 'unsap.ac.id')) {
            return redirect('/login')->with('error', 'Gunakan email kampus!');
        }

        $fileName = '/avatars' . $googleUser->getId() . '.jpg';
        $fileContents = file_get_contents($googleUser->getAvatar());
        Storage::disk('public')->put($fileName, $fileContents);

        $avatarPath = (string) "storage/" . $fileName;

        $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $avatarPath,
                    'password' => null,
                ]
            );

            if ($user->roles->isEmpty()) {
                $user->assignRole('dosen');
            }
            Auth::login($user);

            return redirect()->intended('/dashboard');
        } catch(Exception $error) {
            return redirect('/login')->with('error', 'Login Gagal: ' . $error->getMessage());
        }
    }
}
