<?php

namespace App\Http\Requests\Core;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    use PasswordValidationRules;
    use ProfileValidationRules;

    /**
     * Get the validation rules that apply to the request.
     *
     * The password is required on create. On update, leaving it empty keeps
     * the current one.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->userIdToIgnore();
        $profileRules = $this->profileRules($userId);
        $passwordRules = $this->passwordRulesForMethod();

        return [
            ...$profileRules,
            'password' => $passwordRules,
        ];
    }

    /**
     * Ignore the current user when updating so their email stays unique.
     */
    protected function userIdToIgnore(): ?string
    {
        $user = $this->route('user');

        if ($user instanceof User) {
            return $user->id;
        }

        return null;
    }

    /**
     * @return array<int, Password|ValidationRule|array<mixed>|string>
     */
    protected function passwordRulesForMethod(): array
    {
        if ($this->isMethod('post')) {
            return $this->passwordRules();
        }

        return ['nullable', 'string', Password::default(), 'confirmed'];
    }
}
