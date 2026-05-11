<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"=> "required|string|max:255",
            "email"=> "required|string|email|unique:users",
            "password"=> "required|string|min:8",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Name is required.",
            "name.string" => "Name must be a string.",
            "name.max" => "Name must not exceed 255 characters.",
            "email.required" => "Email is required.",
            "email.string" => "Email must be a string.",
            "email.email" => "Email must be a valid email address.",
            "email.unique" => "Email has already been taken.",
            "password.required" => "Password is required.",
            "password.string" => "Password must be a string.",
            "password.min" => "Password must be at least 8 characters long.",
        ];
    }
}
