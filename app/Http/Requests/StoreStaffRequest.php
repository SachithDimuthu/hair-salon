<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isUpdate = $this->getMethod() === 'PUT' || $this->getMethod() === 'PATCH';
        $staffUserId = $isUpdate ? $this->route('staff')->user_id : null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255',
                Rule::unique('users')->ignore($staffUserId)
            ],
            'password' => [
                $isUpdate ? 'nullable' : 'required',
                'string',
                'min:8',
                'confirmed'
            ],
            'phone' => ['required', 'string', 'max:20'],
            'specialization' => ['required', 'string', 'max:255'],
            'hire_date' => ['required', 'date', 'before_or_equal:today'],
            'commission_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'hire_date' => 'hire date',
            'commission_rate' => 'commission rate',
            'is_active' => 'active status',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'hire_date.before_or_equal' => 'The hire date cannot be in the future.',
            'commission_rate.min' => 'The commission rate must be at least 0%.',
            'commission_rate.max' => 'The commission rate cannot exceed 100%.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
