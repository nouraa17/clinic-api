<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UserFormRequest extends FormRequest
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
        if (Str::contains(request()->getRequestUri(), 'login')) {
            return [
                'email' => 'required|email',
                'password' => 'required',
            ];
        }
        return [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required',
            'password' => 'filled',
            'type' => 'required',
        ];
    }
}
