<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laragear\WebAuthn\Contracts\WebAuthnAuthenticatable as WebAuthnContract;
use Laragear\WebAuthn\WebAuthnAuthentication;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements WebAuthnContract
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable, TwoFactorAuthenticatable, WebAuthnAuthentication;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'nidn',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function recoveryCodes()
    {
        return $this->hasMany(UserRecoveryCode::class);
    }

    /**
     * Generate WebAuthn registration options for this user.
     */
    public function generateRegisterOptions(): array
    {
        $creation = new \Laragear\WebAuthn\Attestation\Creator\AttestationCreation(
            user: $this,
            userVerification: \Laragear\WebAuthn\Enums\UserVerification::Preferred
        );

        return app(\Laragear\WebAuthn\Attestation\Creator\AttestationCreator::class)
            ->send($creation)
            ->then(fn ($creation) => $creation->json->toArray());
    }

    /**
     * Verify and add a WebAuthn credential for this user.
     */
    public function addCredential(array $attestation): \Laragear\WebAuthn\Models\WebAuthnCredential
    {
        $validation = new \Laragear\WebAuthn\Attestation\Validator\AttestationValidation(
            $this,
            new \Laragear\WebAuthn\JsonTransport($attestation)
        );

        $credential = app(\Laragear\WebAuthn\Attestation\Validator\AttestationValidator::class)
            ->send($validation)
            ->then(fn ($validation) => $validation->credential);

        $credential->save();

        return $credential;
    }

    /**
     * Generate WebAuthn login options (for digital signature).
     */
    public function generateLoginOptions(): array
    {
        $assertion = new \Laragear\WebAuthn\Assertion\Creator\AssertionCreation(
            user: $this,
            userVerification: \Laragear\WebAuthn\Enums\UserVerification::Preferred
        );

        $result = app(\Laragear\WebAuthn\Assertion\Creator\AssertionCreator::class)
            ->send($assertion)
            ->thenReturn();

        return $result->json->toArray();
    }

    /**
     * Verify a WebAuthn login assertion (digital signature).
     */
    public function validateLogin(array $assertion): ?\Laragear\WebAuthn\Models\WebAuthnCredential
    {
        $validation = new \Laragear\WebAuthn\Assertion\Validator\AssertionValidation(
            new \Laragear\WebAuthn\JsonTransport($assertion),
            $this
        );

        $result = app(\Laragear\WebAuthn\Assertion\Validator\AssertionValidator::class)
            ->send($validation)
            ->thenReturn();

        return $result->credential;
    }
}
