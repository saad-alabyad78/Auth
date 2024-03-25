<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PhoneNumberRequest extends FormRequest
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
        return [
            'email' => ['required', 'email' , 'exists:users,email'],
            'phone_number' => ['required' , 'min:10' , 'regex:/^(963|0)\d{9}$/'], //TODO:
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number.regex' => 'the phone number must starts with either 963 or 0 followed by 9 digits'
        ];
    }
}
