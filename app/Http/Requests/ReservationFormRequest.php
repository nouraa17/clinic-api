<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationFormRequest extends FormRequest
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
        if($this->collect($this->getRequestUri())->contains('api')){
            return [
                'clinic_id' => 'required|exists:clinics,id',
                'user_id' => 'required|exists:users,id',
                'age' => 'required|integer|between:1,120',
                'gender' => 'required|in:male,female',
                'specialization' => 'required',
                'time' => 'required|date_format:Y-m-d H:i:s',
            ];
        }
        return [
            'clinic_id' => 'required|exists:clinics,id',
            'user_id' => 'required|exists:users,id',
            'age' => 'required|integer|between:1,120',
            'gender' => 'required|in:male,female',
            'specialization' => 'required',
            'time' => 'required|date_format:Y-m-d\TH:i',
        ];
    }
}
