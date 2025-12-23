<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use RyanChandler\LaravelCloudflareTurnstile\Rules\Turnstile;

class ContactFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $turnstileSiteKey = config('services.turnstile.key');
        $turnstileSecretKey = config('services.turnstile.secret');
        $isTurnstileEnabled = !empty($turnstileSiteKey) && !empty($turnstileSecretKey);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'captcha' => ['nullable'],
        ];

        if ($isTurnstileEnabled) {
            $rules['cf-turnstile-response'] = ['required', new Turnstile];
        }

        return $rules;
    }
}
