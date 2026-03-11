<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'email' => ['sometimes', 'email', Rule::unique(User::class, 'email')->where('id', $this->user->id)->ignore($this->user)],
            'password' => ['sometimes', 'string'],
            'phone' => ['sometimes', 'integer', 'regex:/^7\d{10,14}$/', (Rule::unique(User::class, 'phone')->where('id', $this->user->id)->ignore($this->user))],
        ];
    }
}
