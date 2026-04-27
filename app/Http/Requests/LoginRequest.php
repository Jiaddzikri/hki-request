<?php

namespace App\Http\Requests;

use App\Rules\Turnstile;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;

class LoginRequest extends FortifyLoginRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();

        if (config('services.turnstile.enforce', true) && ! app()->runningUnitTests()) {
            $rules['cf-turnstile-response'] = ['required', 'string', new Turnstile];
        }

        return $rules;
    }
}
